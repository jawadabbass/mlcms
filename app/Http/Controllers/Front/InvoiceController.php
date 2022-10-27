<?php

namespace App\Http\Controllers\Front;

use App\ContactBlockIps;
use App\Mail\ContactUs;
use App\Models\Back\CmsModuleData;
use App\Models\Back\ContactUsRequest;
use App\Models\Back\Invoice;
use App\Models\Back\InvoiceTransaction;
use App\Models\Back\InvoicePayment;
use App\Classes\paypal_lib;
use App\Models\Back\Metadata;
use App\Models\Back\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;

class InvoiceController extends Controller
{
    public function paypal($slug)
    {
        $invoiceObj = Invoice::where('invoice_webkey', $slug)->firstOrFail();
        $seoArr = ['title' => 'Invoice'];
        $paypalLib = new paypal_lib();

        $returnURL = base_url() . 'invoice/success/' . $invoiceObj->invoice_webkey; //payment success url
        $cancelURL = base_url() . 'invoice/cancel/' . $invoiceObj->invoice_webkey; //payment cancel url
        $notifyURL = base_url() . 'invoice/ipn'; //ipn url
        $logo = base_url() . 'public/images/Untitled-1.png';


        $paypalLib->add_field('business', get_meta_val('paypal_email'));
        $paypalLib->add_field('return', $returnURL);
        $paypalLib->add_field('cancel_return', $cancelURL);
        $paypalLib->add_field('notify_url', $notifyURL);
        $paypalLib->add_field('item_name', config('Constants.SITE_NAME'));
        //$paypalLib->add_field('custom', $userID);
        $paypalLib->add_field('item_number', $invoiceObj->invoice_id);
        $paypalLib->add_field('email', $invoiceObj->email_address);
        $paypalLib->add_field('first_name', '');
        $paypalLib->add_field('no_shipping', 1);

        $paypalLib->add_field('amount', $invoiceObj->amount);

        $paypalLib->image($logo);
        $paypalLib->paypal_auto_form();
        exit;
    }
    function payment_success($slug)
    {
        $seoArr = ['title' => config('Constants.SITE_NAME') . ': Payment Paid Successfully'];
        $heading = config('Constants.SITE_NAME') . ': Payment Paid Successfully';
        $editPageID = 118;
        return view('front.invoice.payment_paypal_success', compact('seoArr', 'editPageID', 'slug'));
    }
    function payment_cancel($slug)
    {
        $invoiceObj = Invoice::where('invoice_webkey', $slug)
            ->where('status', '<>', 'Paid')
            ->firstOrFail();
        $invoiceObj->status = 'Canceled';
        $invoiceObj->save();
        $seoArr = ['title' => config('Constants.SITE_NAME') . ': Payment Paid Canceled'];
        $heading = config('Constants.SITE_NAME') . ': Payment Paid Canceled';
        $editPageID = 118;
        return view('front.invoice.payment_paypal_canceled', compact('seoArr', 'editPageID', 'slug'));
    }
    function payment_ipn()
    {
        $paypalInfo = $_POST;

        //        $this->send_email('1');
        //        exit;
        $invoice_id = $paypalInfo["item_number"];

        $paypalLib = new paypal_lib();
        $paypalURL = $paypalLib->paypal_url;
        $result = $paypalLib->curlPost($paypalURL, $paypalInfo);

        //check whether the payment is verified
        if (eregi("VERIFIED", $result)) {

            if (isset($paypalInfo["payment_status"])) {
                // check notification type
                if ($paypalInfo["payment_status"] == 'Completed') {
                    $invoiceObj = Invoice::where('invoice_id', $invoice_id)->first();
                    $transactionObj = new InvoiceTransaction;
                    $transactionObj->fk_invoice_id = $invoice_id;
                    $transactionObj->fk_payment_option_id = 2;
                    $transactionObj->transaction_number = $paypalInfo["item_number"];
                    $transactionObj->scanned_copy = '';
                    $transactionObj->details = json_encode($paypalInfo);
                    $transactionObj->save();
                }
            } else if (isset($paypalInfo["txn_type"]) && $paypalInfo["txn_type"] == 'subscr_cancel') {
                //                if($invoice_row->status != 'Canceled'){
                //                    $data_array['status']='Canceled';
                //                    $this->invoice_model->update($invoice_row->id, $data_array);
                //                }
            }
        } else {
            //$paypalLib->log_ipn_results(false);
        }
    }
    public function authorize_net($slug)
    {
        $invoiceObj = Invoice::where('invoice_webkey', $slug)->firstOrFail();
        $invoicePayment = InvoicePayment::where('fk_invoice_id', $invoiceObj->id)
            ->where('fk_payment_option_id', 5)
            ->firstOrFail();
        $seoArr = ['title' => 'Invoice'];
        $editPageID = 118;
        return view('front.invoice.authorize_form', compact('seoArr', 'editPageID', 'invoiceObj', 'slug'));
    }
    public function post_authorize_net(Request $request)
    {
        $paymentOption = 5;
        $invoiceObj = Invoice::where('invoice_webkey', $request->invoice_id)
            ->where('status', '<>', 'Paid')
            ->firstOrFail();
        if ($this->paymentMethodSelected($invoiceObj->id, $paymentOption)) {
            $msg = "Invoice not found with this payment method.";
            echo json_encode(['status' => false, 'error' => $msg]);
            exit;
        }


        $paymentDone = false;
        $paymentErrorMsg = '';
        //>>>>>>>>>>>>>>>>> **Start** Authorize.netPayment
        // Common setup for API credentials
        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $merchantAuthentication->setName(get_meta_val('authorize_net_login_id'));
        $merchantAuthentication->setTransactionKey(get_meta_val('authorize_net_trans_id'));
        $refId = 'ref' . rand(1111111, 9999999) . time();
        // Create the payment data for a credit card
        $creditCard = new AnetAPI\CreditCardType();
        $creditCard->setCardNumber($request->creditCardNo);
        $creditCard->setCardCode($request->cvvNumber);
        //         $creditCard->setExpirationDate( "2038-12");
        $ssl_exp_date = $request->expYear . '-' . $request->expMonth;
        $creditCard->setExpirationDate($ssl_exp_date);
        $paymentOne = new AnetAPI\PaymentType();
        $paymentOne->setCreditCard($creditCard);
        // Create a transaction
        $transactionRequestType = new AnetAPI\TransactionRequestType();
        $transactionRequestType->setTransactionType("authCaptureTransaction");
        //        $transactionRequestType->setAmount('60');
        $transactionRequestType->setAmount($invoiceObj->amount);
        $transactionRequestType->setPayment($paymentOne);
        $requestAPI = new AnetAPI\CreateTransactionRequest();
        $requestAPI->setMerchantAuthentication($merchantAuthentication);
        $requestAPI->setRefId($refId);
        $requestAPI->setTransactionRequest($transactionRequestType);
        $controller = new AnetController\CreateTransactionController($requestAPI);

        $response = (object)[];
        if (get_meta_val('authorize_test') == 'Yes') {
            $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);
        } else {
            $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::PRODUCTION);
        }

        if ($response != null) {
            // Check to see if the API request was successfully received and acted upon
            if ($response->getMessages()->getResultCode() == "Ok") {
                // Since the API request was successful, look for a transaction response
                // and parse it to display the results of authorizing the card
                $tresponse = $response->getTransactionResponse();

                if ($tresponse != null && $tresponse->getMessages() != null) {
                    $paymentDone = true;
                    $paymentErrorMsg = '';
                    $resp = json_encode($tresponse->getMessages());
                    $payInvoice = new InvoiceTransaction;
                    $payInvoice->fk_invoice_id = $invoiceObj->id;
                    $payInvoice->fk_payment_option_id = $paymentOption;
                    $payInvoice->details = $resp;
                    $payInvoice->save();
                    $invoiceObj->status = 'Paid';
                    $invoiceObj->save();
                    $status = 'SUCCESS';
                    $msg = "Thank You for Payment. We have successfully received your Order.";
                    echo json_encode(['status' => true, 'error' => $msg]);
                    exit;
                    return;
                } else {
                    $paymentErrorMsg .= "Transaction Failed <br/>";
                    if ($tresponse->getErrors() != null) {
                        $paymentErrorMsg .= " Error Code  : " . $tresponse->getErrors()[0]->getErrorCode() . "<br/>";
                        $paymentErrorMsg .= "<strong>Error Message:</strong> " . $tresponse->getErrors()[0]->getErrorText() . "<br/>";
                    }
                }
                // Or, print errors if the API request wasn't successful
            } else {
                $paymentErrorMsg .= "Transaction Failed <br/>";
                $tresponse = $response->getTransactionResponse();

                if ($tresponse != null && $tresponse->getErrors() != null) {
                    $paymentErrorMsg .= " Error Code  : " . $tresponse->getErrors()[0]->getErrorCode() . "<br/>";
                    $paymentErrorMsg .= "<strong>Error Message:</strong> " . $tresponse->getErrors()[0]->getErrorText() . "<br/>";
                } else {
                    $paymentErrorMsg .= " Error Code  : " . $response->getMessages()->getMessage()[0]->getCode() . "<br/>";
                    $paymentErrorMsg .= "<strong>Error Message:</strong> " . $response->getMessages()->getMessage()[0]->getText() . "<br/>";
                }
            }
        } else {
            $paymentErrorMsg .=  "No response returned <br/>";
        }
        //<<<<<<<<<<<<<<<<< ***End*** Authorize.netPayment


        if ($paymentDone == false) {
            $msg = $paymentErrorMsg;
            $campingReservation->comment = $msg;
            $campingReservation->status = 1;
            $campingReservation->payment_status = 0;
            $campingReservation->save();
            $status = 'ERROR';
            echo json_encode(['status' => false, 'error' => $msg]);
            return;
        }
    }
    function paymentMethodSelected($invoiceID, $paymentID)
    {
        return InvoicePayment::where('fk_invoice_id', $invoiceID)->where('fk_payment_option_id', $paymentID)->doesntExist();
    }
    function stripe($slug)
    {
        $invoiceObj = Invoice::where('invoice_webkey', $slug)->firstOrFail();
        $seoArr = ['title' => 'Invoice'];
        $editPageID = 118;
        return view('front.invoice.stripe', compact('invoiceObj', 'seoArr', 'editPageID'));
    }
    function stripePost()
    {
    }
}

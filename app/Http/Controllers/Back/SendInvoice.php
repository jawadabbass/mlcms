<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmailInvoice;
use App\Models\Back\Metadata;
use Illuminate\Support\Facades\Validator;

class SendInvoice extends Controller
{
	public function index($value = '')
	{
		$seoArr = [];
		$title = 'Send Invoice';
		return view('back.send_invoice.index', compact('seoArr', 'title'));
	}
	public function invoice($value = '')
	{
		$seoArr = [];
		$title = 'Send Invoice';
		return view('back.send_invoice.invoice', compact('seoArr', 'title'));
	}
	public function post(Request $request)
	{

		$validator = Validator::make(
			$request->all(),
			[
				'client_name' => 'required',
				'case_reference' => 'required',
				'client_email' => 'required|email',
				'amount' => 'required',
				'comments' => 'required',
				'payment_options' => 'required'
			]
		);

		if ($validator->fails()) {
			$errMsg = '';
			foreach ($validator->getMessageBag()->toArray() as $key => $value) {
				$errMsg .= '*' . $value[0] . "<br/>";
			}
			echo json_encode(array(
				'success' => 'error',
				'errormsg' => $errMsg
			));
			exit;
		}
		// $boot = new bootstrap();
		// $admininfo = $boot->getAdminInfo();			
		// $emlObject = new sendInvoiceEml( $request , $admininfo );
		// Message::setResponseMessage("Invoice Sent Successfully",'s');
		//>>>>>>>>>>>>>>>>> **Start** EMAIL
		$formValues = $_POST;

		$invoiceSettingsData  = Metadata::where('data_key', 'invoiceSettings')->first()->val1;
		$invoiceSettingsDataArray = json_decode($invoiceSettingsData, true);

		$invoiceContentData  = Metadata::where('data_key', 'invoiceContent')->first()->val1;
		$invoiceContentDataArray = json_decode($invoiceContentData, true);

		$payment_options = '';
		if (in_array('pay_pal_info', $formValues['payment_options'])) {

			$business = $invoiceSettingsDataArray['pay_pal_info'];
			$client_name = $formValues['client_name'];
			$case_reference = $formValues['case_reference'];
			$client_email = $formValues['client_email'];
			$amount = str_replace('$', '', $formValues['amount']);
			$pp_url = base_url() . 'process_paypal?business=' . urlencode($business) . '&client_name=' . urlencode($client_name) . '&case_reference=' . urlencode($case_reference) . '&client_email=' . urlencode($client_email) . '&amount=' . urlencode($amount);

			$payment_options .= '<u>Credit Card or Paypal:</u>&nbsp;&nbsp;&nbsp;<a href="' . $pp_url . '">Click here to pay with PayPal.</a><br><br>';
		}
		if (in_array('bank_info', $formValues['payment_options'])) {
			$payment_options .= '<u>For payment by Bank Transfer or Deposit, transfer funds to:</u><br>' . nl2br($invoiceSettingsDataArray['bank_info']) . '<br><br>';
		}
		if (in_array('check_mail', $formValues['payment_options'])) {
			$payment_options .= '<u>Mail Check to:</u><br>' . nl2br($invoiceSettingsDataArray['check_mail']) . '<br><br>';
		}


		$msg_body = stripslashes($invoiceContentDataArray['invoice_content']);
		$msg_body = str_replace('{client_name}', $formValues['client_name'], $msg_body);
		$msg_body = str_replace('{case_reference}', $formValues['case_reference'], $msg_body);
		$msg_body = str_replace('{client_email}', $formValues['client_email'], $msg_body);
		$msg_body = str_replace('{amount}', $formValues['amount'], $msg_body);
		$msg_body = str_replace('{payment_options}', $payment_options, $msg_body);
		if (trim($formValues['comments']) != '') {
			$msg_body = str_replace('{comments}', '<strong><u>Comments:</u></strong>&nbsp;&nbsp;&nbsp;' . nl2br($formValues['comments']) . '<br><br>', $msg_body);
		} else {
			$msg_body = str_replace('{comments}', '', $msg_body);
		}
		$emailTemplate = $msg_body;
		$subject = "Invoice for Case Number :" . $formValues['case_reference'];
		cp($emailTemplate);


		//<<<<<<<<<<<<<<<<< ***End*** EMAIL

		$mail = Mail::to($request->client_email);
		$mail->send(new SendEmailInvoice($request->all(), $request->ip(), $subject, $emailTemplate));
		echo json_encode(['success' => 'done', 'smsg' => 'Invoice Sent Successfully']);
		return;
	}
}

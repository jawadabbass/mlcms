<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Back\Invoice;
use App\Models\Back\PaymentOption;
use App\Models\Back\Metadata;
use App\Models\Back\InvoicePayment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmailInvoice;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = FindInsettingArr('business_name') . ': Invoices';
        $msg = '';

        $result = Invoice::where('id', '<>', '0')->paginate(20);
        $PaymentArr = InvoicePayment::selectRaw("CONCAT(fk_invoice_id,'_',fk_payment_option_id) AS inv,id")->whereIn('fk_payment_option_id', [2, 5])->pluck('id', 'inv')->toArray();
        return view('back.invoice.index_view', compact('title', 'msg', 'result', 'PaymentArr'));
    }
    public function create()
    {
        // $data = array();
        // $data['msg'] = '';
        // $title = config("Constants.SITE_NAME") . ': Add | Invoice';
        // return view('back.invoice.add',compact('title','data'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'email' => 'nullable|email|unique:clients,email',
            ],
            [
                'email.unique' => 'Invoice email address already exists'
            ],
            [
                'unique' => 'Invoice email address already exists'
            ]
        );


        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }



        $clientObj = new Invoice;
        $clientObj->name = $request->name;
        $clientObj->email = $request->email;
        $clientObj->phone = $request->phone;
        $clientObj->comments = $request->comments;
        $clientObj->city = '';
        $clientObj->country = '';
        $clientObj->ip = $request->ip();
        $clientObj->dated = $request->dated;
        $clientObj->added_by = Auth::user()->id;
        $clientObj->lead_id = 0;
        // $clientObj->dated=$request->dated;
        $clientObj->save();

        // insertHistory(
        //     'client_added_backend',['{NAME_OF_BUSSINESS}'=>$contact->name_of_buss],
        //     $contact->id,$contact->u_type,Auth::user()->id
        // );

        session(['message' => 'Added Successfully', 'type' => 'success']);
        return redirect(route('manage_clients.index'));
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $level = 1;
        $title = FindInsettingArr('business_name') . ': Payment Options | Details';
        $client = Invoice::find($id);
        $clientName = '';
        $historyArr = [];
        $PaymentArr = InvoicePayment::selectRaw("CONCAT(fk_invoice_id,'_',fk_payment_option_id) AS inv,id")->whereIn('fk_payment_option_id', [2, 5])->pluck('id', 'inv')->toArray();
        $bcArr = array('invoice' => 'Invoices');
        return view('back.invoice.show', compact('client', 'title', 'bcArr', 'level', 'historyArr', 'clientName', 'PaymentArr'));
    }
    public function status(Request $request)
    {
        $clientObj = Invoice::find($request->idds);
        if ($clientObj) {
            $clientObj->status = $request->sts;
            $clientObj->save();

            echo json_encode(array(
                'success' => 'done',
                'errormsg' => 'DONE'
            ));
        } else {
            echo json_encode(array(
                'success' => 'error',
                'errormsg' => 'Record not found.'
            ));
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = array();
        $data['msg'] = '';
        $clientObj = Invoice::find($id);
        $title = config("Constants.SITE_NAME") . ': Edit | Invoice';
        return view('back.invoice.edit', compact('title', 'data', 'clientObj'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                // 'email' => 'nullable|email',
                'email' => [
                    'nullable',
                    'email',
                    Rule::unique('clients')->where(function ($query) use ($id) {
                        return $query->where('id', '<>', $id);
                    }),
                ]
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }



        $clientObj = Invoice::find($id);
        $clientObj->name = $request->name;
        $clientObj->email = $request->email;
        $clientObj->phone = $request->phone;
        $clientObj->comments = $request->comments;
        $clientObj->city = '';
        $clientObj->country = '';
        $clientObj->dated = $request->dated;
        $clientObj->save();
        session(['message' => 'Updated Successfully', 'type' => 'success']);
        return redirect(route('manage_clients.index'));
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Invoice::destroy($id);
        return json_encode(array("status" => true));
    }
    // Send Invoice ....... *************************
    public function create_invoice($value = '')
    {
        $seoArr = [];
        $title = 'Send Invoice';
        $maxID = Invoice::max('id') + 1;
        $paymentOption = PaymentOption::where('sts', 'Yes')->get();
        return view('back.invoice.create_invoice', compact('seoArr', 'title', 'paymentOption', 'maxID'));
    }
    public function demo_invoice($value = '')
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
                'invoice_id' => 'required|unique:inv_invoices,invoice_id',
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

        $webKey = Str::random(10);
        foreach ($formValues['payment_options'] as $key => $value) {
            $paymentObj = PaymentOption::find($value);
            if ($paymentObj) {
                $authLink = base_url() . 'invoice/pay/' . $webKey;
                $authLinkPaypal = base_url() . 'invoice/' . $webKey;
                $paymentDetails = str_replace('{AUTHORIZE_PAYNOW_BUTTON}', $authLink, $paymentObj->details);
                $paymentDetails = str_replace('{PAYPAL_PAYNOW_BUTTON}', $authLinkPaypal, $paymentDetails);
                $payment_options .= '<u>' . $paymentObj->title . '</u>';
                $payment_options .= '' . $paymentDetails . '<br/><br/>';
            }
        }
        $invoice = new Invoice;
        $bcc = '';
        $cc = '';
        if (isset($formValues['bcc'])) {
            $bcc = implode(',', $formValues['bcc']);
        }
        if (isset($formValues['cc'])) {
            $cc = implode(',', $formValues['cc']);
        }
        $invoice->invoice_id = $formValues['invoice_id'];
        $invoice->fk_admin_id = Auth::user()->id;
        $invoice->email = $formValues['client_email'];
        $invoice->sent_date = date('Y-m-d H:i:s');
        $invoice->status = 'Sent';
        $invoice->price_unit = '$';
        $invoice->amount = $formValues['amount'];
        $invoice->user_ip = $request->ip();
        $invoice->email_bcc = $bcc;
        $invoice->email_cc = $cc;
        $invoice->invoice_webkey = $webKey;
        $invoice->client_name = $formValues['client_name'];
        $invoice->comments = $formValues['comments'];
        $invoice->case_reference = $formValues['case_reference'];
        $invoice->save();
        foreach ($formValues['payment_options'] as $key => $value) {

            $arr =
                [
                    'fk_invoice_id' => $invoice->id,
                    'fk_payment_option_id' => $value,
                ];
            \DB::table('inv_invoice_payment_options')->insert($arr);
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


        //<<<<<<<<<<<<<<<<< ***End*** EMAIL
        Mail::send(
            'mail.mass',
            ['messageText' => $emailTemplate],
            function ($m) use ($request) {
                $m->from('admin' . config('Constants.SITE_EMAIL'), 'Admin');
                $m->to($request->client_email, $request->client_name)->subject('Pay Invoice | ' . $request->invoice_id);
                if (isset($request->bcc)) {
                    if (sizeof($request->bcc) > 0) {
                        $m->bcc($request->bcc);
                    }
                }
                if (isset($request->cc)) {
                    if (sizeof($request->cc) > 0) {
                        $m->cc($request->cc);
                    }
                }
            }
        );
        echo json_encode(['success' => 'done', 'smsg' => 'Invoice Sent Successfully']);
        return;
    }
    public function re_send_invoice(Request $request)
    {
        $paymentObj = Invoice::find($request->idd);
        if (!$paymentObj) {
            echo json_encode(['success' => 'error', 'smsg' => 'Invoice not found']);
            return;
        }
        $formValues = $paymentObj->toArray();
        $invoiceSettingsData  = Metadata::where('data_key', 'invoiceSettings')->first()->val1;
        $invoiceSettingsDataArray = json_decode($invoiceSettingsData, true);
        $invoiceContentData  = Metadata::where('data_key', 'invoiceContent')->first()->val1;
        $invoiceContentDataArray = json_decode($invoiceContentData, true);
        $payment_options = '';
        $msg_body = stripslashes($invoiceContentDataArray['invoice_content']);
        $msg_body = str_replace('{client_name}', $formValues['client_name'], $msg_body);
        $msg_body = str_replace('{case_reference}', $formValues['case_reference'], $msg_body);
        $msg_body = str_replace('{client_email}', $formValues['email'], $msg_body);
        $msg_body = str_replace('{amount}', $formValues['amount'], $msg_body);
        $msg_body = str_replace('{payment_options}', $payment_options, $msg_body);

        if (trim($formValues['comments']) != '') {
            $msg_body = str_replace('{comments}', '<strong><u>Comments:</u></strong>&nbsp;&nbsp;&nbsp;' . nl2br($formValues['comments']) . '<br><br>', $msg_body);
        } else {
            $msg_body = str_replace('{comments}', '', $msg_body);
        }
        $emailTemplate = $msg_body;
        $subject = "Invoice for Case Number :" . $formValues['case_reference'];
        Mail::send(
            'mail.mass',
            ['messageText' => $emailTemplate],
            function ($m) use ($paymentObj) {
                $m->from('admin' . config('Constants.SITE_EMAIL'), 'Admin');
                $m->to($paymentObj->email, $paymentObj->client_name)->subject('Pay Invoice | ' . $paymentObj->invoice_id);
                if ($paymentObj->email_cc != '') {
                    $cc = explode(',', $paymentObj->email_cc);
                    if (sizeof($cc) > 0) {
                        $m->cc($cc);
                    }
                }
                if ($paymentObj->email_bcc != '') {
                    $bcc = explode(',', $paymentObj->email_bcc);
                    if (sizeof($bcc) > 0) {
                        $m->bcc($bcc);
                    }
                }
            }
        );
        $paymentObj->increment('time_sent');
        echo json_encode(['success' => 'done', 'smsg' => 'Invoice Sent Successfully']);
        return;
    }
}

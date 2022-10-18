<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Back\Invoice;
use App\Models\Back\PaymentOption;
use App\Models\Back\Metadata;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PaymentOptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = config('Constants.SITE_NAME') . ': Payment Options';
        $msg = '';

        $result = PaymentOption::paginate(20);
        return view('back.payment_options.index_view', compact('title', 'msg', 'result'));
    }
    public function create()
    {
        $data = array();
        $data['msg'] = '';
        $title = config("Constants.SITE_NAME") . ': Add | PaymentOption';
        return view('back.payment_options.add', compact('title', 'data'));
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
                'title' => 'required',
                'details' => 'required'
            ]

        );


        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }



        $clientObj = new PaymentOption;
        $clientObj->title = $request->title;
        $clientObj->details = $request->details;

        $clientObj->save();

        // insertHistory(
        //     'client_added_backend',['{NAME_OF_BUSSINESS}'=>$contact->name_of_buss],
        //     $contact->id,$contact->u_type,Auth::user()->id
        // );

        Session::flash('msg', 'Added Successfully');
        return redirect(route('payment_options.index'));
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
        $title = config('Constants.SITE_NAME') . ': Payment Options | Details';
        $client = PaymentOption::find($id);
        $clientName = '';


        $historyArr = [];
        $bcArr = array('payment_options' => 'Payment Options');
        return view('back.payment_options.show', compact('client', 'title', 'bcArr', 'level', 'historyArr', 'clientName'));
    }
    public function paypal_email(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $meta = Metadata::where('data_key', 'paypal_email')->firstOrFail();
        $meta->val1 = $request->email;
        $meta->save();
        $clientObj = PaymentOption::find(2);
        $clientObj->sts = $request->sts ?? 'No';
        $clientObj->save();
        Session::flash('msg', '<i class="fa-solid fa-check" aria-hidden="true"></i> Email address has been update successfully');
        return redirect()->back();
    }
    public function authorize_net(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'authorize_net_login_id' => 'required',
                'authorize_net_trans_id' => 'required',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $meta = Metadata::where('data_key', 'authorize_net_login_id')->firstOrFail();
        $meta->val1 = $request->authorize_net_login_id;
        $meta->save();
        $meta = Metadata::where('data_key', 'authorize_net_trans_id')->firstOrFail();
        $meta->val1 = $request->authorize_net_trans_id;
        $meta->save();
        $meta = Metadata::where('data_key', 'authorize_test')->firstOrFail();
        $meta->val1 = $request->authorize_test;
        $meta->save();
        $clientObj = PaymentOption::find(5);
        $clientObj->sts = $request->sts ?? 'No';
        $clientObj->save();
        Session::flash('msg', '<i class="fa-solid fa-check" aria-hidden="true"></i> Email address has been update successfully');
        return redirect()->back();
    }
    public function status(Request $request)
    {
        $clientObj = PaymentOption::find($request->idds);
        if ($clientObj->id == 2) {
            $metaData = get_meta_val('paypal_email');
            if ($metaData == '' && $request->sts == 'Yes') {
                echo json_encode(array(
                    'success' => 'error',
                    'errormsg' => 'paypal_email'
                ));
                exit;
            }
        }
        if ($clientObj->id == 5) {
            $login_id = get_meta_val('authorize_net_login_id');
            $trans_id = get_meta_val('authorize_net_trans_id');
            if (($login_id == '' || $trans_id == '') && $request->sts == 'Yes') {
                echo json_encode(array(
                    'success' => 'error',
                    'errormsg' => 'authorize_net'
                ));
                exit;
            }
        }
        if ($clientObj) {

            $clientObj->sts = $request->sts;
            $clientObj->save();
            echo json_encode(array(
                'success' => 'done',
                'errormsg' => 'DONE'
            ));
            exit;
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
        $clientObj = PaymentOption::find($id);
        $title = config("Constants.SITE_NAME") . ': Edit | PaymentOption';
        return view('back.payment_options.edit', compact('title', 'data', 'clientObj'));
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
                'title' => 'required',

            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }



        $clientObj = PaymentOption::find($id);
        $clientObj->title = $request->title;
        $clientObj->details = $request->details;

        $clientObj->save();

        // insertHistory(
        //     'client_added_backend',['{NAME_OF_BUSSINESS}'=>$contact->name_of_buss],
        //     $contact->id,$contact->u_type,Auth::user()->id
        // );

        Session::flash('msg', 'Updated Successfully');
        return redirect(route('payment_options.index'));
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($id > 5) {
            PaymentOption::destroy($id);
            return json_encode(array("status" => true));
        }
    }
}

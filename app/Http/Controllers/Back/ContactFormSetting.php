<?php

namespace App\Http\Controllers\Back;

use App\ContactBlockIps;
use App\Models\Back\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ContactFormSetting extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = config('Constants.SITE_NAME') . ': Contact Form Settings';
        $result = ContactBlockIps::orderBy('id', 'DESC')->paginate(15);
        return view('back.contact_pages.contact_settings', compact('title', 'result'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $setting = Setting::find(1);
        echo json_encode($setting->contactus_spam_words);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required | ipv4',
        ]);
        $contactIp = new ContactBlockIps();
        $contactIp->ip_list = $request->question;
        $contactIp->dated = date("Y-m-d H:i:s");
        $contactIp->save();
        return redirect()->back()->with(['added_action' => 'Added Successfully']);
    }
    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ip = ContactBlockIps::find($id);
        echo json_encode($ip);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        if ($id == '') {
            echo 'error';
            return;
        }
        $status = $request->status;
        if ($status == '') {
            echo 'invalid current status provided.';
            return;
        }
        if ($status == 'active')
            $new_status = 'blocked';
        else
            $new_status = 'active';
        $product = ContactBlockIps::find($id);
        $product->sts = $new_status;
        $product->save();
        echo $new_status;
        return;
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'edit_question' => 'required | ipv4',
        ]);
        $contactIp = ContactBlockIps::find($request->faq_id);
        $contactIp->ip_list = $request->edit_question;
        $contactIp->dated = date("Y-m-d H:i:s");
        $contactIp->save();
        return redirect()->back()->with(['update_action' => 'Added Successfully']);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ContactBlockIps::destroy($id);
        return json_encode(array("status" => TRUE));
    }
    public function update_spam_words(Request $request)
    {
        $spamWords = explode(',', $request->spam_words);
        $arrSpam = array();
        foreach ($spamWords as $key => $val) {
            $val = trim($val);
            if ($val != '') {
                $arrSpam[] = $val;
            }
        }
        $wordtoUpdate = implode(',', $arrSpam);
        $settings = Setting::find(1);
        $settings->contactus_spam_words = $wordtoUpdate;
        $settings->save();
        return redirect()->back()->with(['update_action' => 'Spam Words Successfully']);
    }
}

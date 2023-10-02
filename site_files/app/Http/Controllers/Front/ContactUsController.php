<?php

namespace App\Http\Controllers\Front;

use App\Mail\ContactUs;
use App\Models\Back\Setting;
use Illuminate\Http\Request;
use App\Models\Back\Metadata;
use App\Models\Back\CmsModuleData;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Models\Back\ContactUsRequest;

class ContactUsController extends Controller
{
    public function index(Request $request)
    {
        if (isIpBlocked($request->ip())) {
            return redirect('/block');
        }
        $seoArr = getSeoArrayModule(118);
        $editPageID = 118;
        $data = CmsModuleData::find(118);
        return view('front.contact_us.index', compact('seoArr', 'data', 'editPageID'));
    }

    public function save(Request $request)
    {
        $validationRules = [
            'name' => ['required'],
            'email' => ['required', 'email'],
            'phone' => ['required'],
            'g-recaptcha-response' => 'required|recaptcha',
        ];

        $validationMessages = [
            'name.required' => 'First Name is required',
            'email.required' => 'Email is required',
            'email.email' => 'Valid Email is required',
            'phone.required' => 'Phone is required',
            'g-recaptcha-response.required' => 'Please prove you are not robot',
            'g-recaptcha-response.recaptcha' => 'Failed to prove you are not robot',
        ];

        $validatedData = $request->validate($validationRules, $validationMessages);

        $negativeKeywordsMetaData = Metadata::where('data_key', 'negative_keywords')->first();
        $negativeKeywords = explode(',', $negativeKeywordsMetaData->val1);
        $sentenceToCheck = $request->name . ' ' . $request->email . ' ' . $request->phone . ' ' . $request->comments;
        $hasNegativeKeyword = false;
        if (count($negativeKeywords) > 0) {
            foreach ($negativeKeywords as $negativeKeyword) {
                if (strpos($sentenceToCheck, $negativeKeyword) !== false) {
                    $hasNegativeKeyword = true;
                }
            }
        }

        if ($hasNegativeKeyword === false) {
            $contactUsRequest = new ContactUsRequest();
            $contactUsRequest->name = $request->name;
            $contactUsRequest->email = $request->email;
            $contactUsRequest->phone = $request->phone;
            $contactUsRequest->comments = $request->comments;
            $contactUsRequest->ip = $request->ip();
            $contactUsRequest->dated = date('Y-m-d H:i:s');
            $contactUsRequest->save();

            $contact_emails = Setting::first();
            $toArray = explode(',', $contact_emails->to_email);
            $ccArray = explode(',', $contact_emails->cc_email);
            $bccArray = explode(',', $contact_emails->bcc_email);
            $mail = Mail::to($toArray);

            if (substr_count($contact_emails->cc_email, ',') > 0) {
                $mail->cc($ccArray);
            }

            if (substr_count($contact_emails->bcc_email, ',') > 0) {
                $mail->bcc($bccArray);
            }

            $mail->send(new ContactUs($request->all(), $request->ip()));
            echo json_encode(['status' => true, 'error' => 'Thank you, your message has been sent']);

            return;
        } else {
            /* echo json_encode(['status' => false, 'error' => 'Email can not be sent; Unwanted Keyword detected']); */
            echo json_encode(['status' => true, 'error' => 'Thank you, your message has been sent!']);

            return;
        }
    }
}

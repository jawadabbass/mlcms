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
use Exception;

class ContactUsController extends Controller
{
    public function index(Request $request)
    {
        if (isIpBlocked($request->ip())) {
            return redirect('/block');
        }
        /*********** */
        insertLeadStatImpression();
        incrementImpressions();
        /*********** */
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
        $contact_emails = Setting::first();
        $sentenceToCheck = $request->name . ' ' . $request->email . ' ' . $request->phone . ' ' . $request->comments . ' ' . $contact_emails->to_email . ' ' . $contact_emails->cc_email . ' ' . $contact_emails->bcc_email;
        $negativeKeywordsMetaData = Metadata::where('data_key', 'negative_keywords')->first();
        $negativeKeywords = explode(',', $negativeKeywordsMetaData->val1);
        $hasNegativeKeyword = false;
        if (count($negativeKeywords) > 0) {
            foreach ($negativeKeywords as $negativeKeyword) {
                if (strpos($sentenceToCheck, $negativeKeyword) !== false) {
                    $hasNegativeKeyword = true;
                }
            }
        }
        $negativeTLDsMetaData = Metadata::where('data_key', 'negative_TLDs')->first();
        $negativeTLDs = explode(',', $negativeTLDsMetaData->val1);
        $hasNegativeTLD = false;
        if (count($negativeTLDs) > 0) {
            foreach ($negativeTLDs as $negativeTLD) {
                if (strpos($sentenceToCheck, $negativeTLD) !== false) {
                    $hasNegativeTLD = true;
                }
            }
        }
        if ($hasNegativeKeyword === false && $hasNegativeTLD === false) {
            $contactUsRequest = new ContactUsRequest();
            $contactUsRequest->name = $request->name;
            $contactUsRequest->email = $request->email;
            $contactUsRequest->phone = $request->phone;
            $contactUsRequest->comments = $request->comments;
            $contactUsRequest->ip = $request->ip();
            $contactUsRequest->dated = date('Y-m-d H:i:s');
            $contactUsRequest->referrer = $request->session()->get('referrer', '');
            $contactUsRequest->save();
            /******************************** */
            /******************************** */
            incrementLeads();
            /******************************** */
            /******************************** */
            $contact_emails = Setting::first();


            $data = $request->all();
            $ip = $request->ip();
            /*
            $subject = FindInsettingArr('business_name') . ' | Contact Us Form Submitted';
            $message = view('mail.contact', compact('data', 'ip'))->render();
            
            if($this->sendMail($contact_emails->to_email, $contact_emails->cc_email, $contact_emails->bcc_email, $subject, $message)){
                echo json_encode(['status' => true, 'error' => 'Thank you, your message has been sent']);
            }else{
                echo json_encode(['status' => true, 'error' => 'Thank you, your message has been sent!!']);
            }
            return;
            */

            $toArray = explode(',', $contact_emails->to_email);
            $ccArray = explode(',', $contact_emails->cc_email);
            $bccArray = explode(',', $contact_emails->bcc_email);
            foreach ($toArray as $key => $value) {
                if (empty($value) || is_null($value)) {
                    unset($toArray[$key]);
                }
            }
            foreach ($ccArray as $key => $value) {
                if (empty($value) || is_null($value)) {
                    unset($ccArray[$key]);
                }
            }
            foreach ($bccArray as $key => $value) {
                if (empty($value) || is_null($value)) {
                    unset($bccArray[$key]);
                }
            }
            if (!empty($toArray)) {
                $mail = Mail::to($toArray);
                if (!empty($ccArray)) {
                    $mail->cc($ccArray);
                }
                if (!empty($bccArray)) {
                    $mail->bcc($bccArray);
                }
                $mail->send(new ContactUs($data, $ip));
            }
            echo json_encode(['status' => true, 'error' => 'Thank you, your message has been sent']);
            return;
        } else {
            /* echo json_encode(['status' => false, 'error' => 'Email can not be sent; Unwanted Keyword detected']); */
            echo json_encode(['status' => true, 'error' => 'Thank you, your message has been sent!']);
            return;
        }
    }

    public function sendMail($to = '', $cc = '', $bcc = '', $subject = '', $message = '')
    {
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=iso-8859-1';

        $headers[] = 'To: ' . $to;
        $headers[] = 'From: Info <info@atlservicesolutions.com>';
        if (!empty($cc)) {
            $headers[] = 'Cc: ' . $cc;
        }
        if (!empty($bcc)) {
            $headers[] = 'Bcc: ' . $bcc;
        }
        try {
            mail($to, $subject, $message, implode("\r\n", $headers));
            return true;
        } catch (Exception $e) {
            //dd($e->getMessage());
            return false;
        }
    }
}

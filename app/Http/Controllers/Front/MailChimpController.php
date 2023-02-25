<?php

namespace App\Http\Controllers\Front;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Traits\MailChimpTrait;
use App\Http\Controllers\Controller;

class MailChimpController extends Controller
{
    use MailChimpTrait;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }
    public function subscribeNewsletter(Request $request)
    {
        $request->validate(
            [
                'name' => 'required',
                'email' => 'required'
            ],
            [
                'name.required' => 'Please provide name',
                'email.required' => 'Please provide email'
            ]
        );
        $nameArray = Str::of($request->name)->explode(' ');
        $first_name = $request->name;
        $last_name = '';
        if (isset($nameArray[0])) {
            $first_name = $nameArray[0];
        }
        if (isset($nameArray[1])) {
            $last_name = $nameArray[1];
        } elseif (isset($nameArray[2])) {
            $last_name = $nameArray[2];
        }
        $memberObj = (object) ['email' => $request->email, 'first_name' => $first_name, 'last_name' => $last_name];
        $this->updateMailChimpListMember($memberObj);
        return redirect()->route('subscribeNewsletterThanks');
    }

    public function subscribeNewsletterThanks(Request $request)
    {
        return view('front.subscribeNewsletterThanks');
    }

    public function unsubscribeNewsletterForm(Request $request)
    {
        return view('front.unsubscribeNewsletter');
    }
    public function unsubscribeNewsletter(Request $request)
    {
        $request->validate(
            [
                'email' => 'required'
            ],
            [
                'email.required' => 'Please provide email'
            ]
        );
        $memberObj = (object) ['email' => $request->email];
        $this->unsubMailChimpListMember($memberObj);
        return redirect()->route('unsubscribeNewsletterThanks');
    }
    public function unsubscribeNewsletterThanks(Request $request)
    {
        return view('front.unsubscribeNewsletterThanks');
    }
}

<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Back\LeadStatUrl;
use Illuminate\Http\Request;

class ReferrerController extends Controller
{
    public function index(Request $request, $referrerURL)
    {
        $leadStatUrlObj = LeadStatUrl::where('url_internal_external', 'like', 'internal')->where('url', 'like', $referrerURL)->first();
        if (null !== $leadStatUrlObj) {
            $referrer = $leadStatUrlObj->referrer;
            $request->session()->put('referrer', $referrer);
            return redirect('/');
        }
    }
}

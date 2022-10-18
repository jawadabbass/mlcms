<?php

namespace App\Traits;

use App\User;
use Illuminate\Http\Request;
use App\Models\Back\Metadata;
use App\Models\Back\AdminLogHistory;
use Illuminate\Support\Facades\Auth;


trait AuthTrait
{

    private function setSession(Request $request)
    {
        // server should keep session data for AT LEAST 2 hour
	    ini_set('session.gc_maxlifetime', 7200);
		// each client should remember their session id for EXACTLY 2 hour
	    session_set_cookie_params(7200);
        session_start();
        $_SESSION['auth'] = true;

        $metaDatas = Metadata::where('data_key', 'date_format')
            ->orWhere('data_key', 'date_time_format')
            ->orWhere('data_key', 'time_zone')
            ->orWhere('data_key', 'max_image_size')
            ->get();

        $metaArray = array();
        foreach ($metaDatas as $metaData) {
            $metaArray[$metaData->data_key] = $metaData->val1;
        }

        session(['date_format' => $metaArray['date_format'],
            'date_time_format' => $metaArray['date_time_format'],
            'time_zone' => $metaArray['time_zone'],
            'max_image_size' => $metaArray['max_image_size'],
        ]);
        if (Auth::check() && (Auth::user()->type == 'super-admin' || Auth::user()->type == 'normal-admin')) {
            $adminLog = new AdminLogHistory();
            $adminLog->admin_ID = Auth::user()->id;
            $adminLog->ip_address = $request->ip();
            $adminLog->session_start = date("Y-m-d H:i:s");
            $adminLog->save();
        } else
            return redirect('/');
    }


}

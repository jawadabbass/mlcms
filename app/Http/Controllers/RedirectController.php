<?php

namespace App\Http\Controllers;

use App\Models\Back\AdminLogHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectController extends Controller
{
	public function redirect(Request $request)
	{
		if (Auth::check()) {
			if (Auth::user()->type == 'super-admin') {
				$adminLog = new AdminLogHistory();
				$adminLog->admin_ID = Auth::user()->id;
				$adminLog->ip_address = $request->ip();
				$adminLog->session_start = date("Y-m-d H:i:s");
				$adminLog->save();
				return redirect('/adminmedia');
			} elseif (Auth::user()->type == 'super_admin') {
				return redirect(('/adminmedia'));
			} else
				return redirect('/');
		}
		return redirect('/');
	}
}

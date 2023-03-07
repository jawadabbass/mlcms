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
			if (Auth::user()->type == 'super-admin' || Auth::user()->type == 'super_admin' || Auth::user()->type == 'normal-admin') {
				return redirect('/adminmedia');
			} else{
				return redirect('/');
			}
		}
		return redirect('/');
	}
}

<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TestController extends Controller
{
	public function aaa()
	{
		$finduser = \App\User::findOrFail(1);
		if ($finduser) {
			$dataQ = [
				'email' => 'admin@test.com',
				'password' => '123456'
			];
			if (Auth::attempt(['email' => 'admin@test.com', 'password' => '123456'])) {
				echo "Yes";
			} else {
				echo "NO";
			}
		}
		die();
	}
	public function aaa2()
	{
		dd(Auth::check());
	}
}

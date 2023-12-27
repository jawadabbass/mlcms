<?php

namespace App\Http\Controllers\Back;

use Illuminate\Http\Request;
use App\Models\Back\Category;
use App\Models\Back\CategoryGroup;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Session;

class CacheController extends Controller
{
	public $settingArr = array(
		'mainTitle' => 'Status',
		'mainPageTitle' => 'Categories',
		'contr_name' => 'categories_reg',
		'view_add' => 'add_ajax',
		'view_edit' => 'edit_ajax',
		'view_main' => 'index_view',
		'dbName' => 'categories',
		'dbId' => 'id',
	);
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		$title = 'Cache';
		return view('back.cache.index', compact('title'));
	}
	public function update(Request $request)
	{
		if ($request->all == 'Yes') {
			Cache::flush();
			Artisan::call('cache:clear');
			Artisan::call('route:clear');
			Artisan::call('config:clear');
			Artisan::call('view:clear');
			Artisan::call('optimize:clear');
		}

		if ($request->home == 'Yes') {
			Cache::forget('home');
		}
		session(['message' => 'Cache has been cleared successfully', 'type' => 'success']);
		return redirect(route('cache'));
	}
}

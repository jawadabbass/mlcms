<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Back\CmsModuleData;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	private $module_id = 33;
	public function index()
	{
		$postData = CmsModuleData::where('sts', 'active')->where('post_slug', 'services')->first();
		$seoArr = array('title' => 'Services | ' . config('Constants.SITE_NAME'));
		if (!empty($postData)) {
			$seoArr = SeoArray($postData);
		}
		$get_all_services = get_alls(50, 0, $this->module_id);
		return view('front.services.index', compact('seoArr', 'get_all_services'));
	}
	public
	function show($slug)
	{
		$get_all_services =  CmsModuleData::where('sts', 'active')
			->where('cms_module_id', 33)
			->orderBy('ID', 'ASC')
			->limit(100)
			->get();
		$result = CmsModuleData::where('cms_module_id', 33)
			->where('sts', 'active')
			->where('post_slug', 'services/' . $slug)->first();
		if ($result != null) {
			$seoArr = SeoArray($result);
			return view('front.services.show', compact('seoArr', 'result', 'get_all_services'));
		} else {
			$seoArr = array('title' => '404 Not found ');
			return view('front.home.404', compact('seoArr'));
		}
	}
}

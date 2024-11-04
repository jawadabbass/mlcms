<?php

namespace App\Http\Controllers\Front;

use App\Models\Back\Service;
use Illuminate\Http\Request;
use App\Models\Back\CmsModuleData;
use App\Http\Controllers\Controller;
use App\Models\Back\ServiceExtraImage;

class ServiceController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$postData = CmsModuleData::where('sts', 1)->where('post_slug', 'services')->first();
		$seoArr = array('title' => 'Services | ' . FindInsettingArr('business_name'));
		if (!empty($postData)) {
			$seoArr = SeoArray($postData);
		}
		$allServices = Service::where('parent_id', 0)->active()->sorted()->get();
		return view('front.services.index', compact('seoArr', 'allServices'));
	}
	public function show($slug)
	{
		$allServices = Service::where('parent_id', 0)->active()->sorted()->get();
		$serviceObj = Service::where('slug', 'like', $slug)->first();
		$serviceExtraImages = getServicesExtraImages($serviceObj->id);

		if ($serviceObj != null) {
			$seoArr = SeoArray($serviceObj);
			return view('front.services.show', compact('seoArr', 'serviceObj', 'allServices', 'serviceExtraImages'));
		} else {
			$seoArr = array('title' => '404 Not found ');
			return view('front.home.404', compact('seoArr'));
		}
	}
}

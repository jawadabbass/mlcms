<?php

namespace App\Http\Controllers\Front;

use App\Models\Back\Service;
use Illuminate\Http\Request;
use App\Models\Back\CmsModuleData;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

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
		$allServices = Service::active()->sorted()->get();
		return view('front.services.index', compact('seoArr', 'allServices'));
	}
	public function show($slug)
	{
		$servicesHtml = $this->servicesHtmlLeft();
		$serviceObj = Service::where('slug', 'like', $slug)->first();
		$serviceExtraImages = getServicesExtraImages($serviceObj->id);

		if ($serviceObj != null) {
			$seoArr = SeoArray($serviceObj);
			return view('front.services.show', compact('seoArr', 'serviceObj', 'servicesHtml', 'serviceExtraImages'));
		} else {
			$seoArr = array('title' => '404 Not found ');
			return view('front.home.404', compact('seoArr'));
		}
	}

	private function servicesHtmlLeft()
    {
        $slugForCache = 'servicesLeft';
        if (Cache::has($slugForCache)) {
            $servicesHtml = Cache::get($slugForCache);
        } else {
            $servicesHtml = '';
            $levelCounter = -1;
            getServiceliFrontSide($servicesHtml, 0, $levelCounter);
            $servicesHtml = str_replace('<ul></ul>', '', $servicesHtml);
            Cache::forever($slugForCache, $servicesHtml);
        }

        return $servicesHtml;
    }
}

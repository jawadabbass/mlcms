<?php

namespace App\Http\Controllers\Front;

use App\Models\Back\SiteMap;
use Illuminate\Http\Request;
use App\Models\Back\CmsModuleData;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class SiteMapController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$postData = CmsModuleData::where('sts', 1)->where('post_slug', 'site_map')->first();
		$seoArr = array('title' => 'Site Map | ' . FindInsettingArr('business_name'));
		if (!empty($postData)) {
			$seoArr = SeoArray($postData);
		}
		$siteMapHtml = $this->siteMapHtml();
		return view('front.site_map.index', compact('seoArr', 'siteMapHtml'));
	}
	
	private function siteMapHtml()
    {
        $slugForCache = 'siteMap';
        if (Cache::has($slugForCache)) {
            $siteMapsHtml = Cache::get($slugForCache);
        } else {
            $siteMapsHtml = '';
            $levelCounter = -1;
            getSiteMapliFront($siteMapsHtml, 0, $levelCounter);
			Cache::forever($slugForCache, $siteMapsHtml);
        }

        return $siteMapsHtml;
    }
}

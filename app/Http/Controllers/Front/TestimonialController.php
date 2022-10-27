<?php

namespace App\Http\Controllers\Front;

use App\Models\Back\CmsModuleData;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TestimonialController extends Controller
{
    public function index()
    {
        $postData = CmsModuleData::where('post_slug', 'testimonials')->first();
        if ($postData != null) {
            $seoArr = getSeoArrayModule($postData->id);
        } else {
            $seoArr = array('title' => 'Welcome to ' . config('Constants.SITE_NAME'));
        }
        $testimonials  = CmsModuleData::where('cms_module_id', 22)
            ->orderBy('item_order', 'ASC')
            ->get();
        return view('front.testimonials.index', compact('seoArr', 'testimonials'));
    }
}

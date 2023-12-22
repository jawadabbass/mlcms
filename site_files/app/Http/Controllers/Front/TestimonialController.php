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
            $seoArr = array('title' => 'Welcome to ' . FindInsettingArr('business_name'));
        }
        $testimonials = getModuleData(22);
        return view('front.testimonials.index', compact('seoArr', 'testimonials'));
    }
}

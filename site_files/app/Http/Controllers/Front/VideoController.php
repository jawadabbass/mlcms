<?php

namespace App\Http\Controllers\Front;

use App\Models\Back\Video;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VideoController extends Controller
{
    public function index()
    {
        $seoArr = getSeoArrayModule(728);
        $videos = Video::where('sts', 1)->get();
        return view('front.videos.index',compact( 'seoArr','videos'));
    }

    public function show(Request $request, $slug)
    {
        $videoObj = Video::where('slug', 'like', $slug)->first();
        $seoArr = getSeoArrayModule(728);
        return view('front.videos.show', compact('seoArr', 'videoObj'));
    }
}

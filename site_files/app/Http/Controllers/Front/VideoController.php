<?php

namespace App\Http\Controllers\Front;

use App\Models\Back\Video;
use App\Http\Controllers\Controller;

class VideoController extends Controller
{
    public function index()
    {
        $seoArr = getSeoArrayModule(249);
        $videos =  Video::orderBy('item_order', 'ASC')->paginate(100);
        return view('front.videos.index', compact('seoArr', 'videos'));
    }
}

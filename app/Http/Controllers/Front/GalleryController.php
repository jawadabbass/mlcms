<?php

namespace App\Http\Controllers\Front;

use App\Models\Back\Image;
use App\Models\Back\Album;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GalleryController extends Controller
{
    public function index()
    {
        $seoArr = getSeoArrayModule(175);
        $albumIds = Album::where('status', 1)->pluck('id')->toArray();
        $albums = Album::where('status', 1)->orderBy('order_by', 'ASC')->get();
        $images = Image::whereIn('album_id', $albumIds)->where('status', 1)->orderBy('orderBy', 'ASC')->get();
        return view('front.gallery.index', compact('seoArr', 'images', 'albums'));
    }
}

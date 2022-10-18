<?php

namespace App\Http\Controllers\Back;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Sitemap\SitemapGenerator;

class SiteMapController extends Controller
{
    public function siteMap()
    {
        SitemapGenerator::create(base_url())->writeToFile(public_path('sitemap.xml'));
        return "done";
    }
}

<?php

namespace App\Http\Controllers\Back;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Sitemap\SitemapGenerator;

class GenerateSiteMapController extends Controller
{
    public function generateSiteMap()
    {
        SitemapGenerator::create(base_url())->writeToFile(public_path('sitemap.xml'));
        return "done";
    }
}

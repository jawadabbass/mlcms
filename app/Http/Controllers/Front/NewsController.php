<?php

namespace App\Http\Controllers\Front;

use App\Models\Back\News;
use Illuminate\Http\Request;
use App\Models\Back\CmsModuleData;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class NewsController extends Controller
{
    function index()
    {
        $postData = CmsModuleData::where('post_slug', 'news')->first();
        if ($postData != null) {
            $seoArr = getSeoArrayModule($postData->id);
        } else {
            $seoArr = array('title' => 'Welcome to ' . FindInsettingArr('business_name'));
        }
        $newsCollection = News::where(function ($query) {
            return $query->whereDate('news_date_time', '>=', date('Y-m-d H:i:s'))
                ->orWhere('is_hide_event_after_date', 0);
        })
            ->active()
            ->sorted()
            ->paginate(10);
        $newsArchive = News::select(DB::raw("YEAR(`news_date_time`) as newsyear, MONTHNAME(`news_date_time`) as newsmonth, MONTH(`news_date_time`) as newsmonthno, count(*) as newscount"))
            ->groupBy('newsyear')
            ->groupBy('newsmonth')
            ->orderBy('news_date_time', 'DESC')
            ->get();
        return view('front.news.index', compact('seoArr', 'newsCollection', 'newsArchive'));
    }
    function page($year, $month)
    {
        $postData = CmsModuleData::where('post_slug', 'news')->first();
        if ($postData != null) {
            $seoArr = getSeoArrayModule($postData->id);
        } else {
            $seoArr = array('title' => 'Welcome to ' . FindInsettingArr('business_name'));
        }
        $dateTime = strtotime($year.'-'.$month.'-01 00:00:00');
        $newsCollection = News::whereDate('news_date_time', date('Y-m-d', $dateTime))
            ->active()
            ->sorted()
            ->paginate(10);
        $newsArchive = News::select(DB::raw("YEAR(`news_date_time`) as newsyear, MONTHNAME(`news_date_time`) as newsmonth, MONTH(`news_date_time`) as newsmonthno, count(*) as newscount"))
            ->groupBy('newsyear')
            ->groupBy('newsmonth')
            ->orderBy('news_date_time', 'DESC')
            ->get();
        return view('front.news.index', compact('seoArr', 'newsCollection', 'newsArchive'));
    }
    function single($id, $slug)
    {
        $postData = CmsModuleData::where('post_slug', 'news')->first();
        if ($postData != null) {
            $seoArr = getSeoArrayModule($postData->id);
        } else {
            $seoArr = array('title' => 'Welcome to ' . FindInsettingArr('business_name'));
        }

        $newsArchive = News::select(DB::raw("YEAR(`news_date_time`) as newsyear, MONTHNAME(`news_date_time`) as newsmonth, MONTH(`news_date_time`) as newsmonthno, count(*) as newscount"))
                ->groupBy('newsyear')
                ->groupBy('newsmonth')
                ->orderBy('news_date_time', 'DESC')
                ->get();

        $news = News::findOrFail($id);
        return view('front.news.show', compact('seoArr', 'news', 'newsArchive'));
    }
}

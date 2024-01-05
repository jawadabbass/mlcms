<?php

namespace App\Http\Controllers\Back;

use App\Models\Back\CmsNews;
use Illuminate\Http\Request;
use Spatie\Analytics\Period;
use Illuminate\Support\Carbon;
use App\Models\Back\AdminAlert;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Artisan;
use Spatie\Analytics\Facades\Analytics;

class DashboardController extends Controller
{
    public function index()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://medialinkers.com/pms/newsupdate/fetch_newsupdates');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
        curl_setopt($ch, CURLOPT_TIMEOUT, 2);
        $newsData = curl_exec($ch);
        curl_close($ch);
        $maxID = CmsNews::max('news_id');
        $newsArray = json_decode($newsData);
        if (is_array($newsArray)) {
            $readNews = CmsNews::where('read_status', 1)->get();
            $readId = array();
            foreach ($readNews as $read) {
                array_push($readId, $read->news_id);
            }
            CmsNews::truncate();
            foreach ($newsArray as $news) {
                $newsL = new CmsNews();
                $newsL->news_id = $news->id;
                $newsL->title = $news->news_title;
                $newsL->description = $news->news_description;
                $newsL->dated = $news->created_date;
                $newsL->link = $news->news_link;
                $newsL->save();
            }
            DB::table('cms_news')->whereIn('news_id',  $readId)->update(array('read_status' => 1));
            $news = CmsNews::where('read_status', 0)->get();
            if (count($news) <= 0 || $news == null) {
                $news = CmsNews::limit(2)->get();
            }
        } else {
            $news = null;
        }
        $this->updateAdminAlerts();
        $adminAlertsData = AdminAlert::all();
        $adminAlerts = array();
        foreach ($adminAlertsData as $data) {
            $adminAlerts[$data->keyy] = $data->total;
        }
        return view('back.dashboard.index', compact('adminAlerts', 'news'));
    }
    function updateAdminAlerts()
    {
        $rows = AdminAlert::all();
        foreach ($rows as $row) {
            if ($row['qr_whr'] == NULL) {
                $tot = DB::table($row['qr_table'])->where($row['qr_dated_f'], '>', $row['check_dated'])->get();
                $total = count($tot);
            } else {
                $tot = DB::table($row['qr_table'])->where($row['qr_whr'])->get();
                $total = count($tot);
            }
            $row->total = $total;
            $row->updated_dated = date('Y-m-d H:i:s');
            $row->save();
        }
        return true;
    }
    function updateNewsStatus(Request $request)
    {
        $newsItem = CmsNews::find($request->id);
        $newsItem->read_status = true;
        $newsItem->save();
        echo $newsItem->link;
    }
    function newsPage()
    {
        $news = CmsNews::paginate(15);
        return view('back.dashboard.news', compact('news'));
    }
    public function clearCache()
    {
        Cache::flush();
        Artisan::call('cache:clear');
        Artisan::call('route:clear');
        Artisan::call('config:clear');
        Artisan::call('view:clear');
        Artisan::call('optimize:clear');

        return redirect()->back();
    }
    public function sideBarLeft(Request $request)
    {
        Log::error("Preference Value = " . $request->preference);
        session(['leftSideBar' => $request->preference]);
    }

    public function googleAnalytics(Request $request)
    {
        $startDate = Carbon::now()->subYear();
        $endDate = Carbon::now();
        $period = Period::create($startDate, $endDate);

        $visitorsAndPageViews = []; //Analytics::fetchVisitorsAndPageViews($period);
        $visitorsAndPageViewsByDate = []; //Analytics::fetchVisitorsAndPageViewsByDate($period);
        $totalVisitorsAndPageViews = []; //Analytics::fetchTotalVisitorsAndPageViews($period);
        $mostVisitedPages = []; //Analytics::fetchMostVisitedPages($period, 20);
        $topReferrers = []; //Analytics::fetchTopReferrers($period, 20);
        $userTypes = []; //Analytics::fetchUserTypes($period);
        $topBrowsers = []; //Analytics::fetchTopBrowsers($period, 20);
        $topCountries = []; //Analytics::fetchTopCountries($period, 20);
        $topOperatingSystems = []; //Analytics::fetchTopOperatingSystems($period, 20);


        $visitorsAndPageViews = json_decode('[
            {"date":{"date":"2016-08-22 15:38:36.000000","timezone_type":3,"timezone":"UTC"},"visitors":"0","pageViews":"0"},
            {"date":{"date":"2016-08-23 15:38:36.000000","timezone_type":3,"timezone":"UTC"},"visitors":"0","pageViews":"0"},
            {"date":{"date":"2016-08-24 15:38:36.000000","timezone_type":3,"timezone":"UTC"},"visitors":"0","pageViews":"0"},
            {"date":{"date":"2016-08-25 15:38:36.000000","timezone_type":3,"timezone":"UTC"},"visitors":"0","pageViews":"0"},
            {"date":{"date":"2016-08-26 15:38:36.000000","timezone_type":3,"timezone":"UTC"},"visitors":"0","pageViews":"0"}, 
            {"date":{"date":"2016-08-27 15:38:36.000000","timezone_type":3,"timezone":"UTC"},"visitors":"0","pageViews":"0"},
            {"date":{"date":"2016-08-28 15:38:36.000000","timezone_type":3,"timezone":"UTC"},"visitors":"0","pageViews":"0"}, 
            {"date":{"date":"2016-08-29 15:38:36.000000","timezone_type":3,"timezone":"UTC"},"visitors":"1","pageViews":"5"}
        ]');


        $visitorsAndPageViews = json_encode($visitorsAndPageViews);
        $visitorsAndPageViewsByDate = json_encode($visitorsAndPageViewsByDate);
        $totalVisitorsAndPageViews = json_encode($totalVisitorsAndPageViews);
        $mostVisitedPages = json_encode($mostVisitedPages);
        $topReferrers = json_encode($topReferrers);
        $userTypes = json_encode($userTypes);
        $topBrowsers = json_encode($topBrowsers);
        $topCountries = json_encode($topCountries);
        $topOperatingSystems = json_encode($topOperatingSystems);

        $data = compact(
            'visitorsAndPageViews',
            'visitorsAndPageViewsByDate',
            'totalVisitorsAndPageViews',
            'mostVisitedPages',
            'topReferrers',
            'userTypes',
            'topBrowsers',
            'topCountries',
            'topOperatingSystems'
        );

        return view('back.dashboard.google_analytics', $data);
    }
}

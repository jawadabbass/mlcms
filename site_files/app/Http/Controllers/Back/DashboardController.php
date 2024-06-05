<?php

namespace App\Http\Controllers\Back;

use App\Models\Back\CmsNews;
use Illuminate\Http\Request;
use Spatie\Analytics\Period;
use App\Models\Back\Metadata;
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
        $data['adminAlerts'] = $adminAlerts;
        $data['news'] = $news;

        $analytics_property_id = config('analytics.property_id');
        $service_account_credentials_json = config('analytics.service_account_credentials_json');
        $is_show_analytics = config('analytics.is_show_analytics');

        if ($is_show_analytics) {
            $is_show_analytics = false;
            if (!empty($analytics_property_id) && !empty($service_account_credentials_json)) {
                $is_show_analytics = true;
                $startDate = Carbon::now()->subYear();
                $endDate = Carbon::now();
                $period = Period::create($startDate, $endDate);

                $visitorsAndPageViews = Analytics::fetchVisitorsAndPageViews($period);
                $visitorsAndPageViewsByDate = Analytics::fetchVisitorsAndPageViewsByDate($period);
                $totalVisitorsAndPageViews = Analytics::fetchTotalVisitorsAndPageViews($period);
                $mostVisitedPages = Analytics::fetchMostVisitedPages($period, 20);
                $topReferrers = Analytics::fetchTopReferrers($period, 20);
                $userTypes = Analytics::fetchUserTypes($period);
                $topBrowsers = Analytics::fetchTopBrowsers($period, 20);
                $topCountries = Analytics::fetchTopCountries($period, 20);
                $topOperatingSystems = Analytics::fetchTopOperatingSystems($period, 20);

                $visitorsAndPageViewsJson = json_encode($visitorsAndPageViews);
                $visitorsAndPageViewsByDateJson = json_encode($visitorsAndPageViewsByDate);
                $totalVisitorsAndPageViewsJson = json_encode($totalVisitorsAndPageViews);
                $mostVisitedPagesJson = json_encode($mostVisitedPages);
                $topReferrersJson = json_encode($topReferrers);
                $userTypesJson = json_encode($userTypes);
                $topBrowsersJson = json_encode($topBrowsers);
                $topCountriesJson = json_encode($topCountries);
                $topOperatingSystemsJson = json_encode($topOperatingSystems);

                $data['visitorsAndPageViews'] = $visitorsAndPageViews;
                $data['visitorsAndPageViewsByDate'] = $visitorsAndPageViewsByDate;
                $data['totalVisitorsAndPageViews'] = $totalVisitorsAndPageViews;
                $data['mostVisitedPages'] = $mostVisitedPages;
                $data['topReferrers'] = $topReferrers;
                $data['userTypes'] = $userTypes;
                $data['topBrowsers'] = $topBrowsers;
                $data['topCountries'] = $topCountries;
                $data['topOperatingSystems'] = $topOperatingSystems;
                $data['visitorsAndPageViewsJson'] = $visitorsAndPageViewsJson;
                $data['visitorsAndPageViewsByDateJson'] = $visitorsAndPageViewsByDateJson;
                $data['totalVisitorsAndPageViewsJson'] = $totalVisitorsAndPageViewsJson;
                $data['mostVisitedPagesJson'] = $mostVisitedPagesJson;
                $data['topReferrersJson'] = $topReferrersJson;
                $data['userTypesJson'] = $userTypesJson;
                $data['topBrowsersJson'] = $topBrowsersJson;
                $data['topCountriesJson'] = $topCountriesJson;
                $data['topOperatingSystemsJson'] = $topOperatingSystemsJson;
            }
        }
        $data['is_show_analytics'] = $is_show_analytics;
        return view('back.dashboard.index', $data);
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
        clearCache();
        return redirect()->back();
    }
    public function sideBarLeft(Request $request)
    {
        Log::error("Preference Value = " . $request->preference);
        session(['leftSideBar' => $request->preference]);
    }
}

<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Back\AdminAlert;
use App\Models\Back\CmsNews;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
        Artisan::call('errorlog:clear');

        return redirect()->back();
    }
    public function sideBarLeft(Request $request)
    {
        Log::error("Preference Value = " . $request->preference);
        session(['leftSideBar' => $request->preference]);
    }
}

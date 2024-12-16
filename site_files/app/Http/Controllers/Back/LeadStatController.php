<?php

namespace App\Http\Controllers\Back;

use Illuminate\Http\Request;
use App\Models\Back\LeadStat;
use App\Models\Back\LeadStatUrl;
use App\Models\Back\QouteRequest;
use App\Models\Back\ContactUsData;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class LeadStatController extends Controller
{

    public function index(Request $request)
    {
        $contactReferrerArray = [];
        $contactStatUrls = LeadStatUrl::orderBy('referrer')->get();
        if ($contactStatUrls->count()) {
            foreach ($contactStatUrls as $contactStatUrlObj) {
                $referrerQuery = LeadStat::where('referrer', 'like', '%' . $contactStatUrlObj->referrer . '%')->where('referrer', '<>', '');
                $contactsByReferrerQuery = ContactUsData::where('referrer', 'like', '%' . $contactStatUrlObj->referrer . '%')->where('referrer', '<>', '');
                if (isset($_GET['dates']) && !empty($_GET['dates'])) {
                    $date = $_GET['dates'];
                    $value = preg_split("#-#", $date);
                    $from = date("Y-m-d H:i:s", strtotime($value[0] . ' 00:00:00'));
                    $to = date("Y-m-d H:i:s", strtotime($value[1] . ' 23:59:59'));
                    $referrerQuery->where('created_at', '>=', $from)->where('created_at', '<=', $to);
                    $contactsByReferrerQuery->where('created_at', '>=', $from)->where('created_at', '<=', $to);
                }
                $totalReferrerCount = $referrerQuery->count();
                $totalLeadsByReferrerCount = $contactsByReferrerQuery->count();

                $contactReferrerArray[] = ['referrer' => $contactStatUrlObj->referrer, 'id' => $contactStatUrlObj->id, 'totalReferrerCount' => $totalReferrerCount, 'totalLeadsByReferrerCount' => $totalLeadsByReferrerCount];
            }
        }

        /********************************** */
        /********************************** */
        $referrerArray = [];
        $leadStatUrls = LeadStatUrl::orderBy('referrer')->get();
        if ($leadStatUrls->count()) {
            foreach ($leadStatUrls as $leadStatUrlObj) {
                $referrerQuery = LeadStat::where('referrer', 'like', '%' . $leadStatUrlObj->referrer . '%')->where('referrer', '<>', '');
                $leadsByReferrerQuery = QouteRequest::where('referrer', 'like', '%' . $leadStatUrlObj->referrer . '%')->where('referrer', '<>', '');
                if (isset($_GET['dates']) && !empty($_GET['dates'])) {
                    $date = $_GET['dates'];
                    $value = preg_split("#-#", $date);
                    $from = date("Y-m-d H:i:s", strtotime($value[0] . ' 00:00:00'));
                    $to = date("Y-m-d H:i:s", strtotime($value[1] . ' 23:59:59'));
                    $referrerQuery->where('created_at', '>=', $from)->where('created_at', '<=', $to);
                    $leadsByReferrerQuery->where('created_at', '>=', $from)->where('created_at', '<=', $to);
                }
                $totalReferrerCount = $referrerQuery->count();
                $totalLeadsByReferrerCount = $leadsByReferrerQuery->count();

                $referrerArray[] = ['referrer' => $leadStatUrlObj->referrer, 'id' => $leadStatUrlObj->id, 'totalReferrerCount' => $totalReferrerCount, 'totalLeadsByReferrerCount' => $totalLeadsByReferrerCount];
            }
        }
        /********************************** */
        /********************************** */
        $title = config("Constants.SITE_NAME") . ' : Lead Stats';
        return view('back.lead_stats.index', compact('title', 'contactReferrerArray', 'referrerArray'));
    }
    public function clearLeadStats($referrer)
    {
        LeadStat::where('referrer', 'like', '%' . $referrer . '%')->delete();
        ContactUsData::where('referrer', 'like', '%' . $referrer . '%')->update(['referrer' => '']);
        QouteRequest::where('referrer', 'like', '%' . $referrer . '%')->update(['referrer' => '']);
        /***************************** */
        flash('Lead Stats Cleard successfully!', 'success');
        return Redirect::route('lead.stats.index');
    }
}

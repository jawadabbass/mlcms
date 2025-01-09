<?php

namespace App\Http\Controllers\Back;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Back\LeadStat;
use App\Models\Back\LeadStatUrl;
use App\Traits\LeadStatUrlTrait;
use App\Models\Back\QuoteRequest;
use App\Models\Back\ContactUsData;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Back\LeadStatUrlBackFormRequest;

class LeadStatUrlController extends Controller
{
    use LeadStatUrlTrait;
    public function index()
    {
        $title = config('Constants.SITE_NAME') . ': Lead Stat Urls Management';
        $msg = '';
        return view('back.lead_stat_urls.index', compact('title', 'msg'));
    }
    public function fetchLeadStatUrlsAjax(Request $request)
    {
        $leadStatUrlObj = LeadStatUrl::select('*');
        return DataTables::of($leadStatUrlObj)
            ->filter(function ($query) use ($request) {
                if ($request->has('referrer') && !empty($request->referrer)) {
                    $query->where('lead_stat_urls.referrer', 'like', $request->get('referrer'));
                }
                if ($request->has('url') && !empty($request->url)) {
                    $query->where('lead_stat_urls.url', 'like', "%{$request->get('url')}%");
                }
            })
            ->addColumn('created_at', function ($leadStatUrlObj) {
                return date('m-d-Y', strtotime($leadStatUrlObj->created_at));
            })
            ->addColumn('url', function ($leadStatUrlObj) {
                if($leadStatUrlObj->url_internal_external == 'internal'){
                return config('Constants.REF_URL') . $leadStatUrlObj->url . ' <a href="javascript:void(0);" onclick="loadEditLeadStatUrlModal(' . $leadStatUrlObj->id . ');" class="btn btn-danger"><i class="fa fa-external-link" aria-hidden="true"></i></a>';
                }else{
                return $leadStatUrlObj->url . ' <a href="javascript:void(0);" onclick="loadEditLeadStatUrlModal(' . $leadStatUrlObj->id . ');" class="btn btn-danger"><i class="fa fa-external-link" aria-hidden="true"></i></a>';
                }
            })
            ->addColumn('url_internal_external', function ($leadStatUrlObj) {
                return ucwords($leadStatUrlObj->url_internal_external);

            })
            ->addColumn('action', function ($leadStatUrlObj) {
                return '
                		<a href="' . route('leadStatUrl.edit', ['leadStatUrlObj' => $leadStatUrlObj->id]) . '" class="btn btn-warning m-2"><i class="fa fa-pencil" aria-hidden="true"></i></a>
						<a href="javascript:void(0);" onclick="deleteLeadStatUrl(' . $leadStatUrlObj->id . ');"  class="btn btn-danger m-2"><i class="fa fa-trash-o" aria-hidden="true"></i></a>';
            })
            ->rawColumns(['url', 'url_internal_external', 'action'])
            ->orderColumns(['referrer', 'url', 'url_internal_external'], ':column $1')
            ->setRowId(function ($leadStatUrlObj) {
                return 'leadStatUrlDtRow' . $leadStatUrlObj->id;
            })
            ->make(true);
    }
    public function create()
    {
        $title = config('Constants.SITE_NAME') . ': Lead Stat Urls Management';
        $msg = '';
        $leadStatUrlObj = new LeadStatUrl();
        $leadStatUrlObj->url_internal_external = 'internal';
        $leadStatUrlObj->final_destination = url('/');
        return view('back.lead_stat_urls.create')
            ->with('leadStatUrlObj', $leadStatUrlObj)
            ->with('title', $title)
            ->with('msg', $msg);
    }
    public function store(LeadStatUrlBackFormRequest $request)
    {
        $leadStatUrlObj = new LeadStatUrl();
        $leadStatUrlObj = $this->setLeadStatUrlValues($request, $leadStatUrlObj);
        $leadStatUrlObj->save();
        /***************************** */
        flash('Lead Stat Url added successfully!', 'success');
        return Redirect::route('leadStatUrls.index');
    }
    public function show($id) {}
    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(LeadStatUrl $leadStatUrlObj)
    {
        $title = config('Constants.SITE_NAME') . ': Lead Stat Urls Management';
        $msg = '';
        return view('back.lead_stat_urls.edit')
            ->with('leadStatUrlObj', $leadStatUrlObj)
            ->with('title', $title)
            ->with('msg', $msg);
    }
    public function update(LeadStatUrlBackFormRequest $request, LeadStatUrl $leadStatUrlObj)
    {
        $leadStatUrlObj = $this->setLeadStatUrlValues($request, $leadStatUrlObj);
        $leadStatUrlObj->save();
        /***************************** */
        flash('Lead Stat Url has been updated!', 'success');
        return Redirect::route('leadStatUrls.index');
    }
    private function deleteLeadStateUrl(LeadStatUrl $leadStatUrlObj)
    {
        LeadStat::where('referrer', 'like', $leadStatUrlObj->referrer)->delete();
        ContactUsData::where('referrer', 'like', $leadStatUrlObj->referrer)->update(['referrer' => '']);
        QuoteRequest::where('referrer', 'like', $leadStatUrlObj->referrer)->update(['referrer' => '']);
        $leadStatUrlObj->delete();
    }
    public function destroy(LeadStatUrl $leadStatUrlObj)
    {
        $this->deleteLeadStateUrl($leadStatUrlObj);
        echo 'ok';
    }
    public function deleteLeadReferrer($referrer)
    {
        $leadStatUrlObj = LeadStatUrl::where('referrer', 'like', $referrer)->first();
        $this->deleteLeadStateUrl($leadStatUrlObj);
        /***************************** */
        flash('Lead Stats Cleard successfully!', 'success');
        return Redirect::route('lead.stats.index');
    }
    public function loadEditLeadStatUrlModal(Request $request)
    {
        $leadStatUrlObj = LeadStatUrl::find($request->id);
        $html = view('back.lead_stat_urls.edit_url')->with('leadStatUrlObj', $leadStatUrlObj)->render();
        return response()->json(['html' => $html, 'closeModal' => 'n']);
    }
    public function updateLeadStatUrl(Request $request)
    {
        $leadStatUrlObj = LeadStatUrl::find($request->id);
        $rules = [
            'url' => 'required',
            'url_internal_external' => 'required',
        ];
        if ($request->input('url_internal_external') == 'internal') {
            $rules['final_destination'] = 'required';
        }
        $messages = [
            'url.required' => __('URL is required'),
            'url_internal_external.required' => __('Is URL Internal/External'),
            'final_destination.required' => __('Final destination is required'),
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            Session::flash('_old_input', $request->all());
            $html = view('back.lead_stat_urls.edit_url')
                ->with('errors', $validator->errors())
                ->with('leadStatUrlObj', $leadStatUrlObj)->render();
            return response()->json(['html' => $html, 'closeModal' => 'n']);
        }

        $leadStatUrlObj = $this->setLeadStatUrlValues($request, $leadStatUrlObj);
        $leadStatUrlObj->update();

        $html = view('back.lead_stat_urls.edit_url_done')->render();
        return response()->json(['html' => $html, 'closeModal' => 'y']);
    }
}

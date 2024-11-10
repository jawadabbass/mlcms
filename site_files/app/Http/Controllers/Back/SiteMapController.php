<?php

namespace App\Http\Controllers\Back;

use App\Models\Back\SiteMap;
use App\Traits\SiteMapTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Back\SiteMapBackFormRequest;

class SiteMapController extends Controller
{
    use SiteMapTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = config('Constants.SITE_NAME') . ': Site Map Management';
        $msg = '';
        return view('back.site_map.index', compact('title', 'msg'));
    }

    public function fetchSiteMapsAjax(Request $request)
    {
        $siteMapCollection = SiteMap::select('*');
        return DataTables::of($siteMapCollection)
            ->filter(function ($query) use ($request) {
                if ($request->has('title') && !empty($request->title)) {
                    $query->where('site_map.title', 'like', "%{$request->get('title')}%");
                }
                if ($request->has('parent_id') && !empty($request->parent_id)) {
                    $query->where('site_map.parent_id', $request->get('parent_id'));
                }
                if ($request->has('status') && $request->status != '') {
                    $query->where('site_map.status', $request->get('status'));
                }
            })
            ->addColumn('parent_id', function ($siteMapCollection) {
                if ($siteMapCollection->parent_id > 0) {
                    $html = $siteMapCollection->parentSiteMap->title;
                    getParentSiteMapsList($html, $siteMapCollection->parentSiteMap->parent_id);
                    return $html;
                } else {
                    return '';
                }
            })
            ->addColumn('status', function ($siteMapCollection) {
                $checked = ($siteMapCollection->status) == 1 ? ' checked' : '';

                $str = '<input type="checkbox" data-toggle="toggle_status" data-onlabel="Active"
                data-offlabel="Not Active" data-onstyle="success"
                data-offstyle="danger"
                data-id="' . $siteMapCollection->id . '"
                name="status_' . $siteMapCollection->id . '"
                id="status_' . $siteMapCollection->id . '" ' . $checked . '
                value="' . $siteMapCollection->status . '">';
                return $str;
            })
            ->addColumn('action', function ($siteMapCollection) {
                return '
                <a href="' . route('site.map.edit', ['siteMapObj' => $siteMapCollection->id]) . '" class="btn btn-info"><i class="fa-solid fa-pencil" aria-hidden="true"></i></a>
				<a href="javascript:void(0);" onclick="deleteSiteMap(' . $siteMapCollection->id . ');" class="btn btn-danger"><i class="fa-solid fa-trash" aria-hidden="true"></i></a>				
                ';
            })
            ->rawColumns(['parent_id', 'action', 'status'])
            ->orderColumns(['sort_order', 'title', 'parent_id', 'status'], ':column $1')
            ->setRowId(function ($siteMapCollection) {
                return 'siteMapDtRow' . $siteMapCollection->id;
            })
            ->make(true);
        //$query = $dataTable->getQuery()->get();
        //return $query;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = config('Constants.SITE_NAME') . ': Site Map Management';
        $msg = '';
        $siteMapObj = new SiteMap();
        $siteMapObj->id = 0;
        $siteMapObj->is_link_internal = 1;
        $siteMapObj->status = 1;

        return view('back.site_map.create')
            ->with('siteMapObj', $siteMapObj)
            ->with('title', $title)
            ->with('msg', $msg);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SiteMapBackFormRequest $request)
    {
        //dd($request);
        $parent_id = $request->input('parent_id', 0);
        $lastSiteMapObj = SiteMap::where('parent_id', $parent_id)->orderBy('sort_order', 'desc')->first();
        $parentSiteMapObj = SiteMap::where('id', $parent_id)->first();
        $sort_order = '1';
        if (null !== $lastSiteMapObj && $parent_id > 0) {
            $lastSortOrderArray = explode('-', $lastSiteMapObj->sort_order);
            $lastSortOrder = end($lastSortOrderArray);
            $parentSortOrder = str_replace('-' . $lastSortOrder, '', $lastSiteMapObj->sort_order);
            $sort_order = $parentSortOrder . '-' . (int)$lastSortOrder + 1;
        } elseif (null !== $lastSiteMapObj && $parent_id == 0) {
            $sort_order = (int)$lastSiteMapObj->sort_order + 1;
        } else if (null !== $parentSiteMapObj) {
            $sort_order = $parentSiteMapObj->sort_order . '-' . 1;
        }

        /********************* */
        $siteMapObj = new SiteMap();
        $siteMapObj = $this->setSiteMapValues($request, $siteMapObj);
        $siteMapObj->sort_order = $sort_order;
        $siteMapObj->save();


        flash('Site Maphas been added!', 'success');
        return Redirect::route('site.map.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(SiteMap $siteMapObj)
    {
        $title = config('Constants.SITE_NAME') . ': Site Map Management';
        $msg = '';

        return view('back.site_map.edit')
            ->with('siteMapObj', $siteMapObj)
            ->with('title', $title)
            ->with('msg', $msg);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SiteMapBackFormRequest $request, SiteMap $siteMapObj)
    {
        $siteMapObj = $this->setSiteMapValues($request, $siteMapObj);
        $siteMapObj->save();

        /*         * ************************************ */
        flash('Site Maphas been updated!', 'success');
        return Redirect::route('site.map.index');
    }

    public function updateSiteMapStatus(Request $request)
    {
        $siteMapObj = SiteMap::find($request->id);
        $siteMapObj = $this->setSiteMapStatus($request, $siteMapObj);
        $siteMapObj->update();
        echo 'Done Successfully!';
        exit;
    }

    public function destroy(SiteMap $siteMapObj)
    {
        deleteSiteMap($siteMapObj->id);
        echo 'ok';
    }

    public function sortSiteMap()
    {
        $title = config('Constants.SITE_NAME') . ': Site Map Management';
        $msg = '';
        return view('back.site_map.sort')->with('title', $title)
            ->with('msg', $msg);
    }

    public function siteMapSortData(Request $request)
    {
        $html = '<ul id="sortable">';
        getSiteMapliForSort($html, $request->input('parent_id', 0));
        echo $html . '</ul>';
    }

    public function siteMapSortUpdate(Request $request)
    {
        $siteMapsOrder = $request->input('siteMapOrder');
        $siteMapsOrderArray = explode(',', $siteMapsOrder);
        $count = 1;
        foreach ($siteMapsOrderArray as $siteMapId) {
            $siteMapObj = SiteMap::find($siteMapId);
            $parentSiteMapObj = SiteMap::where('id', $siteMapObj->parent_id)->first();
            if (null !== $parentSiteMapObj) {
                $siteMapObj->sort_order = $parentSiteMapObj->sort_order . '-' . $count;
            } else {
                $siteMapObj->sort_order = $count;
            }
            $siteMapObj->update();
            $count++;
        }
    }

    public function sortSiteMapByTitle(Request $request)
    {
        $parent_id = $request->input('parent_id', 0);
        $siteMapCollection = SiteMap::where('parent_id', $parent_id)->orderBy('title', 'ASC')->get();
        $count = 1;
        foreach ($siteMapCollection as $siteMapObj) {
            $parentSiteMapObj = SiteMap::where('id', $parent_id)->first();
            if (null !== $parentSiteMapObj) {
                $siteMapObj->sort_order = $parentSiteMapObj->sort_order . '-' . $count;
            } else {
                $siteMapObj->sort_order = $count;
            }
            $siteMapObj->update();
            $count++;
        }
    }
}

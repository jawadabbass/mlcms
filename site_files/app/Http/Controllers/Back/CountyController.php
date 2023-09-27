<?php

namespace App\Http\Controllers\Back;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Back\County;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Back\CountyBackFormRequest;
use App\Models\Back\City;
use App\Traits\CountyTrait;

class CountyController extends Controller
{
    use CountyTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = FindInsettingArr('business_name') . ': Counties Management';
        $msg = '';
        return view('back.counties.index', compact('title', 'msg'));
    }

    public function fetchCountiesAjax(Request $request)
    {
        $counties = County::select('*');
        return Datatables::of($counties)
            ->filter(function ($query) use ($request) {
                if ($request->has('state_id') && !empty($request->state_id)) {
                    $query->where('counties.state_id', $request->get('state_id'));
                }
                if ($request->has('county_name') && !empty($request->county_name)) {
                    $query->where('counties.county_name', 'like', "%{$request->get('county_name')}%");
                }
                if ($request->has('status') && !empty($request->status)) {
                    $query->where('counties.status', 'like', "%{$request->get('status')}%");
                }
            })
            ->addColumn('state_id', function ($counties) {
                return $counties->state->state_name;
            })
            ->addColumn('status', function ($counties) {
                $str = '<select class="form-control" name="status" id="status_' . $counties->id . '" onchange="updateCountyStatus(' . $counties->id . ', \'' . $counties->status . '\', this.value);">';
                $str .= generateStatusDropDown($counties->status, false);
                $str .= '</select>';
                return $str;
            })
            ->addColumn('action', function ($counties) {
                return '
                <div class="btn-group">
					<button class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Action
					</button>
					<ul class="dropdown-menu">
						<li>
							<a href="' . route('counties.edit', ['countyObj' => $counties->id]) . '" class="text-info"><i class="fas fa-edit" aria-hidden="true"></i>Edit</a>
						</li>
						<li>
							<a href="javascript:void(0);" onclick="deleteCounty(' . $counties->id . ');" class="text-danger"><i class="fas fa-trash" aria-hidden="true"></i>Delete</a>
						</li>
					</ul>
				</div>';
            })
            ->rawColumns(['state_id', 'action', 'status'])
            ->orderColumns(['county_name', 'state_id', 'status'], ':column $1')
            ->setRowId(function ($counties) {
                return 'countiesDtRow' . $counties->id;
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
        $title = FindInsettingArr('business_name') . ': Counties Management';
        $msg = '';
        $countyObj = new County();
        return view('back.counties.create')
            ->with('countyObj', $countyObj)
            ->with('title', $title)
            ->with('msg', $msg);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CountyBackFormRequest $request)
    {
        $countyObj = new County();
        $countyObj = $this->setCountyValues($request, $countyObj);
        $countyObj->save();

        flash('County has been added!', 'success');
        return Redirect::route('counties.index');
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
    public function edit(County $countyObj)
    {
        $title = FindInsettingArr('business_name') . ': Counties Management';
        $msg = '';
        return view('back.counties.edit')
            ->with('countyObj', $countyObj)
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
    public function update(CountyBackFormRequest $request, County $countyObj)
    {
        $countyObj = $this->setCountyValues($request, $countyObj);
        $countyObj->save();

        /*         * ************************************ */

        flash('County has been updated!', 'success');
        return Redirect::route('counties.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(County $countyObj)
    {
        City::where('county_id', $countyObj->id)->delete();
        $countyObj->delete();
        echo 'ok';
    }

    public function updateCountyStatus(Request $request)
    {
        $countyObj = County::find($request->id);
        $countyObj = $this->setCountyStatus($request, $countyObj);
        $countyObj->update();
        return response()->json(['status' => 'success', 'message' => $countyObj->status]);
    }

    public function sortCounties()
    {
        $title = FindInsettingArr('business_name') . ': Counties Management';
        $msg = '';
        return view('back.counties.sort')->with('title', $title)
            ->with('msg', $msg);
    }

    public function countiesSortData(Request $request)
    {
        $counties = County::select('counties.id', 'counties.state_id', 'counties.county_name', 'counties.sort_order')
            ->where('state_id', $request->state_id)
            ->where('status', 'like', 'active')
            ->orderBy('sort_order', 'ASC')->get();
        $str = '<ul id="sortable">';
        if ($counties != null) {
            foreach ($counties as $countyObj) {
                $str .= '<li class="ui-county-default" id="' . $countyObj->id . '"><i class="fas fa-sort"></i> ' . $countyObj->state->state_name . ' - ' . $countyObj->county_name . '</li>';
            }
        }
        echo $str . '</ul>';
    }

    public function countiesSortUpdate(Request $request)
    {
        $countiesOrder = $request->input('countiesOrder');
        $countiesOrderArray = explode(',', $countiesOrder);
        $count = 1;
        foreach ($countiesOrderArray as $countyId) {
            $countyObj = County::find($countyId);
            $countyObj->sort_order = $count;
            $countyObj->update();
            $count++;
        }
    }
}

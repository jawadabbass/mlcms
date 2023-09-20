<?php

namespace App\Http\Controllers\Back;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Back\City;
use App\Models\Back\County;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Back\CityBackFormRequest;
use App\Traits\CityTrait;

class CityController extends Controller
{
    use CityTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        hasPermission('Can Manage Cities');
        $title = FindInsettingArr('business_name') . ': Cities Management';
        $msg = '';
        return view('back.cities.index', compact('title', 'msg'));
    }

    public function fetchCitiesAjax(Request $request)
    {
        hasPermission('Can Manage Cities');
        $cities = City::select('*');
        return Datatables::of($cities)
            ->filter(function ($query) use ($request) {
                if ($request->has('state_id') && !empty($request->state_id)) {
                    $query->where('cities.state_id', $request->get('state_id'));
                }
                if ($request->has('county_id') && !empty($request->county_id)) {
                    $query->where('cities.county_id', $request->get('county_id'));
                }
                if ($request->has('city_name') && !empty($request->city_name)) {
                    $query->where('cities.city_name', 'like', "%{$request->get('city_name')}%");
                }
            })
            ->addColumn('state_id', function ($cities) {
                return $cities->state->state_name;
            })
            ->addColumn('county_id', function ($cities) {
                return $cities->county->county_name;
            })
            ->addColumn('status', function ($cities) {
                $str = '<select class="form-control" name="status" id="status_' . $cities->id . '" onchange="updateCityStatus(' . $cities->id . ', \'' . $cities->status . '\', this.value);">';
                $str .= generateStatusDropDown($cities->status, false);
                $str .= '</select>';
                return $str;
            })
            ->addColumn('action', function ($cities) {
                $editStr = '';
                $deleteStr = '';
                if(isAllowed('Can Edit City')){
                    $editStr = '<li>
                    <a href="' . route('cities.edit', ['cityObj' => $cities->id]) . '" class="text-info"><i class="fas fa-edit" aria-hidden="true"></i>Edit</a>
                </li>';
                }
                if(isAllowed('Can Delete City')){
                    $deleteStr = '<li>
                    <a href="javascript:void(0);" onclick="deleteCity(' . $cities->id . ');" class="text-danger"><i class="fas fa-trash" aria-hidden="true"></i>Delete</a>
                </li>';
                }
                return '
                <div class="btn-group">
					<button class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Action
					</button>
					<ul class="dropdown-menu">
						'.$editStr.'
						'.$deleteStr.'
					</ul>
				</div>';
            })
            ->rawColumns(['state_id', 'county_id', 'action', 'status'])
            ->orderColumns(['city_name', 'state_id', 'county_id', 'status'], ':column $1')
            ->setRowId(function ($cities) {
                return 'citiesDtRow' . $cities->id;
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
        hasPermission('Can Add City');
        $title = FindInsettingArr('business_name') . ': Cities Management';
        $msg = '';
        $cityObj = new City();
        return view('back.cities.create')
            ->with('cityObj', $cityObj)
            ->with('title', $title)
            ->with('msg', $msg);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CityBackFormRequest $request)
    {
        hasPermission('Can Add City');
        $cityObj = new City();
        $cityObj = $this->setCityValues($request, $cityObj);
        $cityObj->save();

        flash('City has been added!', 'success');
        return Redirect::route('cities.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        hasPermission('Can Manage Cities');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(City $cityObj)
    {
        hasPermission('Can Edit City');
        $title = FindInsettingArr('business_name') . ': Cities Management';
        $msg = '';
        return view('back.cities.edit')
            ->with('cityObj', $cityObj)
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
    public function update(CityBackFormRequest $request, City $cityObj)
    {
        hasPermission('Can Edit City');
        $cityObj = $this->setCityValues($request, $cityObj);
        $cityObj->save();

        /*         * ************************************ */

        flash('City has been updated!', 'success');
        return Redirect::route('cities.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(City $cityObj)
    {
        hasPermission('Can Delete City');
        $cityObj->delete();
        echo 'ok';
    }

    public function updateCityStatus(Request $request)
    {
        hasPermission('Can Edit City');
        $cityObj = City::find($request->id);
        $cityObj = $this->setCityStatus($request, $cityObj);
        $cityObj->update();
        return response()->json(['status' => 'success', 'message' => $cityObj->status]);
    }

    public function sortCities()
    {
        hasPermission('Can Sort Cities');
        $title = FindInsettingArr('business_name') . ': Cities Management';
        $msg = '';
        return view('back.cities.sort')->with('title', $title)
            ->with('msg', $msg);
    }

    public function citiesSortData(Request $request)
    {
        hasPermission('Can Sort Cities');
        $cities = City::select('cities.id', 'cities.city_name', 'cities.sort_order')
            ->where('county_id', $request->county_id)
            ->where('status', 'like', 'active')
            ->orderBy('sort_order', 'ASC')->get();
        $str = '<ul id="sortable">';
        if ($cities != null) {
            foreach ($cities as $cityObj) {
                $str .= '<li class="ui-city-default" id="' . $cityObj->id . '"><i class="fas fa-sort"></i> ' . $cityObj->city_name . '</li>';
            }
        }
        echo $str . '</ul>';
    }

    public function citiesSortUpdate(Request $request)
    {
        hasPermission('Can Sort Cities');
        $citiesOrder = $request->input('citiesOrder');
        $citiesOrderArray = explode(',', $citiesOrder);
        $count = 1;
        foreach ($citiesOrderArray as $cityId) {
            $cityObj = City::find($cityId);
            $cityObj->sort_order = $count;
            $cityObj->update();
            $count++;
        }
    }
}

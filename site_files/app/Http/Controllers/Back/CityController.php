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
        $title = FindInsettingArr('business_name') . ': Cities Management';
        $msg = '';
        return view('back.cities.index', compact('title', 'msg'));
    }

    public function fetchCitiesAjax(Request $request)
    {
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
                return '
                <div class="btn-group">
					<button class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Action
					</button>
					<ul class="dropdown-menu">
						<li>
							<a href="' . route('cities.edit', ['cityObj' => $cities->id]) . '" class="text-info"><i class="fas fa-edit" aria-hidden="true"></i>Edit</a>
						</li>
						<li>
							<a href="javascript:void(0);" onclick="deleteCity(' . $cities->id . ');" class="text-danger"><i class="fas fa-trash" aria-hidden="true"></i>Delete</a>
						</li>
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
        $cityObj = new City();
        $cityObj = $this->setCityValues($request, $cityObj);
        $cityObj->save();
        session(['message' => 'City has been added!', 'type' => 'success']);
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(City $cityObj)
    {
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
        $cityObj = $this->setCityValues($request, $cityObj);
        $cityObj->save();

        /*         * ************************************ */
        session(['message' => 'City has been updated!', 'type' => 'success']);
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
        $cityObj->delete();
        session(['message' => 'Deleted Successfully', 'type' => 'success']);
        echo 'ok';
    }

    public function updateCityStatus(Request $request)
    {
        $cityObj = City::find($request->id);
        $cityObj = $this->setCityStatus($request, $cityObj);
        $cityObj->update();
        return response()->json(['status' => 'success', 'message' => $cityObj->status]);
    }

    public function sortCities()
    {
        $title = FindInsettingArr('business_name') . ': Cities Management';
        $msg = '';
        return view('back.cities.sort')->with('title', $title)
            ->with('msg', $msg);
    }

    public function citiesSortData(Request $request)
    {
        $cities = City::select('cities.id', 'cities.city_name', 'cities.sort_order')
            ->where('county_id', $request->county_id)
            ->where('status', 1)
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

<?php

namespace App\Http\Controllers\Back;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Back\CabinAmenity;
use App\Traits\CabinAmenityTrait;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Back\CabinAmenityBackFormRequest;

class CabinAmenityController extends Controller
{
    use CabinAmenityTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = FindInsettingArr('business_name') . ': Cabin Amenities Management';
        $msg = '';

        return view('back.cabin_amenities.index', compact('title', 'msg'));
    }

    public function fetchCabinAmenitiesAjax(Request $request)
    {
        $cabinAmenities = CabinAmenity::select('*');

        return Datatables::of($cabinAmenities)
            ->filter(function ($query) use ($request) {
                if ($request->has('title') && !empty($request->title)) {
                    $query->where('cabin_amenities.title', 'like', "%{$request->get('title')}%");
                }
                if ($request->has('status') && !empty($request->status)) {
                    $query->where('cabin_amenities.status', 'like', "{$request->get('status')}");
                }
            })
            ->addColumn('status', function ($cabinAmenities) {
                $str = '<select class="form-control" name="status" id="status_' . $cabinAmenities->id . '" onchange="updateCabinAmenityStatus(' . $cabinAmenities->id . ', \'' . $cabinAmenities->status . '\', this.value);">';
                $str .= generateCabinAmenitiesStatusDropDown($cabinAmenities->status, false);
                $str .= '</select>';

                return $str;
            })
            ->addColumn('action', function ($cabinAmenities) {
                return '
                		<a href="' . route('cabinAmenities.edit', ['cabinAmenityObj' => $cabinAmenities->id]) . '" class="btn btn-warning m-2"><i class="fas fa-edit" aria-hidden="true"></i></a>
						<a href="javascript:void(0);" onclick="deleteCabinAmenity(' . $cabinAmenities->id . ');"  class="btn btn-danger m-2"><i class="fas fa-trash" aria-hidden="true"></i></a>';
            })
            ->rawColumns(['status', 'action'])
            ->orderColumns(['title', 'status'], ':column $1')
            ->setRowId(function ($cabinAmenities) {
                return 'cabinAmenitiesDtRow' . $cabinAmenities->id;
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
        $title = FindInsettingArr('business_name') . ': Cabin Amenities Management';
        $msg = '';
        $cabinAmenityObj = new CabinAmenity();

        return view('back.cabin_amenities.create')
            ->with('cabinAmenityObj', $cabinAmenityObj)
            ->with('title', $title)
            ->with('msg', $msg);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CabinAmenityBackFormRequest $request)
    {
        $cabinAmenityObj = new CabinAmenity();
        $cabinAmenityObj = $this->setCabinAmenityValues($request, $cabinAmenityObj);
        $cabinAmenityObj->save();

        flash('Cabin Amenity has been added!', 'success');

        return Redirect::route('cabinAmenities.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(CabinAmenity $cabinAmenityObj)
    {
        $title = FindInsettingArr('business_name') . ': Cabin Amenities Management';
        $msg = '';

        return view('back.cabin_amenities.edit')
            ->with('cabinAmenityObj', $cabinAmenityObj)
            ->with('title', $title)
            ->with('msg', $msg);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(CabinAmenityBackFormRequest $request, CabinAmenity $cabinAmenityObj)
    {
        $cabinAmenityObj = $this->setCabinAmenityValues($request, $cabinAmenityObj);
        $cabinAmenityObj->save();

        flash('Cabin Amenity has been updated!', 'success');

        return Redirect::route('cabinAmenities.index');
    }

    public function sortCabinAmenities()
    {
        $title = FindInsettingArr('business_name') . ': Cabin Amenities Management';
        $msg = '';

        return view('back.cabin_amenities.sort')->with('title', $title)
            ->with('msg', $msg);
    }

    public function cabinAmenitiesSortData(Request $request)
    {
        $cabinAmenities = CabinAmenity::select('cabin_amenities.id', 'cabin_amenities.title', 'cabin_amenities.sort_order')
            ->orderBy('sort_order', 'ASC')->get();
        $str = '<ul id="sortable">';
        if ($cabinAmenities != null) {
            foreach ($cabinAmenities as $cabinAmenityObj) {
                $str .= '<li class="ui-state-default" id="' . $cabinAmenityObj->id . '"><i class="fas fa-sort"></i> ' . $cabinAmenityObj->title . '</li>';
            }
        }
        echo $str . '</ul>';
    }

    public function cabinAmenitiesSortUpdate(Request $request)
    {
        $cabinAmenitiesOrder = $request->input('cabinAmenitiesOrder');
        $cabinAmenitiesOrderArray = explode(',', $cabinAmenitiesOrder);
        $count = 1;
        foreach ($cabinAmenitiesOrderArray as $cabinAmenityId) {
            $cabinAmenityObj = CabinAmenity::find($cabinAmenityId);
            $cabinAmenityObj->sort_order = $count;
            $cabinAmenityObj->update();
            ++$count;
        }
    }

    public function updateCabinAmenityStatus(Request $request)
    {
        $cabinAmenityObj = CabinAmenity::find($request->id);
        $cabinAmenityObj = $this->setCabinAmenityStatus($request, $cabinAmenityObj);
        $cabinAmenityObj->save();

        return response()->json(['status' => 'success', 'message' => $cabinAmenityObj->status]);
    }

    public function destroy(CabinAmenity $cabinAmenityObj)
    {
        $cabinAmenityObj->delete();
        echo 'ok';
    }
}

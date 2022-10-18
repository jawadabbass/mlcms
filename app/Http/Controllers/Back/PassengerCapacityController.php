<?php

namespace App\Http\Controllers\Back;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Back\PassengerCapacity;
use App\Traits\PassengerCapacityTrait;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Back\PassengerCapacityBackFormRequest;

class PassengerCapacityController extends Controller
{
    use PassengerCapacityTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = config('Constants.SITE_NAME') . ': Passenger Capacities Management';
        $msg = '';

        return view('back.passenger_capacities.index', compact('title', 'msg'));
    }

    public function fetchPassengerCapacitiesAjax(Request $request)
    {
        $passengerCapacities = PassengerCapacity::select('*');

        return Datatables::of($passengerCapacities)
            ->filter(function ($query) use ($request) {
                if ($request->has('title') && !empty($request->title)) {
                    $query->where('passenger_capacities.title', 'like', "%{$request->get('title')}%");
                }
                if ($request->has('status') && !empty($request->status)) {
                    $query->where('passenger_capacities.status', 'like', "{$request->get('status')}");
                }
            })
            ->addColumn('status', function ($passengerCapacities) {
                $str = '<select class="form-control" name="status" id="status_' . $passengerCapacities->id . '" onchange="updatePassengerCapacityStatus(' . $passengerCapacities->id . ', \'' . $passengerCapacities->status . '\', this.value);">';
                $str .= generatePassengerCapacitiesStatusDropDown($passengerCapacities->status, false);
                $str .= '</select>';

                return $str;
            })
            ->addColumn('action', function ($passengerCapacities) {
                return '
                		<a href="' . route('passengerCapacities.edit', ['passengerCapacityObj' => $passengerCapacities->id]) . '" class="btn btn-warning m-2"><i class="fa-solid fa-pencil" aria-hidden="true"></i></a>
						<a href="javascript:void(0);" onclick="deletePassengerCapacity(' . $passengerCapacities->id . ');"  class="btn btn-danger m-2"><i class="fa-solid fa-trash" aria-hidden="true"></i></a>';
            })
            ->rawColumns(['status', 'action'])
            ->orderColumns(['title', 'status'], ':column $1')
            ->setRowId(function ($passengerCapacities) {
                return 'passengerCapacitiesDtRow' . $passengerCapacities->id;
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
        $title = config('Constants.SITE_NAME') . ': Passenger Capacities Management';
        $msg = '';
        $passengerCapacityObj = new PassengerCapacity();

        return view('back.passenger_capacities.create')
            ->with('passengerCapacityObj', $passengerCapacityObj)
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
    public function store(PassengerCapacityBackFormRequest $request)
    {
        $passengerCapacityObj = new PassengerCapacity();
        $passengerCapacityObj = $this->setPassengerCapacityValues($request, $passengerCapacityObj);
        $passengerCapacityObj->save();

        flash('Passenger Capacity has been added!', 'success');

        return Redirect::route('passengerCapacities.index');
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
    public function edit(PassengerCapacity $passengerCapacityObj)
    {
        $title = config('Constants.SITE_NAME') . ': Passenger Capacities Management';
        $msg = '';

        return view('back.passenger_capacities.edit')
            ->with('passengerCapacityObj', $passengerCapacityObj)
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
    public function update(PassengerCapacityBackFormRequest $request, PassengerCapacity $passengerCapacityObj)
    {
        $passengerCapacityObj = $this->setPassengerCapacityValues($request, $passengerCapacityObj);
        $passengerCapacityObj->save();

        flash('Passenger Capacity has been updated!', 'success');

        return Redirect::route('passengerCapacities.index');
    }

    public function sortPassengerCapacities()
    {
        $title = config('Constants.SITE_NAME') . ': Passenger Capacities Management';
        $msg = '';

        return view('back.passenger_capacities.sort')->with('title', $title)
            ->with('msg', $msg);
    }

    public function passengerCapacitiesSortData(Request $request)
    {
        $passengerCapacities = PassengerCapacity::select('passenger_capacities.id', 'passenger_capacities.title', 'passenger_capacities.sort_order')
            ->orderBy('sort_order', 'ASC')->get();
        $str = '<ul id="sortable">';
        if ($passengerCapacities != null) {
            foreach ($passengerCapacities as $passengerCapacityObj) {
                $str .= '<li class="ui-state-default" id="' . $passengerCapacityObj->id . '"><i class="fa-solid fa-sort"></i> ' . $passengerCapacityObj->title . '</li>';
            }
        }
        echo $str . '</ul>';
    }

    public function passengerCapacitiesSortUpdate(Request $request)
    {
        $passengerCapacitiesOrder = $request->input('passengerCapacitiesOrder');
        $passengerCapacitiesOrderArray = explode(',', $passengerCapacitiesOrder);
        $count = 1;
        foreach ($passengerCapacitiesOrderArray as $passengerCapacityId) {
            $passengerCapacityObj = PassengerCapacity::find($passengerCapacityId);
            $passengerCapacityObj->sort_order = $count;
            $passengerCapacityObj->update();
            ++$count;
        }
    }

    public function updatePassengerCapacityStatus(Request $request)
    {
        $passengerCapacityObj = PassengerCapacity::find($request->id);
        $passengerCapacityObj = $this->setPassengerCapacityStatus($request, $passengerCapacityObj);
        $passengerCapacityObj->save();

        return response()->json(['status' => 'success', 'message' => $passengerCapacityObj->status]);
    }

    public function destroy(PassengerCapacity $passengerCapacityObj)
    {
        $passengerCapacityObj->delete();
        echo 'ok';
    }
}

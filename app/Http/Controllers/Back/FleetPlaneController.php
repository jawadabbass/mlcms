<?php

namespace App\Http\Controllers\Back;

use App\Models\Back\Safety;
use Illuminate\Http\Request;
use App\Helpers\ImageUploader;
use App\Models\Back\FleetPlane;
use App\Traits\FleetPlaneTrait;
use App\Models\Back\Performance;
use App\Models\Back\CabinAmenity;
use App\Models\Back\FleetCategory;
use App\Models\Back\CabinDimension;
use App\Http\Controllers\Controller;
use App\Models\Back\BaggageCapacity;
use App\Models\Back\PassengerCapacity;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Back\FleetPlaneBackFormRequest;

class FleetPlaneController extends Controller
{
    use FleetPlaneTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = config('Constants.SITE_NAME') . ': Fleet Planes Management';
        $msg = '';

        return view('back.fleet_planes.index', compact('title', 'msg'));
    }

    public function fetchFleetPlanesAjax(Request $request)
    {
        $fleetPlanes = FleetPlane::select('*');

        return Datatables::of($fleetPlanes)
            ->filter(function ($query) use ($request) {
                if ($request->has('fleet_category_id') && !empty($request->fleet_category_id)) {
                    $query->where('fleet_planes.fleet_category_id', $request->fleet_category_id);
                }
                if ($request->has('plane_name') && !empty($request->plane_name)) {
                    $query->where('fleet_planes.plane_name', 'like', "%{$request->get('plane_name')}%");
                }
                if ($request->has('status') && !empty($request->status)) {
                    $query->where('fleet_planes.status', 'like', "%{$request->get('status')}%");
                }
            })
            ->addColumn('fleet_category_id', function ($fleetPlanes) {
                return $fleetPlanes->fleetCategory->title;
            })
            ->addColumn('image', function ($fleetPlanes) {
                return '<img src="' . ImageUploader::print_image_src($fleetPlanes->image, 'fleet_planes/thumb') . '" />';
            })
            ->addColumn('status', function ($fleetPlanes) {
                $str = '<select class="form-control" name="status" id="status_' . $fleetPlanes->id . '" onchange="updateFleetPlaneStatus(' . $fleetPlanes->id . ', \'' . $fleetPlanes->status . '\', this.value);">';
                $str .= generateFleetPlaneStatusDropDown($fleetPlanes->status, false);
                $str .= '</select>';

                return $str;
            })
            ->addColumn('action', function ($fleetPlanes) {
                $awardStr = '';
                if ($fleetPlanes->is_copied_from_award && $fleetPlanes->prestige_local_award_id > 0) {
                    $awardStr = '<li>
                    <a target="_blank" href="' . route('prestigeLocalAwards.edit', ['prestigeLocalAwardObj' => $fleetPlanes->prestige_local_award_id]) . '" class="text-info"><i class="fa-solid fa-trophy" aria-hidden="true"></i>Linked Award</a>
                </li>';
                }

                return '
                <div class="btn-group">
					<button class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Action
					</button>
					<ul class="dropdown-menu">
						<li>
							<a href="' . route('fleetPlanes.edit', ['fleetPlaneObj' => $fleetPlanes->id]) . '" class="text-warning"><i class="fa-solid fa-pencil" aria-hidden="true"></i>Edit</a>
						</li>
						<li>
							<a href="javascript:void(0);" onclick="deleteFleetPlane(' . $fleetPlanes->id . ');" class="text-danger"><i class="fa-solid fa-trash" aria-hidden="true"></i>Delete</a>
						</li>
                        ' . $awardStr . '
					</ul>
				</div>';
            })
            ->rawColumns(['image', 'fleet_category_id', 'status', 'action'])
            ->orderColumns(['fleet_category_id', 'plane_name', 'status'], ':column $1')
            ->setRowId(function ($fleetPlanes) {
                return 'fleetPlanesDtRow' . $fleetPlanes->id;
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
        $title = config('Constants.SITE_NAME') . ': Fleet Planes Management';
        $msg = '';
        $fleetPlaneObj = new FleetPlane();

        $passengerCapacities = PassengerCapacity::active()->sorted()->get();
        $cabinDimensions = CabinDimension::active()->sorted()->get();
        $baggageCapacities = BaggageCapacity::active()->sorted()->get();
        $performances = Performance::active()->sorted()->get();
        $cabinAmenities = CabinAmenity::active()->sorted()->get();
        $safeties = Safety::active()->sorted()->get();

        return view('back.fleet_planes.create')
            ->with('fleetPlaneObj', $fleetPlaneObj)
            ->with('passengerCapacities', $passengerCapacities)
            ->with('cabinDimensions', $cabinDimensions)
            ->with('baggageCapacities', $baggageCapacities)
            ->with('performances', $performances)
            ->with('cabinAmenities', $cabinAmenities)
            ->with('safeties', $safeties)
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
    public function store(FleetPlaneBackFormRequest $request)
    {
        $fleetPlaneObj = new FleetPlane();
        $fleetPlaneObj = $this->setFleetPlaneValues($request, $fleetPlaneObj);
        $fleetPlaneObj->save();

        $this->uploadFleetPlaneImages($request, $fleetPlaneObj);

        $this->setPlanePassengerCapacity($fleetPlaneObj, $request);
        $this->setPlaneCabinDimensions($fleetPlaneObj, $request);
        $this->setPlaneBaggageCapacity($fleetPlaneObj, $request);
        $this->setPlanePerformance($fleetPlaneObj, $request);
        $this->setPlaneCabinAmenities($fleetPlaneObj, $request);
        $this->setPlaneSafety($fleetPlaneObj, $request);

        flash('Fleet Plane has been added!', 'success');

        return Redirect::route('fleetPlanes.index');
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
    public function edit(FleetPlane $fleetPlaneObj)
    {
        $title = config('Constants.SITE_NAME') . ': Fleet Planes Management';
        $msg = '';

        $passengerCapacities = PassengerCapacity::active()->sorted()->get();
        $cabinDimensions = CabinDimension::active()->sorted()->get();
        $baggageCapacities = BaggageCapacity::active()->sorted()->get();
        $performances = Performance::active()->sorted()->get();
        $cabinAmenities = CabinAmenity::active()->sorted()->get();
        $safeties = Safety::active()->sorted()->get();

        return view('back.fleet_planes.edit')
            ->with('fleetPlaneObj', $fleetPlaneObj)
            ->with('passengerCapacities', $passengerCapacities)
            ->with('cabinDimensions', $cabinDimensions)
            ->with('baggageCapacities', $baggageCapacities)
            ->with('performances', $performances)
            ->with('cabinAmenities', $cabinAmenities)
            ->with('safeties', $safeties)
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
    public function update(FleetPlaneBackFormRequest $request, FleetPlane $fleetPlaneObj)
    {
        $previous_status = $fleetPlaneObj->status;
        $fleetPlaneObj = $this->setFleetPlaneValues($request, $fleetPlaneObj);
        $fleetPlaneObj->save();

        $this->uploadFleetPlaneImages($request, $fleetPlaneObj);

        $this->setPlanePassengerCapacity($fleetPlaneObj, $request);
        $this->setPlaneCabinDimensions($fleetPlaneObj, $request);
        $this->setPlaneBaggageCapacity($fleetPlaneObj, $request);
        $this->setPlanePerformance($fleetPlaneObj, $request);
        $this->setPlaneCabinAmenities($fleetPlaneObj, $request);
        $this->setPlaneSafety($fleetPlaneObj, $request);

        flash('Fleet Plane has been updated!', 'success');

        return Redirect::route('fleetPlanes.index');
    }

    public function sortFleetPlanes()
    {
        $title = config('Constants.SITE_NAME') . ': Fleet Planes Management';
        $msg = '';

        return view('back.fleet_planes.sort')->with('title', $title)
            ->with('msg', $msg);
    }

    public function fleetPlanesSortData(Request $request)
    {
        $fleetPlanes = FleetPlane::select('fleet_planes.id', 'fleet_planes.fleet_category_id',  'fleet_planes.plane_name', 'fleet_planes.sort_order')
            ->where('fleet_category_id', $request->fleet_category_id)
            ->orderBy('sort_order', 'ASC')
            ->get();
        $str = '<ul id="sortable">';
        if ($fleetPlanes != null) {
            foreach ($fleetPlanes as $fleetPlaneObj) {
                $str .= '<li class="ui-state-default" id="' . $fleetPlaneObj->id . '"><i class="fa-solid fa-sort"></i> ' . $fleetPlaneObj->plane_name . '</li>';
            }
        }
        echo $str . '</ul>';
    }

    public function fleetPlanesSortUpdate(Request $request)
    {
        $fleetPlanesOrder = $request->input('fleetPlanesOrder');
        $fleetPlanesOrderArray = explode(',', $fleetPlanesOrder);
        $count = 1;
        foreach ($fleetPlanesOrderArray as $fleetPlaneId) {
            $fleetPlaneObj = FleetPlane::find($fleetPlaneId);
            $fleetPlaneObj->sort_order = $count;
            $fleetPlaneObj->update();
            ++$count;
        }
    }

    public function updateFleetPlaneStatus(Request $request)
    {
        $fleetPlaneObj = FleetPlane::find($request->id);
        $fleetPlaneObj = $this->setFleetPlaneStatus($request, $fleetPlaneObj);
        $fleetPlaneObj->save();

        $this->sendFleetPlaneStatusEmail($fleetPlaneObj);

        return response()->json(['status' => 'success', 'message' => $fleetPlaneObj->status]);
    }
}

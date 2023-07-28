<?php

namespace App\Http\Controllers\Back;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Back\BaggageCapacity;
use App\Traits\BaggageCapacityTrait;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Back\BaggageCapacityBackFormRequest;

class BaggageCapacityController extends Controller
{
    use BaggageCapacityTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = FindInsettingArr('business_name') . ': Baggage Capacities Management';
        $msg = '';

        return view('back.baggage_capacities.index', compact('title', 'msg'));
    }

    public function fetchBaggageCapacitiesAjax(Request $request)
    {
        $baggageCapacities = BaggageCapacity::select('*');

        return Datatables::of($baggageCapacities)
            ->filter(function ($query) use ($request) {
                if ($request->has('title') && !empty($request->title)) {
                    $query->where('baggage_capacities.title', 'like', "%{$request->get('title')}%");
                }
                if ($request->has('status') && !empty($request->status)) {
                    $query->where('baggage_capacities.status', 'like', "{$request->get('status')}");
                }
            })
            ->addColumn('status', function ($baggageCapacities) {
                $str = '<select class="form-control" name="status" id="status_' . $baggageCapacities->id . '" onchange="updateBaggageCapacityStatus(' . $baggageCapacities->id . ', \'' . $baggageCapacities->status . '\', this.value);">';
                $str .= generateBaggageCapacitiesStatusDropDown($baggageCapacities->status, false);
                $str .= '</select>';

                return $str;
            })
            ->addColumn('action', function ($baggageCapacities) {
                return '
                		<a href="' . route('baggageCapacities.edit', ['baggageCapacityObj' => $baggageCapacities->id]) . '" class="btn btn-warning m-2"><i class="fas fa-edit" aria-hidden="true"></i></a>
						<a href="javascript:void(0);" onclick="deleteBaggageCapacity(' . $baggageCapacities->id . ');"  class="btn btn-danger m-2"><i class="fas fa-trash" aria-hidden="true"></i></a>';
            })
            ->rawColumns(['status', 'action'])
            ->orderColumns(['title', 'status'], ':column $1')
            ->setRowId(function ($baggageCapacities) {
                return 'baggageCapacitiesDtRow' . $baggageCapacities->id;
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
        $title = FindInsettingArr('business_name') . ': Baggage Capacities Management';
        $msg = '';
        $baggageCapacityObj = new BaggageCapacity();

        return view('back.baggage_capacities.create')
            ->with('baggageCapacityObj', $baggageCapacityObj)
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
    public function store(BaggageCapacityBackFormRequest $request)
    {
        $baggageCapacityObj = new BaggageCapacity();
        $baggageCapacityObj = $this->setBaggageCapacityValues($request, $baggageCapacityObj);
        $baggageCapacityObj->save();

        flash('Baggage Capacity has been added!', 'success');

        return Redirect::route('baggageCapacities.index');
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
    public function edit(BaggageCapacity $baggageCapacityObj)
    {
        $title = FindInsettingArr('business_name') . ': Baggage Capacities Management';
        $msg = '';

        return view('back.baggage_capacities.edit')
            ->with('baggageCapacityObj', $baggageCapacityObj)
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
    public function update(BaggageCapacityBackFormRequest $request, BaggageCapacity $baggageCapacityObj)
    {
        $baggageCapacityObj = $this->setBaggageCapacityValues($request, $baggageCapacityObj);
        $baggageCapacityObj->save();

        flash('Baggage Capacity has been updated!', 'success');

        return Redirect::route('baggageCapacities.index');
    }

    public function sortBaggageCapacities()
    {
        $title = FindInsettingArr('business_name') . ': Baggage Capacities Management';
        $msg = '';

        return view('back.baggage_capacities.sort')->with('title', $title)
            ->with('msg', $msg);
    }

    public function baggageCapacitiesSortData(Request $request)
    {
        $baggageCapacities = BaggageCapacity::select('baggage_capacities.id', 'baggage_capacities.title', 'baggage_capacities.sort_order')
            ->orderBy('sort_order', 'ASC')->get();
        $str = '<ul id="sortable">';
        if ($baggageCapacities != null) {
            foreach ($baggageCapacities as $baggageCapacityObj) {
                $str .= '<li class="ui-state-default" id="' . $baggageCapacityObj->id . '"><i class="fas fa-sort"></i> ' . $baggageCapacityObj->title . '</li>';
            }
        }
        echo $str . '</ul>';
    }

    public function baggageCapacitiesSortUpdate(Request $request)
    {
        $baggageCapacitiesOrder = $request->input('baggageCapacitiesOrder');
        $baggageCapacitiesOrderArray = explode(',', $baggageCapacitiesOrder);
        $count = 1;
        foreach ($baggageCapacitiesOrderArray as $baggageCapacityId) {
            $baggageCapacityObj = BaggageCapacity::find($baggageCapacityId);
            $baggageCapacityObj->sort_order = $count;
            $baggageCapacityObj->update();
            ++$count;
        }
    }

    public function updateBaggageCapacityStatus(Request $request)
    {
        $baggageCapacityObj = BaggageCapacity::find($request->id);
        $baggageCapacityObj = $this->setBaggageCapacityStatus($request, $baggageCapacityObj);
        $baggageCapacityObj->save();

        return response()->json(['status' => 'success', 'message' => $baggageCapacityObj->status]);
    }

    public function destroy(BaggageCapacity $baggageCapacityObj)
    {
        $baggageCapacityObj->delete();
        echo 'ok';
    }
}

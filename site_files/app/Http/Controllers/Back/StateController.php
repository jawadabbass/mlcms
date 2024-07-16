<?php

namespace App\Http\Controllers\Back;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Back\State;
use App\Models\Back\County;
use App\Models\Back\City;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Back\StateBackFormRequest;
use App\Traits\StateTrait;

class StateController extends Controller
{
    use StateTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = FindInsettingArr('business_name') . ': States Management';
        $msg = '';
        return view('back.states.index', compact('title', 'msg'));
    }

    public function fetchStatesAjax(Request $request)
    {
        $states = State::select('*');
        return Datatables::of($states)
            ->filter(function ($query) use ($request) {
                if ($request->has('state_code') && !empty($request->state_code)) {
                    $query->where('states.state_code', 'like', "%{$request->get('state_code')}%");
                }
                if ($request->has('state_name') && !empty($request->state_name)) {
                    $query->where('states.state_name', 'like', "%{$request->get('state_name')}%");
                }
                if ($request->has('status') && !empty($request->status)) {
                    $query->where('states.status', 'like', "{$request->get('status')}");
                }
            })
            ->addColumn('status', function ($states) {
                $str = '<select class="form-control" name="status" id="status_' . $states->id . '" onchange="updateStateStatus(' . $states->id . ', \'' . $states->status . '\', this.value);">';
                $str .= generateStatusDropDown($states->status, false);
                $str .= '</select>';
                return $str;
            })
            ->addColumn('action', function ($states) {
                return '
                <div class="btn-group">
					<button class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Action
					</button>
					<ul class="dropdown-menu">
						<li>
							<a href="' . route('states.edit', ['stateObj' => $states->id]) . '" class="text-info"><i class="fas fa-edit" aria-hidden="true"></i>Edit</a>
						</li>
						<li>
							<a href="javascript:void(0);" onclick="deleteState(' . $states->id . ');" class="text-danger"><i class="fas fa-trash" aria-hidden="true"></i>Delete</a>
						</li>
					</ul>
				</div>';
            })
            ->rawColumns(['action', 'status'])
            ->orderColumns(['state_code', 'state_name', 'status'], ':column $1')
            ->setRowId(function ($states) {
                return 'statesDtRow' . $states->id;
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
        $title = FindInsettingArr('business_name') . ': States Management';
        $msg = '';
        $stateObj = new State();
        return view('back.states.create')
            ->with('stateObj', $stateObj)
            ->with('title', $title)
            ->with('msg', $msg);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StateBackFormRequest $request)
    {
        $stateObj = new State();
        $stateObj = $this->setStateValues($request, $stateObj);
        $stateObj->save();

        session(['message'=>'State has been added!', 'type'=>'success']);
        return Redirect::route('states.index');
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
    public function edit(State $stateObj)
    {
        $title = FindInsettingArr('business_name') . ': States Management';
        $msg = '';
        return view('back.states.edit')
            ->with('stateObj', $stateObj)
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
    public function update(StateBackFormRequest $request, State $stateObj)
    {
        $stateObj = $this->setStateValues($request, $stateObj);
        $stateObj->save();

        /*         * ************************************ */
        session(['message' => 'State has been updated!', 'type' => 'success']);
        return Redirect::route('states.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(State $stateObj)
    {
        County::where('state_id', $stateObj->id)->delete();
        City::where('state_id', $stateObj->id)->delete();
        $stateObj->delete();
        session(['message' => 'Deleted Successfully', 'type' => 'success']);
        echo 'ok';
    }

    public function updateStateStatus(Request $request)
    {
        $stateObj = State::find($request->id);
        $stateObj = $this->setStateStatus($request, $stateObj);
        $stateObj->update();
        return response()->json(['status' => 'success', 'message' => $stateObj->status]);
    }

    public function sortStates()
    {
        $title = FindInsettingArr('business_name') . ': States Management';
        $msg = '';
        return view('back.states.sort')->with('title', $title)
            ->with('msg', $msg);
    }

    public function statesSortData(Request $request)
    {
        $states = State::select('states.id', 'states.state_name', 'states.sort_order')
            ->where('status', 'like', 'active')
            ->orderBy('sort_order', 'ASC')->get();
        $str = '<ul id="sortable">';
        if ($states != null) {
            foreach ($states as $stateObj) {
                $str .= '<li class="ui-state-default" id="' . $stateObj->id . '"><i class="fas fa-sort"></i> ' . $stateObj->state_name . '</li>';
            }
        }
        echo $str . '</ul>';
    }

    public function statesSortUpdate(Request $request)
    {
        $statesOrder = $request->input('statesOrder');
        $statesOrderArray = explode(',', $statesOrder);
        $count = 1;
        foreach ($statesOrderArray as $stateId) {
            $stateObj = State::find($stateId);
            $stateObj->sort_order = $count;
            $stateObj->update();
            $count++;
        }
    }
}

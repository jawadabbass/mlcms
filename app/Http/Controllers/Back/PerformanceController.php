<?php

namespace App\Http\Controllers\Back;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Back\Performance;
use App\Traits\PerformanceTrait;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Back\PerformanceBackFormRequest;

class PerformanceController extends Controller
{
    use PerformanceTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = config('Constants.SITE_NAME') . ': Performances Management';
        $msg = '';

        return view('back.performances.index', compact('title', 'msg'));
    }

    public function fetchPerformancesAjax(Request $request)
    {
        $performances = Performance::select('*');

        return Datatables::of($performances)
            ->filter(function ($query) use ($request) {
                if ($request->has('title') && !empty($request->title)) {
                    $query->where('performances.title', 'like', "%{$request->get('title')}%");
                }
                if ($request->has('status') && !empty($request->status)) {
                    $query->where('performances.status', 'like', "{$request->get('status')}");
                }
            })
            ->addColumn('status', function ($performances) {
                $str = '<select class="form-control" name="status" id="status_' . $performances->id . '" onchange="updatePerformanceStatus(' . $performances->id . ', \'' . $performances->status . '\', this.value);">';
                $str .= generatePerformancesStatusDropDown($performances->status, false);
                $str .= '</select>';

                return $str;
            })
            ->addColumn('action', function ($performances) {
                return '
                		<a href="' . route('performances.edit', ['performanceObj' => $performances->id]) . '" class="btn btn-warning m-2"><i class="fa-solid fa-pencil" aria-hidden="true"></i></a>
						<a href="javascript:void(0);" onclick="deletePerformance(' . $performances->id . ');"  class="btn btn-danger m-2"><i class="fa-solid fa-trash" aria-hidden="true"></i></a>';
            })
            ->rawColumns(['status', 'action'])
            ->orderColumns(['title', 'status'], ':column $1')
            ->setRowId(function ($performances) {
                return 'performancesDtRow' . $performances->id;
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
        $title = config('Constants.SITE_NAME') . ': Performances Management';
        $msg = '';
        $performanceObj = new Performance();

        return view('back.performances.create')
            ->with('performanceObj', $performanceObj)
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
    public function store(PerformanceBackFormRequest $request)
    {
        $performanceObj = new Performance();
        $performanceObj = $this->setPerformanceValues($request, $performanceObj);
        $performanceObj->save();

        flash('Performance has been added!', 'success');

        return Redirect::route('performances.index');
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
    public function edit(Performance $performanceObj)
    {
        $title = config('Constants.SITE_NAME') . ': Performances Management';
        $msg = '';

        return view('back.performances.edit')
            ->with('performanceObj', $performanceObj)
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
    public function update(PerformanceBackFormRequest $request, Performance $performanceObj)
    {
        $performanceObj = $this->setPerformanceValues($request, $performanceObj);
        $performanceObj->save();

        flash('Performance has been updated!', 'success');

        return Redirect::route('performances.index');
    }

    public function sortPerformances()
    {
        $title = config('Constants.SITE_NAME') . ': Performances Management';
        $msg = '';

        return view('back.performances.sort')->with('title', $title)
            ->with('msg', $msg);
    }

    public function performancesSortData(Request $request)
    {
        $performances = Performance::select('performances.id', 'performances.title', 'performances.sort_order')
            ->orderBy('sort_order', 'ASC')->get();
        $str = '<ul id="sortable">';
        if ($performances != null) {
            foreach ($performances as $performanceObj) {
                $str .= '<li class="ui-state-default" id="' . $performanceObj->id . '"><i class="fa-solid fa-sort"></i> ' . $performanceObj->title . '</li>';
            }
        }
        echo $str . '</ul>';
    }

    public function performancesSortUpdate(Request $request)
    {
        $performancesOrder = $request->input('performancesOrder');
        $performancesOrderArray = explode(',', $performancesOrder);
        $count = 1;
        foreach ($performancesOrderArray as $performanceId) {
            $performanceObj = Performance::find($performanceId);
            $performanceObj->sort_order = $count;
            $performanceObj->update();
            ++$count;
        }
    }

    public function updatePerformanceStatus(Request $request)
    {
        $performanceObj = Performance::find($request->id);
        $performanceObj = $this->setPerformanceStatus($request, $performanceObj);
        $performanceObj->save();

        return response()->json(['status' => 'success', 'message' => $performanceObj->status]);
    }

    public function destroy(Performance $performanceObj)
    {
        $performanceObj->delete();
        echo 'ok';
    }
}

<?php

namespace App\Http\Controllers\Back;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Back\CabinDimension;
use App\Traits\CabinDimensionTrait;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Back\CabinDimensionBackFormRequest;

class CabinDimensionController extends Controller
{
    use CabinDimensionTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = config('Constants.SITE_NAME') . ': Cabin Dimensions Management';
        $msg = '';

        return view('back.cabin_dimensions.index', compact('title', 'msg'));
    }

    public function fetchCabinDimensionsAjax(Request $request)
    {
        $cabinDimensions = CabinDimension::select('*');

        return Datatables::of($cabinDimensions)
            ->filter(function ($query) use ($request) {
                if ($request->has('title') && !empty($request->title)) {
                    $query->where('cabin_dimensions.title', 'like', "%{$request->get('title')}%");
                }
                if ($request->has('status') && !empty($request->status)) {
                    $query->where('cabin_dimensions.status', 'like', "{$request->get('status')}");
                }
            })
            ->addColumn('status', function ($cabinDimensions) {
                $str = '<select class="form-control" name="status" id="status_' . $cabinDimensions->id . '" onchange="updateCabinDimensionStatus(' . $cabinDimensions->id . ', \'' . $cabinDimensions->status . '\', this.value);">';
                $str .= generateCabinDimensionsStatusDropDown($cabinDimensions->status, false);
                $str .= '</select>';

                return $str;
            })
            ->addColumn('action', function ($cabinDimensions) {
                return '
                		<a href="' . route('cabinDimensions.edit', ['cabinDimensionObj' => $cabinDimensions->id]) . '" class="btn btn-warning m-2"><i class="fa-solid fa-pencil" aria-hidden="true"></i></a>
						<a href="javascript:void(0);" onclick="deleteCabinDimension(' . $cabinDimensions->id . ');"  class="btn btn-danger m-2"><i class="fa-solid fa-trash" aria-hidden="true"></i></a>';
            })
            ->rawColumns(['status', 'action'])
            ->orderColumns(['title', 'status'], ':column $1')
            ->setRowId(function ($cabinDimensions) {
                return 'cabinDimensionsDtRow' . $cabinDimensions->id;
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
        $title = config('Constants.SITE_NAME') . ': Cabin Dimensions Management';
        $msg = '';
        $cabinDimensionObj = new CabinDimension();

        return view('back.cabin_dimensions.create')
            ->with('cabinDimensionObj', $cabinDimensionObj)
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
    public function store(CabinDimensionBackFormRequest $request)
    {
        $cabinDimensionObj = new CabinDimension();
        $cabinDimensionObj = $this->setCabinDimensionValues($request, $cabinDimensionObj);
        $cabinDimensionObj->save();

        flash('Cabin Dimension has been added!', 'success');

        return Redirect::route('cabinDimensions.index');
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
    public function edit(CabinDimension $cabinDimensionObj)
    {
        $title = config('Constants.SITE_NAME') . ': Cabin Dimensions Management';
        $msg = '';

        return view('back.cabin_dimensions.edit')
            ->with('cabinDimensionObj', $cabinDimensionObj)
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
    public function update(CabinDimensionBackFormRequest $request, CabinDimension $cabinDimensionObj)
    {
        $cabinDimensionObj = $this->setCabinDimensionValues($request, $cabinDimensionObj);
        $cabinDimensionObj->save();

        flash('Cabin Dimension has been updated!', 'success');

        return Redirect::route('cabinDimensions.index');
    }

    public function sortCabinDimensions()
    {
        $title = config('Constants.SITE_NAME') . ': Cabin Dimensions Management';
        $msg = '';

        return view('back.cabin_dimensions.sort')->with('title', $title)
            ->with('msg', $msg);
    }

    public function cabinDimensionsSortData(Request $request)
    {
        $cabinDimensions = CabinDimension::select('cabin_dimensions.id', 'cabin_dimensions.title', 'cabin_dimensions.sort_order')
            ->orderBy('sort_order', 'ASC')->get();
        $str = '<ul id="sortable">';
        if ($cabinDimensions != null) {
            foreach ($cabinDimensions as $cabinDimensionObj) {
                $str .= '<li class="ui-state-default" id="' . $cabinDimensionObj->id . '"><i class="fa-solid fa-sort"></i> ' . $cabinDimensionObj->title . '</li>';
            }
        }
        echo $str . '</ul>';
    }

    public function cabinDimensionsSortUpdate(Request $request)
    {
        $cabinDimensionsOrder = $request->input('cabinDimensionsOrder');
        $cabinDimensionsOrderArray = explode(',', $cabinDimensionsOrder);
        $count = 1;
        foreach ($cabinDimensionsOrderArray as $cabinDimensionId) {
            $cabinDimensionObj = CabinDimension::find($cabinDimensionId);
            $cabinDimensionObj->sort_order = $count;
            $cabinDimensionObj->update();
            ++$count;
        }
    }

    public function updateCabinDimensionStatus(Request $request)
    {
        $cabinDimensionObj = CabinDimension::find($request->id);
        $cabinDimensionObj = $this->setCabinDimensionStatus($request, $cabinDimensionObj);
        $cabinDimensionObj->save();

        return response()->json(['status' => 'success', 'message' => $cabinDimensionObj->status]);
    }

    public function destroy(CabinDimension $cabinDimensionObj)
    {
        $cabinDimensionObj->delete();
        echo 'ok';
    }
}

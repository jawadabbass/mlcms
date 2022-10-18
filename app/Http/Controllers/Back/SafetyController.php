<?php

namespace App\Http\Controllers\Back;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Back\Safety;
use App\Traits\SafetyTrait;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Back\SafetyBackFormRequest;

class SafetyController extends Controller
{
    use SafetyTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = config('Constants.SITE_NAME') . ': Safeties Management';
        $msg = '';

        return view('back.safeties.index', compact('title', 'msg'));
    }

    public function fetchSafetiesAjax(Request $request)
    {
        $safeties = Safety::select('*');

        return Datatables::of($safeties)
            ->filter(function ($query) use ($request) {
                if ($request->has('title') && !empty($request->title)) {
                    $query->where('safeties.title', 'like', "%{$request->get('title')}%");
                }
                if ($request->has('status') && !empty($request->status)) {
                    $query->where('safeties.status', 'like', "{$request->get('status')}");
                }
            })
            ->addColumn('status', function ($safeties) {
                $str = '<select class="form-control" name="status" id="status_' . $safeties->id . '" onchange="updateSafetyStatus(' . $safeties->id . ', \'' . $safeties->status . '\', this.value);">';
                $str .= generateSafetiesStatusDropDown($safeties->status, false);
                $str .= '</select>';

                return $str;
            })
            ->addColumn('action', function ($safeties) {
                return '
                		<a href="' . route('safeties.edit', ['safetyObj' => $safeties->id]) . '" class="btn btn-warning m-2"><i class="fa-solid fa-pencil" aria-hidden="true"></i></a>
						<a href="javascript:void(0);" onclick="deleteSafety(' . $safeties->id . ');"  class="btn btn-danger m-2"><i class="fa-solid fa-trash" aria-hidden="true"></i></a>';
            })
            ->rawColumns(['status', 'action'])
            ->orderColumns(['title', 'status'], ':column $1')
            ->setRowId(function ($safeties) {
                return 'safetiesDtRow' . $safeties->id;
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
        $title = config('Constants.SITE_NAME') . ': Safeties Management';
        $msg = '';
        $safetyObj = new Safety();

        return view('back.safeties.create')
            ->with('safetyObj', $safetyObj)
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
    public function store(SafetyBackFormRequest $request)
    {
        $safetyObj = new Safety();
        $safetyObj = $this->setSafetyValues($request, $safetyObj);
        $safetyObj->save();

        flash('Safety has been added!', 'success');

        return Redirect::route('safeties.index');
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
    public function edit(Safety $safetyObj)
    {
        $title = config('Constants.SITE_NAME') . ': Safeties Management';
        $msg = '';

        return view('back.safeties.edit')
            ->with('safetyObj', $safetyObj)
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
    public function update(SafetyBackFormRequest $request, Safety $safetyObj)
    {
        $safetyObj = $this->setSafetyValues($request, $safetyObj);
        $safetyObj->save();

        flash('Safety has been updated!', 'success');

        return Redirect::route('safeties.index');
    }

    public function sortSafeties()
    {
        $title = config('Constants.SITE_NAME') . ': Safeties Management';
        $msg = '';

        return view('back.safeties.sort')->with('title', $title)
            ->with('msg', $msg);
    }

    public function safetiesSortData(Request $request)
    {
        $safeties = Safety::select('safeties.id', 'safeties.title', 'safeties.sort_order')
            ->orderBy('sort_order', 'ASC')->get();
        $str = '<ul id="sortable">';
        if ($safeties != null) {
            foreach ($safeties as $safetyObj) {
                $str .= '<li class="ui-state-default" id="' . $safetyObj->id . '"><i class="fa-solid fa-sort"></i> ' . $safetyObj->title . '</li>';
            }
        }
        echo $str . '</ul>';
    }

    public function safetiesSortUpdate(Request $request)
    {
        $safetiesOrder = $request->input('safetiesOrder');
        $safetiesOrderArray = explode(',', $safetiesOrder);
        $count = 1;
        foreach ($safetiesOrderArray as $safetyId) {
            $safetyObj = Safety::find($safetyId);
            $safetyObj->sort_order = $count;
            $safetyObj->update();
            ++$count;
        }
    }

    public function updateSafetyStatus(Request $request)
    {
        $safetyObj = Safety::find($request->id);
        $safetyObj = $this->setSafetyStatus($request, $safetyObj);
        $safetyObj->save();

        return response()->json(['status' => 'success', 'message' => $safetyObj->status]);
    }

    public function destroy(Safety $safetyObj)
    {
        $safetyObj->delete();
        echo 'ok';
    }
}

<?php

namespace App\Http\Controllers\Back;

use Illuminate\Http\Request;
use App\Helpers\ImageUploader;
use App\Http\Controllers\Controller;
use App\Models\Back\FleetCategory;
use App\Traits\FleetCategoryTrait;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Back\FleetCategoryBackFormRequest;

class FleetCategoryController extends Controller
{
    use FleetCategoryTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = config('Constants.SITE_NAME') . ': Fleet Categories Management';
        $msg = '';

        return view('back.fleet_categories.index', compact('title', 'msg'));
    }

    public function fetchFleetCategoriesAjax(Request $request)
    {
        $fleetCategories = FleetCategory::select('*');

        return Datatables::of($fleetCategories)
            ->filter(function ($query) use ($request) {
                if ($request->has('title') && !empty($request->title)) {
                    $query->where('fleet_categories.title', 'like', "%{$request->get('title')}%");
                }
                if ($request->has('description') && !empty($request->description)) {
                    $query->where('fleet_categories.description', 'like', "%{$request->get('description')}%");
                }
                if ($request->has('status') && !empty($request->status)) {
                    $query->where('fleet_categories.status', 'like', "{$request->get('status')}");
                }
            })
            ->addColumn('image', function ($fleetCategories) {
                return '<img src="' . ImageUploader::print_image_src($fleetCategories->image, 'fleet_categories/thumb') . '" style="max-width:165px !important; max-height:165px !important;"/>';
            })
            ->addColumn('status', function ($fleetCategories) {
                $str = '<select class="form-control" name="status" id="status_' . $fleetCategories->id . '" onchange="updateFleetCategoryStatus(' . $fleetCategories->id . ', \'' . $fleetCategories->status . '\', this.value);">';
                $str .= generateFleetCategoriesStatusDropDown($fleetCategories->status, false);
                $str .= '</select>';

                return $str;
            })
            ->addColumn('action', function ($fleetCategories) {
                return '
                		<a href="' . route('fleetCategories.edit', ['fleetCategoryObj' => $fleetCategories->id]) . '" class="btn btn-warning m-2"><i class="fa-solid fa-pencil" aria-hidden="true"></i></a>
						<a href="javascript:void(0);" onclick="deleteFleetCategory(' . $fleetCategories->id . ');"  class="btn btn-danger m-2"><i class="fa-solid fa-trash" aria-hidden="true"></i></a>';
            })
            ->rawColumns(['image', 'status', 'action'])
            ->orderColumns(['title', 'description', 'status'], ':column $1')
            ->setRowId(function ($fleetCategories) {
                return 'fleetCategoriesDtRow' . $fleetCategories->id;
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
        $title = config('Constants.SITE_NAME') . ': Fleet Categories Management';
        $msg = '';
        $fleetCategoryObj = new FleetCategory();

        return view('back.fleet_categories.create')
            ->with('fleetCategoryObj', $fleetCategoryObj)
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
    public function store(FleetCategoryBackFormRequest $request)
    {
        $fleetCategoryObj = new FleetCategory();
        $fleetCategoryObj = $this->setFleetCategoryValues($request, $fleetCategoryObj);
        $fleetCategoryObj->save();

        flash('Fleet Category has been added!', 'success');

        return Redirect::route('fleetCategories.index');
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
    public function edit(FleetCategory $fleetCategoryObj)
    {
        $title = config('Constants.SITE_NAME') . ': Fleet Categories Management';
        $msg = '';

        return view('back.fleet_categories.edit')
            ->with('fleetCategoryObj', $fleetCategoryObj)
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
    public function update(FleetCategoryBackFormRequest $request, FleetCategory $fleetCategoryObj)
    {
        $fleetCategoryObj = $this->setFleetCategoryValues($request, $fleetCategoryObj);
        $fleetCategoryObj->save();

        flash('Fleet Category has been updated!', 'success');

        return Redirect::route('fleetCategories.index');
    }

    public function sortFleetCategories()
    {
        $title = config('Constants.SITE_NAME') . ': Fleet Categories Management';
        $msg = '';

        return view('back.fleet_categories.sort')->with('title', $title)
            ->with('msg', $msg);
    }

    public function fleetCategoriesSortData(Request $request)
    {
        $fleetCategories = FleetCategory::select('fleet_categories.id', 'fleet_categories.title', 'fleet_categories.sort_order')
            ->orderBy('sort_order', 'ASC')->get();
        $str = '<ul id="sortable">';
        if ($fleetCategories != null) {
            foreach ($fleetCategories as $fleetCategoryObj) {
                $str .= '<li class="ui-state-default" id="' . $fleetCategoryObj->id . '"><i class="fa-solid fa-sort"></i> ' . $fleetCategoryObj->title . '</li>';
            }
        }
        echo $str . '</ul>';
    }

    public function fleetCategoriesSortUpdate(Request $request)
    {
        $fleetCategoriesOrder = $request->input('fleetCategoriesOrder');
        $fleetCategoriesOrderArray = explode(',', $fleetCategoriesOrder);
        $count = 1;
        foreach ($fleetCategoriesOrderArray as $fleetCategoryId) {
            $fleetCategoryObj = FleetCategory::find($fleetCategoryId);
            $fleetCategoryObj->sort_order = $count;
            $fleetCategoryObj->update();
            ++$count;
        }
    }

    public function updateFleetCategoryStatus(Request $request)
    {
        $fleetCategoryObj = FleetCategory::find($request->id);
        $fleetCategoryObj = $this->setFleetCategoryStatus($request, $fleetCategoryObj);
        $fleetCategoryObj->save();

        return response()->json(['status' => 'success', 'message' => $fleetCategoryObj->status]);
    }

    public function destroy(FleetCategory $fleetCategoryObj)
    {
        ImageUploader::deleteImage('fleet_categories', $fleetCategoryObj->image, true);
        $fleetCategoryObj->delete();
        echo 'ok';
    }
}

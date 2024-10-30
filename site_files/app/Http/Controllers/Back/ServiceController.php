<?php

namespace App\Http\Controllers\Back;

use App\Models\Back\Service;
use App\Traits\ServiceTrait;
use Illuminate\Http\Request;
use App\Helpers\ImageUploader;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Back\ServiceBackFormRequest;

class ServiceController extends Controller
{
    use ServiceTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = config('Constants.SITE_NAME') . ': Services Management';
        $msg = '';
        return view('back.services.index', compact('title', 'msg'));
    }

    public function fetchServicesAjax(Request $request)
    {
        $services = Service::select('*');
        return DataTables::of($services)
            ->filter(function ($query) use ($request) {
                if ($request->has('title') && !empty($request->title)) {
                    $query->where('services.title', 'like', "%{$request->get('title')}%");
                }
                if ($request->has('parent_id') && !empty($request->parent_id)) {
                    $query->where('services.parent_id', $request->get('parent_id'));
                }
                if ($request->has('status') && !empty($request->status)) {
                    $query->where('services.status', 'like', "{$request->get('status')}");
                }
            })
            ->addColumn('parent_id', function ($services) {
                if ($services->parent_id > 0) {
                    $html = $services->parentService->title;
                    getParentServicesList($html, $services->parentService->parent_id);
                    return $html;
                } else {
                    return '';
                }
            })
            ->addColumn('status', function ($services) {
                $str = '<select class="form-control" name="status" id="status_' . $services->id . '" onchange="updateServiceStatus(' . $services->id . ', \'' . $services->status . '\', this.value);">';
                $str .= generateServiceStatusDropDown($services->status, false);
                $str .= '</select>';
                return $str;
            })
            ->addColumn('action', function ($services) {
                return '
                <a href="' . route('services.edit', ['serviceObj' => $services->id]) . '" class="btn btn-info"><i class="fa-solid fa-pencil" aria-hidden="true"></i></a>
				<a href="javascript:void(0);" onclick="deleteService(' . $services->id . ');" class="btn btn-danger"><i class="fa-solid fa-trash" aria-hidden="true"></i></a>				
                ';
            })
            ->rawColumns(['parent_id', 'action', 'status'])
            ->orderColumns(['id', 'title', 'parent_id', 'status'], ':column $1')
            ->setRowId(function ($services) {
                return 'servicesDtRow' . $services->id;
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
        $title = config('Constants.SITE_NAME') . ': Services Management';
        $msg = '';
        $serviceObj = new Service();
        return view('back.services.create')
            ->with('serviceObj', $serviceObj)
            ->with('title', $title)
            ->with('msg', $msg);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ServiceBackFormRequest $request)
    {
        $serviceObj = new Service();
        $serviceObj = $this->setServiceValues($request, $serviceObj);
        $serviceObj->save();

        flash('Service has been added!', 'success');
        return Redirect::route('services.index');
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
    public function edit(Service $serviceObj)
    {
        $title = config('Constants.SITE_NAME') . ': Services Management';
        $msg = '';
        return view('back.services.edit')
            ->with('serviceObj', $serviceObj)
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
    public function update(ServiceBackFormRequest $request, Service $serviceObj)
    {
        $serviceObj = $this->setServiceValues($request, $serviceObj);
        $serviceObj->save();

        /*         * ************************************ */

        flash('Service has been updated!', 'success');
        return Redirect::route('services.index');
    }

    public function updateServiceStatus(Request $request)
    {
        $serviceObj = Service::find($request->id);
        $serviceObj = $this->setServiceStatus($request, $serviceObj);
        $serviceObj->update();

        return response()->json(['status' => 'success', 'message' => $serviceObj->status]);
    }

    public function destroy(Service $serviceObj)
    {
        deleteService($serviceObj->id);
        session(['message' => 'Deleted Successfully', 'type' => 'success']);
        echo 'ok';
    }

    public function sortServices()
    {
        $title = config('Constants.SITE_NAME') . ': Services Management';
        $msg = '';
        return view('back.services.sort')->with('title', $title)
            ->with('msg', $msg);
    }

    public function servicesSortData(Request $request)
    {
        $html = '<ul id="sortable">';
        $parentHtml = '';
        getServiceliForSort($html, $parentHtml, $request->input('parent_id', 0));
        echo $html . '</ul>';
    }

    public function servicesSortUpdate(Request $request)
    {
        $servicesOrder = $request->input('servicesOrder');
        $servicesOrderArray = explode(',', $servicesOrder);
        $count = 1;
        foreach ($servicesOrderArray as $serviceId) {
            $serviceObj = Service::find($serviceId);
            $serviceObj->sort_order = $count;
            $serviceObj->update();
            $count++;
        }
    }
}

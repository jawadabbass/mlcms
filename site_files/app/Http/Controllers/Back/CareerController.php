<?php

namespace App\Http\Controllers\Back;

use App\Models\Back\Career;
use App\Traits\CareerTrait;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Helpers\ImageUploader;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Back\CareerBackFormRequest;
use App\Models\Back\CareerBenefit;

class CareerController extends Controller
{
    use CareerTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = FindInsettingArr('business_name') . ': Careers Management';
        $msg = '';
        return view('back.careers.index', compact('title', 'msg'));
    }
    public function fetchCareersAjax(Request $request)
    {
        $career = Career::select('*');
        return Datatables::of($career)
            ->filter(function ($query) use ($request) {
                if ($request->has('title') && !empty($request->title)) {
                    $query->where('careers.title', 'like', "%{$request->get('title')}%");
                }
                if ($request->has('description') && !empty($request->description)) {
                    $query->where('careers.description', 'like', "%{$request->get('description')}%");
                }
                if ($request->has('status') && !empty($request->status)) {
                    $query->where('careers.status', 'like', "{$request->get('status')}");
                }
            })
            ->addColumn('created_at', function ($career) {
                return date('m-d-Y', strtotime($career->created_at));
            })
            ->addColumn('apply_by_date_time', function ($career) {
                return $career->apply_by_date_time;
            })
            ->addColumn('status', function ($career) {
                $str = '<label class="switch">';
                $str .= '<input type="checkbox" name="status" id="sts_' . $career->id . '" ' . ($career->status == 'active' ? 'checked' : '') . ' value="' . $career->status . '" onClick="updateCareerStatus(' . $career->id . ', \'' . $career->status . '\', this.checked ? \'active\' : \'inactive\')">';
                $str .= '<div class="slider round">';
                $str .= '<strong class="on">Active</strong>';
                $str .= '<strong class="off">Inactive</strong>';
                $str .= '</div>';
                $str .= '</label>';
                return $str;
            })
            ->addColumn('description', function ($career) {
                $str = Str::limit(strip_tags($career->description), 200, '...');
                return $str;
            })
            ->addColumn('action', function ($career) {
                $pdf_doc = '';
                if (!empty($career->pdf_doc)) {
                    $pdf_doc = '<a href=" ' . asset_uploads("careers/") . $career->pdf_doc . '"  class="btn btn-success"  target="_blank"><i class="fa-solid fa-file-pdf"></i></i></a>';
                }
                return '
                		<a href="' . route('career.edit', ['careerObj' => $career->id]) . '" class="btn btn-warning m-2"><i class="fas fa-edit" aria-hidden="true"></i></a>
						' . $pdf_doc . '
                        <a href="javascript:void(0);" onclick="deleteCareer(' . $career->id . ');"  class="btn btn-danger m-2"><i class="fas fa-trash" aria-hidden="true"></i></a>';
            })
            ->rawColumns(['created_at', 'apply_by_date_time', 'status', 'action'])
            ->orderColumns(['created_at', 'apply_by_date_time', 'title', 'description', 'status'], ':column $1')
            ->setRowId(function ($career) {
                return 'careerDtRow' . $career->id;
            })
            ->make(true);
        //$query = $dataTable->getQuery()->get();
        //return $query;
    }
    /**
     * Show the form for creating a career resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = FindInsettingArr('business_name') . ': Careers Management';
        $msg = '';
        $careerObj = new Career();
        return view('back.careers.create')
            ->with('careerObj', $careerObj)
            ->with('title', $title)
            ->with('msg', $msg);
    }
    /**
     * Store a careerly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CareerBackFormRequest $request)
    {
        $careerObj = new Career();
        $careerObj = $this->setCareerValues($request, $careerObj);
        $careerObj->save();
        if (count($request->input('benefits', [])) > 0) {
            foreach ($request->input('benefits') as $benefit) {
                $careerBenefitObj = new CareerBenefit();
                $careerBenefitObj->title = $benefit;
                $careerBenefitObj->career_id = $careerObj->id;
                $careerBenefitObj->save();
            }
        }
        session(['message' => 'Career has been added!', 'type' => 'success']);
        return Redirect::route('careers.index');
    }
    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id) {}
    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Career $careerObj)
    {
        $title = FindInsettingArr('business_name') . ': Careers Management';
        $msg = '';
        return view('back.careers.edit')
            ->with('careerObj', $careerObj)
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
    public function update(CareerBackFormRequest $request, Career $careerObj)
    {
        $careerObj = $this->setCareerValues($request, $careerObj);
        $careerObj->save();
        if (count($request->input('benefits', [])) > 0) {
            CareerBenefit::where('career_id', $careerObj->id)->delete();
            foreach ($request->input('benefits') as $benefit) {
                $careerBenefitObj = new CareerBenefit();
                $careerBenefitObj->title = $benefit;
                $careerBenefitObj->career_id = $careerObj->id;
                $careerBenefitObj->save();
            }
        }
        session(['message' => 'Updated Successfully', 'type' => 'success']);
        return Redirect::route('careers.index');
    }
    public function sortCareers()
    {
        $title = FindInsettingArr('business_name') . ': Careers Management';
        $msg = '';
        return view('back.careers.sort')->with('title', $title)
            ->with('msg', $msg);
    }
    public function careersSortData(Request $request)
    {
        $careers = Career::select('careers.id', 'careers.title', 'careers.sort_order')
            ->orderBy('sort_order', 'ASC')->get();
        $str = '<ul id="sortable">';
        if ($careers != null) {
            foreach ($careers as $careerObj) {
                $str .= '<li class="ui-state-default" id="' . $careerObj->id . '"><i class="fas fa-sort"></i> ' . $careerObj->title . '</li>';
            }
        }
        echo $str . '</ul>';
    }
    public function careersSortUpdate(Request $request)
    {
        $careersOrder = $request->input('careersOrder');
        $careersOrderArray = explode(',', $careersOrder);
        $count = 1;
        foreach ($careersOrderArray as $careerId) {
            $careerObj = Career::find($careerId);
            $careerObj->sort_order = $count;
            $careerObj->update();
            ++$count;
        }
    }
    public function updateCareerStatus(Request $request)
    {
        $careerObj = Career::find($request->id);
        $careerObj = $this->setCareerStatus($request, $careerObj);
        $careerObj->save();
        return response()->json(['status' => 'success', 'message' => $careerObj->status]);
    }
    public function destroy(Career $careerObj)
    {
        CareerBenefit::where('career_id', $careerObj->id)->delete();
        ImageUploader::deleteFile('careers', $careerObj->pdf_doc);
        $careerObj->delete();
        session(['message' => 'Deleted Successfully', 'type' => 'success']);
        echo 'ok';
    }
    public function delete_document()
    {
        $id = request('id');
        $careerObj = Career::find($id);
        ImageUploader::deleteFile('careers', $careerObj->pdf_doc);
        $careerObj->pdf_doc = '';
        $careerObj->save();
        return response([
            'status' => true,
            'message' => 'File deleted successfully!'
        ]);
    }
}

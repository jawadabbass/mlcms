<?php

namespace App\Http\Controllers\Back;

use App\Models\Back\Career;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Back\JobApplication;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;

class JobApplicationController extends Controller
{

    public function index()
    {
        $title = FindInsettingArr('business_name') . ': Job Applications  Management';
        $msg = '';

        return view('back.job_applications.index', compact('title', 'msg'));
    }

    public function fetchJobApplicationsAjax(Request $request)
    {
        $jobApplication = JobApplication::select('*');

        return Datatables::of($jobApplication)
            ->filter(function ($query) use ($request) {
                if ($request->has('title') && !empty($request->title)) {
                    $careerIds = Career::where('title', 'like', '%' . $request->title . '%')->pluck('id')->toArray();
                    $query->whereIn('job_applications.career_id', $careerIds);
                }
            })
            ->addColumn('created_at', function ($jobApplication) {
                return date('m-d-Y', strtotime($jobApplication->created_at));
            })
            ->addColumn('career_id', function ($jobApplication) {
                $careerObj = Career::find($jobApplication->career_id);
                return $careerObj->title;
            })
            ->addColumn('action', function ($jobApplication) {
                return '
                		<a href="javascript:void(0);" onclick="showJobApplication(' . $jobApplication->id . ');" class="btn btn-warning m-2"><i class="fas fa-eye" aria-hidden="true"></i></a>
						<a href="javascript:void(0);" onclick="deleteJobApplication(' . $jobApplication->id . ');"  class="btn btn-danger m-2"><i class="fas fa-trash" aria-hidden="true"></i></a>';
            })
            ->rawColumns(['created_at', 'career_id', 'action'])
            ->orderColumns(['created_at', 'career_id', 'name', 'email', 'phone'], ':column $1')
            ->setRowId(function ($jobApplication) {
                return 'jobApplicationDtRow' . $jobApplication->id;
            })
            ->make(true);
    }

    public function show(JobApplication $jobApplicationObj)
    {
        $title = FindInsettingArr('business_name') . ': Job Applications Management';
        $msg = '';
        $careerObj = Career::find($jobApplicationObj->career_id);
        echo view('back.job_applications.show')
            ->with('jobApplicationObj', $jobApplicationObj)
            ->with('careerObj', $careerObj)
            ->with('title', $title)
            ->with('msg', $msg)
            ->render();
    }


    public function destroy(JobApplication $jobApplicationObj)
    {
        $jobApplicationObj->delete();
        session(['message' => 'Deleted Successfully', 'type' => 'success']);
        echo 'ok';
    }
}

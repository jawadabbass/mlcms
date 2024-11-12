<?php

namespace App\Http\Controllers\Back;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Back\GeneralEmailTemplate;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Back\GeneralEmailTemplateBackFormRequest;
use App\Traits\GeneralEmailTemplateTrait;

class GeneralEmailTemplateController extends Controller
{
    use GeneralEmailTemplateTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = config('Constants.SITE_NAME') . ': Email Templates Management';
        $msg = '';
        return view('back.general_email_templates.index', compact('title', 'msg'));
    }

    public function fetchGeneralEmailTemplatesAjax(Request $request)
    {
        $generalEmailTemplates = GeneralEmailTemplate::select('*')->where('is_temporary', 0);
        return DataTables::of($generalEmailTemplates)
            ->filter(function ($query) use ($request) {
                if ($request->has('template_name') && !empty($request->template_name)) {
                    $query->where('general_email_templates.template_name', 'like', "%{$request->get('template_name')}%");
                }
                if ($request->has('subject') && !empty($request->subject)) {
                    $query->where('general_email_templates.subject', 'like', "%{$request->get('subject')}%");
                }
            })
            ->addColumn('action', function ($generalEmailTemplates) {
                return '
                <a href="' . route('generalEmailTemplates.edit', ['generalEmailTemplateObj' => $generalEmailTemplates->id]) . '" class="btn btn-warning m-1"><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp;Edit</a>
                <a href="' . route('generalEmailTemplates.destroy', ['generalEmailTemplateObj' => $generalEmailTemplates->id]) . '" class="btn btn-danger m-1" onclick="return confirm(\'Are you sure?\')"><i class="fa fa-trash-o" aria-hidden="true"></i>&nbsp;Delete</a>
                ';
            })
            ->rawColumns(['action'])
            ->orderColumns(['general_email_template'], ':column $1')
            ->setRowId(function ($generalEmailTemplates) {
                return 'generalEmailTemplatesDtRow' . $generalEmailTemplates->id;
            })
            ->make(true);
        //$query = $dataTable->getQuery()->get();
        //return $query;
    }

    public function create(Request $request)
    {
        $title = config('Constants.SITE_NAME') . ': Email Templates Management';
        $msg = '';
        $generalEmailTemplateObj = new GeneralEmailTemplate();
        $generalEmailTemplateObj->dynamic_values = '{NAME},{EMAIL},{PHONE}';
        return view('back.general_email_templates.add')
            ->with('generalEmailTemplateObj', $generalEmailTemplateObj)
            ->with('title', $title)
            ->with('msg', $msg);
    }

    public function store(GeneralEmailTemplateBackFormRequest $request)
    {
        $generalEmailTemplateObj = new GeneralEmailTemplate();
        $generalEmailTemplateObj = $this->setGeneralEmailTemplateValues($request, $generalEmailTemplateObj);
        $generalEmailTemplateObj->save();

        /******************************* */
		/******************************* */
		$recordUpdateHistoryData = [
			'record_id' => $generalEmailTemplateObj->id,
			'record_title' => $generalEmailTemplateObj->template_name,
			'record_link' => url('adminmedia/generalEmailTemplates/'.$generalEmailTemplateObj->id.'/edit'),
            'model_or_table' => 'GeneralEmailTemplate',
			'admin_id' => auth()->user()->id,
			'ip' => request()->ip(),
			'draft' => json_encode($generalEmailTemplateObj->toArray()),
		];
		recordUpdateHistory($recordUpdateHistoryData);
		/******************************* */
		/******************************* */

        /*         * ************************************ */

        flash('Email Template has been updated!')->success();
        return Redirect::route('generalEmailTemplates.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(GeneralEmailTemplate $generalEmailTemplateObj)
    {
        $title = config('Constants.SITE_NAME') . ': Email Templates Management';
        $msg = '';
        return view('back.general_email_templates.edit')
            ->with('generalEmailTemplateObj', $generalEmailTemplateObj)
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
    public function update(GeneralEmailTemplateBackFormRequest $request, GeneralEmailTemplate $generalEmailTemplateObj)
    {
        $generalEmailTemplateObj = $this->setGeneralEmailTemplateValues($request, $generalEmailTemplateObj);
        $generalEmailTemplateObj->update();

        /******************************* */
		/******************************* */
		$recordUpdateHistoryData = [
			'record_id' => $generalEmailTemplateObj->id,
			'record_title' => $generalEmailTemplateObj->template_name,
			'record_link' => url('adminmedia/generalEmailTemplates/'.$generalEmailTemplateObj->id.'/edit'),
            'model_or_table' => 'GeneralEmailTemplate',
			'admin_id' => auth()->user()->id,
			'ip' => request()->ip(),
			'draft' => json_encode($generalEmailTemplateObj->toArray()),
		];
		recordUpdateHistory($recordUpdateHistoryData);
		/******************************* */
		/******************************* */

        /*         * ************************************ */

        flash('Email Template has been updated!')->success();
        return Redirect::route('generalEmailTemplates.index');
    }

    public function destroy(GeneralEmailTemplate $generalEmailTemplateObj)
    {
        $generalEmailTemplateObj->delete();

        /*         * ************************************ */

        flash('Email Template has been deleted!')->success();
        return Redirect::route('generalEmailTemplates.index');
    }

}

<?php

namespace App\Http\Controllers\Back;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Back\RecordUpdateHistory;
use Yajra\DataTables\Facades\DataTables;

class RecordUpdateHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $model_or_table, $record_id)
    {
        $title = config('Constants.SITE_NAME') . ': Record Update History Management';
        $msg = '';
        return view('back.record_update_history.index', compact('title', 'msg', 'model_or_table', 'record_id'));
    }

    public function fetchRecordUpdateHistoryAjax(Request $request)
    {
        $recordUpdateHistoryCollection = RecordUpdateHistory::select('*');
        return DataTables::of($recordUpdateHistoryCollection)
            ->filter(function ($query) use ($request) {
                if ($request->has('record_id') && $request->input('record_id', 0)) {
                    $query->where('record_update_history.record_id', $request->input('record_id', 0));
                }                
                if ($request->has('model_or_table') && !empty($request->input('model_or_table', ''))) {
                    $query->where('record_update_history.model_or_table', 'like', $request->input('model_or_table', ''));
                }
            })
            ->addColumn('created_at', function ($recordUpdateHistoryCollection) {
                return date('m-d-Y', strtotime($recordUpdateHistoryCollection->created_at)) . '<br>' . date('h:i:s A', strtotime($recordUpdateHistoryCollection->created_at));
            })
            ->addColumn('admin_id', function ($recordUpdateHistoryCollection) {
                $userObj = User::find($recordUpdateHistoryCollection->admin_id);
                return $userObj->name;
            })
            ->addColumn('record_title', function ($recordUpdateHistoryCollection) {
                return $recordUpdateHistoryCollection->model_or_table . '-' . $recordUpdateHistoryCollection->record_title;
            })
            ->addColumn('action', function ($recordUpdateHistoryCollection) {
                return '
                <a href="' . route('record.update.history.show', ['recordUpdateHistoryObj' => $recordUpdateHistoryCollection->id]) . '" class="btn btn-info" target="_blank"><i class="fa-solid fa-eye" aria-hidden="true"></i></a>';
            })
            ->rawColumns(['created_at', 'admin_id', 'record_title', 'action'])
            ->setRowId(function ($recordUpdateHistoryCollection) {
                return 'recordUpdateHistoryDtRow' . $recordUpdateHistoryCollection->id;
            })
            ->make(true);
    }

    public function show(RecordUpdateHistory $recordUpdateHistoryObj)
    {
        $title = config('Constants.SITE_NAME') . ': Record Update History Management';
        $msg = '';

        return view('back.record_update_history.show')
            ->with('recordUpdateHistoryObj', $recordUpdateHistoryObj)
            ->with('title', $title)
            ->with('msg', $msg);
    }
}

<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Back\MessageTemplate;
use App\Models\User;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = FindInsettingArr('business_name') . ': | Message Templates';
        $result = MessageTemplate::where('type', '!=', 'general')->get();
        return view('back.message_templates.index', compact('title', 'result'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = new MessageTemplate();
        // $data->title = $request->title;
        $data->body = $request->body;
        $data->type = 'general';
        $data->save();
        /******************************* */
        /******************************* */
        $recordUpdateHistoryData = [
            'record_id' => $data->id,
            'record_title' => $data->title . ' - ' . $data->type,
            'record_link' => url('adminmedia/message/' . $data->id . '/edit'),
            'model_or_table' => 'MessageTemplate',
            'admin_id' => auth()->user()->id,
            'ip' => request()->ip(),
            'draft' => json_encode($data->toArray()),
        ];
        recordUpdateHistory($recordUpdateHistoryData);
        /******************************* */
        /******************************* */
        session(['message' => 'Added Successfully', 'type' => 'success']);
        return back();
    }
    public function custom_msg_store(Request $request)
    {
        $data = new MessageTemplate();
        $data->title = $request->title;
        $data->body = $request->body;
        $data->type = 'custom';
        $data->save();
        /******************************* */
        /******************************* */
        $recordUpdateHistoryData = [
            'record_id' => $data->id,
            'record_title' => $data->title . ' - ' . $data->type,
            'record_link' => url('adminmedia/message/' . $data->id . '/edit'),
            'model_or_table' => 'MessageTemplate',
            'admin_id' => auth()->user()->id,
            'ip' => request()->ip(),
            'draft' => json_encode($data->toArray()),
        ];
        recordUpdateHistory($recordUpdateHistoryData);
        /******************************* */
        /******************************* */
        session(['message' => 'Added Successfully', 'type' => 'success']);
        return back();
    }
    public function custom_msg_update(Request $request, $id)
    {
        $data = MessageTemplate::find($id);
        $data->title = $request->title;
        $data->body = $request->editor1;
        $data->type = 'custom';
        $data->save();
        /******************************* */
        /******************************* */
        $recordUpdateHistoryData = [
            'record_id' => $data->id,
            'record_title' => $data->title . ' - ' . $data->type,
            'record_link' => url('adminmedia/message/' . $data->id . '/edit'),
            'model_or_table' => 'MessageTemplate',
            'admin_id' => auth()->user()->id,
            'ip' => request()->ip(),
            'draft' => json_encode($data->toArray()),
        ];
        recordUpdateHistory($recordUpdateHistoryData);
        /******************************* */
        /******************************* */


        session(['message' => 'Updated Successfully', 'type' => 'success']);
        // return back();
        return redirect(url('adminmedia/message'));
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return MessageTemplate::find($id);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = FindInsettingArr('business_name') . ': | Message Template Edit';
        $data = MessageTemplate::find($id);
        return view('back.message_templates.edit', compact('title', 'data'));
    }
    public function update(Request $request, $id)
    {
        $data = MessageTemplate::find($request->id);
        // $data->title = $request->title;
        $data->body = $request->body;
        $data->save();

        /******************************* */
        /******************************* */
        $recordUpdateHistoryData = [
            'record_id' => $data->id,
            'record_title' => $data->title . ' - ' . $data->type,
            'record_link' => url('adminmedia/message/' . $data->id . '/edit'),
            'model_or_table' => 'MessageTemplate',
            'admin_id' => auth()->user()->id,
            'ip' => request()->ip(),
            'draft' => json_encode($data->toArray()),
        ];
        recordUpdateHistory($recordUpdateHistoryData);
        /******************************* */
        /******************************* */

        session(['message' => 'Updated Successfully', 'type' => 'success']);
        return back();
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        MessageTemplate::destroy($id);
        session(['message' => 'Deleted Successfully', 'type' => 'success']);
        return response()->json(['status' => 'success', 'message' => 'Deleted']);
    }
}

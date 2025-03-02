<?php

namespace App\Http\Controllers\Back;

use Illuminate\Http\Request;
use App\Models\Back\Metadata;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Back\AssesmentQuestion;
use Illuminate\Support\Facades\Validator;

class AssesmentQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = AssesmentQuestion::orderBy('item_order', 'ASC')->paginate(20);
        $title = FindInsettingArr('business_name') . ':Assesment Question\'s Management';
        $msg = '';
        $number = Metadata::find(57);
        return view('back.assesment_questions.index', compact('products', 'title', 'msg', 'number'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $list_order = $request->list_order;
        $list = explode(',', $list_order);
        $i = 1;
        print_r($list);
        foreach ($list as $id) {
            // $product = Product::find($id);
            // $product->item_order = $i;
            // $product->save();
            $data = ['item_order' => $i,];
            $products = \DB::table('assesment_questions')->where('id', $id)->update($data);
            $i++;
            echo $i . ' ' . $id;
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'question' => 'required'
        ]);
        if ($validator->passes()) {
            if ($request->additional_fields == 0) {
                return back()->with('error', 'Please Select One Design Pattern');
            } elseif ($request->additional_fields == 1) {
                if (count($request->radio_field) < 2) {
                    return back()->with('error', 'Radio Pattern Atleast 2 Values Required');
                }
                foreach ($request->radio_field as $key => $radio) {
                    if ($radio == null) {
                        return back()->with('error', 'Radio Field Value Can Not Empty');
                    }
                }
                $data = [
                    'question' => $request->question,
                    'pattern' => 'radio',
                    'value' => json_encode($request->radio_field),
                ];
                $create = DB::table('assesment_questions')->insert($data);
                $createObj = DB::table('assesment_questions')->orderBy('id', 'desc')->first();
                /******************************* */
                /******************************* */
                $recordUpdateHistoryData = [
                    'record_id' => $createObj->id,
                    'record_title' => $createObj->question,
                    'record_link' => url('adminmedia/assesment_question/'.$createObj->id.'/edit'),
                    'model_or_table' => 'assesment_questions',
                    'admin_id' => auth()->user()->id,
                    'ip' => request()->ip(),
                    'draft' => json_encode($createObj->toArray()),
                ];
                recordUpdateHistory($recordUpdateHistoryData);
                /******************************* */
                /******************************* */
                return back()->with('success', 'Record Added Successfully');
            } elseif ($request->additional_fields == 2) {
                if (count($request->check_field) < 1) {
                    return back()->with('error', 'Radio Pattern Atleast 2 Values Required');
                }
                foreach ($request->check_field as $key => $check) {
                    if ($check == null) {
                        return back()->with('error', 'Radio Field Value Can Not Empty');
                    }
                }
                $data = [
                    'question' => $request->question,
                    'pattern' => 'check',
                    'value' => json_encode($request->check_field),
                ];
                $create = DB::table('assesment_questions')->insert($data);
                $createObj = DB::table('assesment_questions')->orderBy('id', 'desc')->first();
                /******************************* */
                /******************************* */
                $recordUpdateHistoryData = [
                    'record_id' => $createObj->id,
                    'record_title' => $createObj->question,
                    'record_link' => url('adminmedia/assesment_question/'.$createObj->id.'/edit'),
                    'model_or_table' => 'assesment_questions',
                    'admin_id' => auth()->user()->id,
                    'ip' => request()->ip(),
                    'draft' => json_encode($createObj->toArray()),
                ];
                recordUpdateHistory($recordUpdateHistoryData);
                /******************************* */
                /******************************* */
                return back()->with('success', 'Record Added Successfully');
            } else {
                $data = [
                    'question' => $request->question,
                    'pattern' => 'input',
                    'value' => 'input',
                ];
                $create = DB::table('assesment_questions')->insert($data);
                $createObj = DB::table('assesment_questions')->orderBy('id', 'desc')->first();
                /******************************* */
                /******************************* */
                $recordUpdateHistoryData = [
                    'record_id' => $createObj->id,
                    'record_title' => $createObj->question,
                    'record_link' => url('adminmedia/assesment_question/'.$createObj->id.'/edit'),
                    'model_or_table' => 'assesment_questions',
                    'admin_id' => auth()->user()->id,
                    'ip' => request()->ip(),
                    'draft' => json_encode($createObj->toArray()),
                ];
                recordUpdateHistory($recordUpdateHistoryData);
                /******************************* */
                /******************************* */
                return back()->with('success', 'Record Added Successfully');
            }
        }
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'question' => 'required'
        ]);
        if ($validator->passes()) {
            if ($request->additional_fields == 0) {
                return back()->with('error', 'Please Select One Design Pattern');
            } elseif ($request->additional_fields == 1) {
                if (count($request->radio_field) < 2) {
                    return back()->with('error', 'Radio Pattern Atleast 2 Values Required');
                }
                foreach ($request->radio_field as $key => $radio) {
                    if ($radio == null) {
                        return back()->with('error', 'Radio Field Value Can Not Empty');
                    }
                }
                $data = [
                    'question' => $request->question,
                    'pattern' => 'radio',
                    'value' => json_encode($request->radio_field),
                ];
                $create = \DB::table('assesment_questions')->where('id', $id)->update($data);
                $updateObj = DB::table('assesment_questions')->where('id', $id)->first();
                /******************************* */
                /******************************* */
                $recordUpdateHistoryData = [
                    'record_id' => $updateObj->id,
                    'record_title' => $updateObj->title,
                    'record_link' => url('adminmedia/assesment_question/'.$createObj->id.'/edit')                   'model_or_table' => 'assesment_questions',
                    'admin_id' => auth()->user()->id,
                    'ip' => request()->ip(),
                    'draft' => json_encode($updateObj->toArray()),
                ];
                recordUpdateHistory($recordUpdateHistoryData);
                /******************************* */
                /******************************* */
                return redirect()->route('assesment_question.index')->with('success', 'Record Updated Successfully');
            } elseif ($request->additional_fields == 2) {
                if (count($request->check_field) < 1) {
                    return back()->with('error', 'Radio Pattern Atleast 2 Values Required');
                }
                foreach ($request->check_field as $key => $check) {
                    if ($check == null) {
                        return back()->with('error', 'Radio Field Value Can Not Empty');
                    }
                }
                $data = [
                    'question' => $request->question,
                    'pattern' => 'check',
                    'value' => json_encode($request->check_field),
                ];
                $create = \DB::table('assesment_questions')->where('id', $id)->update($data);
                $updateObj = DB::table('assesment_questions')->where('id', $id)->first();
                /******************************* */
                /******************************* */
                $recordUpdateHistoryData = [
                    'record_id' => $updateObj->id,
                    'record_title' => $updateObj->title,
                    'record_link' => url('adminmedia/assesment_question/'.$createObj->id.'/edit')                   'model_or_table' => 'assesment_questions',
                    'admin_id' => auth()->user()->id,
                    'ip' => request()->ip(),
                    'draft' => json_encode($updateObj->toArray()),
                ];
                recordUpdateHistory($recordUpdateHistoryData);
                /******************************* */
                /******************************* */
                return redirect()->route('assesment_question.index')->with('success', 'Record Updated Successfully');
            } else {
                $data = [
                    'question' => $request->question,
                    'pattern' => 'input',
                    'value' => 'input',
                ];
                $create = \DB::table('assesment_questions')->where('id', $id)->update($data);
                $updateObj = DB::table('assesment_questions')->where('id', $id)->first();
                /******************************* */
                /******************************* */
                $recordUpdateHistoryData = [
                    'record_id' => $updateObj->id,
                    'record_title' => $updateObj->title,
                    'record_link' => url('adminmedia/assesment_question/'.$createObj->id.'/edit')                   'model_or_table' => 'assesment_questions',
                    'admin_id' => auth()->user()->id,
                    'ip' => request()->ip(),
                    'draft' => json_encode($updateObj->toArray()),
                ];
                recordUpdateHistory($recordUpdateHistoryData);
                /******************************* */
                /******************************* */
                return redirect()->route('assesment_question.index')->with('success', 'Record Updated Successfully');
            }
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        if ($id == '') {
            echo 'error';
            return;
        }
        $obj = AssesmentQuestion::find($id);
        $status = $obj->sts;
        if ($status == '') {
            echo 'invalid current status provided.';
            return;
        }

        if ($status == 1)
            $new_status = 0;
        else
            $new_status = 1;

        $obj->sts = $new_status;
        $obj->update();
        /******************************* */
        /******************************* */
        $recordUpdateHistoryData = [
            'record_id' => $obj->id,
            'record_title' => $obj->title,
            'record_link' => url('adminmedia/assesment_question/'.$createObj->id.'/edit')     'model_or_table' => 'assesment_questions',
            'admin_id' => auth()->user()->id,
            'ip' => request()->ip(),
            'draft' => json_encode($obj->toArray()),
        ];
        recordUpdateHistory($recordUpdateHistoryData);
        /******************************* */
        /******************************* */
        echo $new_status;
        return;
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = FindInsettingArr('business_name') . ':Edit Assesment Question';
        $msg = '';
        $result = \DB::table('assesment_questions')->where('id', $id)->first();
        return view('back.assesment_questions.edit', compact('result', 'title', 'msg'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $update = \DB::table('assesment_questions')->where('id', $id)->delete();
        session(['message' => 'Deleted Successfully', 'type' => 'success']);
    }
    public function addView()
    {
        $title = 'Add New Assesment Question';
        return view('back.assesment_questions.add', compact('title'));
    }
    public function update_receipts_assessment_question(Request $request)
    {
        $data = Metadata::find(57);
        $data->data_key = json_encode($request->email);
        $data->val1 = '';
        $data->save();
        return response()->json(['status' => true, 'message' => ' Assessment Questions Answered Recepients Has Been Updated Successfully']);
    }
}

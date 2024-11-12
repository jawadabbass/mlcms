<?php

namespace App\Http\Controllers\Back;

use App\Helpers\ImageUploader;
use App\Http\Controllers\Controller;
use App\Models\Back\Widget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class WidgetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = FindInsettingArr('business_name') . ': Block Management';
        $msg = '';
        $this->WidgetNullfields();
        $result = Widget::all();
        return view('back.widgets.index', compact('title', 'msg', 'result'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('back.widgets.create');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'heading' => 'required',
            'editor1' => 'required',
        ]);
        $widget = new Widget();
        $widget->page_slug = $request->page_slug;
        $widget->heading = $request->heading;
        $widget->page_slug = $request->page_slug;
        $widget->content = myform_admin_cms_filter(adjustUrl($request->editor1));
        $widget->additional_field_1 = $request->additional_field_1;
        $widget->additional_field_2 = $request->additional_field_2;
        $widget->additional_field_3 = $request->additional_field_3;
        $widget->additional_field_4 = $request->additional_field_4;
        $widget->additional_field_5 = $request->additional_field_5;
        $widget->additional_field_6 = $request->additional_field_6;
        $widget->additional_field_7 = $request->additional_field_7;
        $widget->additional_field_8 = $request->additional_field_8;
        $admin_data = [
            'show_heading' => 1,
            'show_content' => 1,
            'show_featured_img' => 1,
            'show_additional_fields' => 1,
        ];
        $additional_field_data = [
            'additional_field_1' => null,
            'additional_field_2' => null,
            'additional_field_3' => null,
            'additional_field_4' => null,
            'additional_field_5' => null,
            'additional_field_6' => null,
            'additional_field_7' => null,
            'additional_field_8' => null,
        ];
        $widget->additional_field_data = json_encode($additional_field_data);
        $widget->admin_data = json_encode($admin_data);
        $widget->dated = date('Y-m-d H:i:s');
        if (!empty($request->featured_img)) {
            $widget->featured_image = $request->featured_img;
        }
        $widget->featured_image_title = $request->featured_image_title;
        $widget->featured_image_alt = $request->featured_image_alt;
        $widget->save();

        /******************************* */
        /******************************* */
        $recordUpdateHistoryData = [
            'record_id' => $widget->ID,
            'record_title' => $widget->heading,
            'record_link' => url('adminmedia/widgets/'.$widget->ID.'/edit'),
            'model_or_table' => 'Widget',
            'admin_id' => auth()->user()->id,
            'ip' => request()->ip(),
            'draft' => json_encode($widget->toArray()),
        ];
        recordUpdateHistory($recordUpdateHistoryData);
        /******************************* */
        /******************************* */

        session(['message' => 'Added Successfully', 'type' => 'success']);
        return redirect(route('widgets.index'));
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
        $widget = Widget::find($id);
        $admin_data = json_decode($widget->admin_data);
        $additional_field_data = json_decode($widget->additional_field_data);
        $admin_data = json_decode($widget->admin_data);
        return view('back.widgets.edit', compact('widget', 'admin_data', 'additional_field_data'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        if ($id == '') {
            echo 'error';
            return;
        }
        $widget = Widget::find($id);
        $status = (int)$widget->sts;
        if ($status == 1) {
            $new_status = 0;
        } else {
            $new_status = 1;
        }
        $widget->sts = $new_status;
        $widget->update();
        /******************************* */
        /******************************* */
        $recordUpdateHistoryData = [
            'record_id' => $widget->ID,
            'record_title' => $widget->heading,
            'record_link' => url('adminmedia/widgets/'.$widget->ID.'/edit'),
            'model_or_table' => 'Widget',
            'admin_id' => auth()->user()->id,
            'ip' => request()->ip(),
            'draft' => json_encode($widget->toArray()),
        ];
        recordUpdateHistory($recordUpdateHistoryData);
        /******************************* */
        /******************************* */
        echo $new_status;
        return;
    }
    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $widget = Widget::find($id);
        $widget->heading = $request->heading;
        $widget->content = myform_admin_cms_filter(adjustUrl($request->editor1));
        $additional_field_data = [
            'additional_field_1' => $request->additional_field_1,
            'additional_field_2' => $request->additional_field_2,
            'additional_field_3' => $request->additional_field_3,
            'additional_field_4' => $request->additional_field_4,
            'additional_field_5' => $request->additional_field_5,
            'additional_field_6' => $request->additional_field_6,
            'additional_field_7' => $request->additional_field_7,
            'additional_field_8' => $request->additional_field_8,
        ];
        $widget->additional_field_data = json_encode($additional_field_data);
        if (!empty($request->featured_img)) {
            $widget->featured_image = $request->featured_img;
        }
        $widget->featured_image_title = $request->featured_image_title;
        $widget->featured_image_alt = $request->featured_image_alt;
        $widget->update();
        /******************************* */
        /******************************* */
        $recordUpdateHistoryData = [
            'record_id' => $widget->ID,
            'record_title' => $widget->heading,
            'record_link' => url('adminmedia/widgets/'.$widget->ID.'/edit'),
            'model_or_table' => 'Widget',
            'admin_id' => auth()->user()->id,
            'ip' => request()->ip(),
            'draft' => json_encode($widget->toArray()),
        ];
        recordUpdateHistory($recordUpdateHistoryData);
        /******************************* */
        /******************************* */
        session(['message' => 'Updated Successfully', 'type' => 'success']);
        return back();
    }
    public function removeFeaturedImage($id)
    {
        $widget = Widget::find($id);
        if (null !== $widget) {
            ImageUploader::deleteImage('widgets/', $widget->featured_image);
            $widget->featured_image = '';
            $widget->save();
            /******************************* */
            /******************************* */
            $recordUpdateHistoryData = [
                'record_id' => $widget->ID,
                'record_title' => $widget->heading,
                'record_link' => url('adminmedia/widgets/'.$widget->ID.'/edit'),
                'model_or_table' => 'Widget',
                'admin_id' => auth()->user()->id,
                'ip' => request()->ip(),
                'draft' => json_encode($widget->toArray()),
            ];
            recordUpdateHistory($recordUpdateHistoryData);
            /******************************* */
            /******************************* */
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->removeFeaturedImage($id);
        Widget::destroy($id);
        return json_encode(['status' => true]);
    }
    public function option($id)
    {
        $widget = Widget::find($id);
        $admin_data = json_decode($widget->admin_data);
        return view('back.widgets.option', compact('admin_data', 'widget'));
    }
    public function optionUpdate(Request $request, $id)
    {
        $widget = Widget::find($id);
        $admin_data = [
            'show_heading' => $request->show_heading,
            'show_content' => $request->show_content,
            'show_featured_img' => $request->show_featured_img,
        ];
        $widget->additional_field_1 = $request->additional_field_1;
        $widget->additional_field_2 = $request->additional_field_2;
        $widget->additional_field_3 = $request->additional_field_3;
        $widget->additional_field_4 = $request->additional_field_4;
        $widget->additional_field_5 = $request->additional_field_5;
        $widget->additional_field_6 = $request->additional_field_6;
        $widget->additional_field_7 = $request->additional_field_7;
        $widget->additional_field_8 = $request->additional_field_8;
        $widget->admin_data = json_encode($admin_data);
        $widget->pages_id = $request->pages_id;
        $widget->update();
        /******************************* */
        /******************************* */
        $recordUpdateHistoryData = [
            'record_id' => $widget->ID,
            'record_title' => $widget->heading,
            'record_link' => url('adminmedia/widgets/'.$widget->ID.'/edit'),
            'model_or_table' => 'Widget',
            'admin_id' => auth()->user()->id,
            'ip' => request()->ip(),
            'draft' => json_encode($widget->toArray()),
        ];
        recordUpdateHistory($recordUpdateHistoryData);
        /******************************* */
        /******************************* */
        session(['message' => 'Updated Successfully', 'type' => 'success']);
        return back();
    }
    public function WidgetNullfields()
    {
        $additional_field_data = [
            'additional_field_1' => null,
            'additional_field_2' => null,
            'additional_field_3' => null,
            'additional_field_4' => null,
            'additional_field_5' => null,
            'additional_field_6' => null,
            'additional_field_7' => null,
            'additional_field_8' => null,
        ];
        $additional_field_data1 = json_encode($additional_field_data);
        DB::table('widgets')->where('additional_field_data', '')->update(['additional_field_data' => $additional_field_data1]);
    }
}

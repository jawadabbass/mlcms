<?php

namespace App\Http\Controllers\Front;

use App\Models\Back\Video;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VideoController extends Controller
{
    public function index()
    {
        $seoArr = getSeoArrayModule(114);
        $videos = Video::paginate(20);
        return view('front.videos.index', compact('seoArr', 'videos'));
    }
    //>>>>>>>>>>>>>>>Start Videos
    public function list_video(Request $request)
    {
        $type = 'Videos';

        $type = trim($type);
        if ($type != '') {
            $module = CmsModule::where('type', $type)->first();
            if (!IsNullOrEmptyString($request->q)) {
                $moduleMembers = CmsModuleData::where('id', $request->q)->paginate(20);
            } else {
                $moduleMembers = CmsModuleData::where('cms_module_id', $module->id)
                    ->orderBy('content_type', 'DESC')
                    ->orderBy('item_order', 'ASC')
                    ->orderBy('id', 'ASC')
                    ->paginate(20);
            }
            $menu_types = MenuType::orderBy('id', 'ASC')->get();
            $title = config('Constants.SITE_NAME') . ': ' . strtoupper($module->type) . ' Management';
            $msg = '';
            return view('back.module.list_videos', compact('module', 'moduleMembers', 'menu_types', 'title', 'msg', 'file_upload_max_size'));
        }
        return redirect(back());
    }
}

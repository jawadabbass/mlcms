<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Back\CmsModule;
use App\Models\Back\CmsModuleData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use PhpParser\Node\Expr\Cast\String_;

class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $modules = CmsModule::paginate(100);

        $title = FindInsettingArr('business_name') . ': Module Management';

        return view('back.modules.index', compact('modules', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'term' => 'required',
            'module_fontawesome_icon' => 'required',
            'access_level' => 'required',
            'show_icon_in' => 'required',
            'show_is_featured' => 'required',
            'how_many_featured' => 'required',
        ]);
        $cmsModule = new CmsModule();
        $cmsModule->title = $request->title;
        $cmsModule->term = $request->term;
        $cmsModule->type = $request->type;
        $cmsModule->additional_fields = $request->additional_fields;
        $cmsModule->additional_field_title_1 = $request->additional_field_title_1;
        $cmsModule->additional_field_title_2 = $request->additional_field_title_2;
        $cmsModule->additional_field_title_3 = $request->additional_field_title_3;
        $cmsModule->additional_field_title_4 = $request->additional_field_title_4;
        $cmsModule->additional_field_title_5 = $request->additional_field_title_5;
        $cmsModule->additional_field_title_6 = $request->additional_field_title_6;
        $cmsModule->additional_field_title_7 = $request->additional_field_title_7;
        $cmsModule->additional_field_title_8 = $request->additional_field_title_8;
        $cmsModule->have_category = $request->have_category;
        $cmsModule->show_page_slug_field = $request->show_page_slug_field;
        $cmsModule->show_ordering_options = $request->show_ordering_field;
        $cmsModule->show_menu_field = $request->show_menu_field;

        $cmsModule->show_feature_img_field = $request->show_feature_img_field;
        $cmsModule->show_more_images_option = $request->show_more_images_option;
        $cmsModule->show_videos_option = $request->show_videos_option;

        $cmsModule->show_seo_field = $request->show_seo_field;
        $cmsModule->show_preview_link_on_listing_page = $request->show_preview_link_on_listing_page;
        $cmsModule->show_follow = $request->show_follow;
        $cmsModule->show_index = $request->show_index;
        $cmsModule->show_excerpt = $request->show_excerpt;
        $cmsModule->show_descp = $request->show_descp;
        $cmsModule->show_descp_2 = $request->show_descp_2;
        $cmsModule->crop_image = ($request->crop_image == 'Yes') ? 'Yes' : 'No';
        if ($request->feature_img_thmb_width != null) {
            $cmsModule->feature_img_thmb_width = $request->feature_img_thmb_width;
        }

        if (isset($request->feature_img_thmb_height) && $request->feature_img_thmb_height != null) {
            $cmsModule->feature_img_thmb_height = $request->feature_img_thmb_height;
        } else {
            $cmsModule->feature_img_thmb_height = 210;
        }
        $cmsModule->show_featured_image = $request->show_featured_image;
        $cmsModule->module_fontawesome_icon = $request->module_fontawesome_icon;
        $cmsModule->access_level = implode(',', $request->input('access_level', ['super-admin', 'normal-admin']));
        $cmsModule->show_icon_in = implode(',', $request->input('show_icon_in', ['show_icon_in_left', 'show_icon_in_dashboard']));
        $cmsModule->show_in_admin_menu = 0;
        $cmsModule->show_is_featured = $request->show_is_featured;
        $cmsModule->how_many_featured = $request->how_many_featured;
        $cmsModule->save();

        /*********************************** */
        $modData = new CmsModuleData();
        $modData->heading = $cmsModule->title;
        $modData->post_slug = $cmsModule->type;
        $modData->dated = date('Y-m-d H:i:s');
        $modData->is_pages = 1;
        $modData->permanent_page = 1;
        $modData->content_type = 'module';
        $modData->belongs_to_module_id = $cmsModule->id;
        $modData->cms_module_id = 1;
        $modData->save();
        $cmsModule->mod_menu_id = $modData->id;
        $cmsModule->update();
        /*********************************** */

        return redirect(route('modules.index'));
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
        $module = CmsModule::find($id);

        return json_encode($module);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return String_
     */
    public function edit($id, Request $request)
    {
        $module = CmsModule::find($id);
        $status = $module->show_in_admin_menu == 1 ? 'Yes' : 'No';
        if ($status == 'Yes') {
            $module->show_in_admin_menu = 0;
            $stat = 'No';
            $sts = 0;
        } else {
            $module->show_in_admin_menu = 1;
            $stat = 'Yes';
            $sts = 1;
        }
        if ((int)$module->belongs_to_module_id > 0) {
            $modData = CmsModuleData::find($module->belongs_to_module_id);
            $modData->sts = $sts;
            $modData->update();
        }
        $module->save();
        return $stat;
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
        $this->validate($request, [
            'title' => 'required',
            'term' => 'required',
            'module_fontawesome_icon' => 'required',
            'access_level' => 'required',
            'show_icon_in' => 'required',
            'show_is_featured' => 'required',
            'how_many_featured' => 'required',
        ]);
        $cmsModule = CmsModule::find($id);
        $cmsModule->title = $request->title;
        $cmsModule->term = $request->term;
        $cmsModule->type = $request->type;
        $cmsModule->additional_fields = $request->additional_fields;
        $cmsModule->additional_field_title_1 = $request->additional_field_title_1;
        $cmsModule->additional_field_title_2 = $request->additional_field_title_2;
        $cmsModule->additional_field_title_3 = $request->additional_field_title_3;
        $cmsModule->additional_field_title_4 = $request->additional_field_title_4;
        $cmsModule->additional_field_title_5 = $request->additional_field_title_5;
        $cmsModule->additional_field_title_6 = $request->additional_field_title_6;
        $cmsModule->additional_field_title_7 = $request->additional_field_title_7;
        $cmsModule->additional_field_title_8 = $request->additional_field_title_8;
        $cmsModule->have_category = $request->have_category;
        $cmsModule->show_page_slug_field = $request->show_page_slug_field;
        $cmsModule->show_ordering_options = $request->edit_ordering_field;
        $cmsModule->show_menu_field = $request->show_menu_field;
        $cmsModule->show_feature_img_field = $request->show_feature_img_field;
        $cmsModule->show_more_images_option = $request->show_more_images_option;
        $cmsModule->show_videos_option = $request->show_videos_option;
        $cmsModule->show_seo_field = $request->show_seo_field;
        $cmsModule->show_preview_link_on_listing_page = $request->show_preview_link_on_listing_page;
        $cmsModule->show_follow = $request->show_follow;
        $cmsModule->show_index = $request->show_index;
        $cmsModule->crop_image = ($request->crop_image == 'Yes') ? 'Yes' : 'No';
        if ($request->feature_img_thmb_width != null) {
            $cmsModule->feature_img_thmb_width = $request->feature_img_thmb_width;
        }
        $cmsModule->feature_img_thmb_height = $request->feature_img_thmb_height;
        $cmsModule->show_featured_image = $request->show_featured_image;
        $cmsModule->module_fontawesome_icon = $request->module_fontawesome_icon;
        $cmsModule->access_level = implode(',', $request->input('access_level', ['super-admin', 'normal-admin']));
        $cmsModule->show_icon_in = implode(',', $request->input('show_icon_in'));
        $cmsModule->show_excerpt = $request->show_excerpt;
        $cmsModule->show_descp = $request->show_descp;
        $cmsModule->show_descp_2 = $request->show_descp_2;

        $cmsModule->show_is_featured = $request->show_is_featured;
        $cmsModule->how_many_featured = $request->how_many_featured;

        $cmsModule->save();
        session(['message' => 'Updated Successfully', 'type' => 'success']);

        return redirect(route('modules.index'));
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
        CmsModuleData::where('cms_module_id', $id)->delete();

        $cmsModule = CmsModule::find($id);
        $cmsModule->delete();
        CmsModuleData::where('id', $cmsModule->mod_menu_id)->delete();
        session(['message' => 'Deleted Successfully', 'type' => 'success']);
        echo 'done';

        return;
    }

    public function updatePageOptions(Request $request)
    {
        $module_id = $request->module_id;
        $cmsModule = CmsModule::find($module_id);
        // $cmsModule->page_heading = $request->page_heading;
        $cmsModule->page_link = $request->page_link;
        $cmsModule->page_menu_option = $request->page_menu_option;
        $cmsModule->page_content = $request->page_content;
        $cmsModule->page_featured_img = $request->page_featured_img;
        $cmsModule->page_follow_index = $request->page_follow_index;
        $cmsModule->page_seo_option = $request->page_seo_option;

        $cmsModule->save();
        session(['message' => 'Updated Successfully', 'type' => 'success']);

        return redirect(route('modules.index'));
        cp('Here updatePageOptions');
    }
}

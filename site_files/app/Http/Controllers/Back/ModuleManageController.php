<?php

namespace App\Http\Controllers\Back;

use App\Models\Back\Menu;
use App\Models\Back\Product;
use Illuminate\Http\Request;
use App\Models\Back\Category;
use App\Models\Back\MenuType;
use App\Models\Back\Template;
use App\Helpers\ImageUploader;
use App\Models\Back\CmsModule;
use App\Models\Back\ModuleVideo;
use App\Models\Back\CmsModuleData;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Back\BlogCategory;
use App\Models\Back\BlogPost;
use App\Models\Back\ModuleDataImage;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ModuleManageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($type, Request $request)
    {
        // echo "Here I am in Manage Module controller";
        // type is cms
        $type = trim($type);
        if ($type != '') {
            $module = CmsModule::where('type', $type)->first();
            // echo "<pre>";
            // print_r( $module);
            // exit;
            if (!$module) {
                abort(404);
            }
            if (!IsNullOrEmptyString($request->q)) {
                $moduleMembers = CmsModuleData::where('id', $request->q)->orderBy('item_order', "ASC")->paginate(100);
            } else {
                $moduleMembers = getModuleData($module->id, 0, 0, 'item_order', 'asc', false);
            }
            $menu_types = MenuType::orderBy('id', 'ASC')->get();
            $title = FindInsettingArr('business_name') . ': ' . strtoupper($module->type) . ' Management';
            $msg = '';
            $allParentCategory = Category::orderBy('orderr', 'ASC')->get()->toArray();
            return view('back.module.index', compact('module', 'moduleMembers', 'menu_types', 'title', 'msg', 'allParentCategory'));
        }
        return redirect(back());
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($type, Request $request)
    {
        $id = $request->id;
        if ($id == '') {
            echo 'error';
            exit;
        }
        $moduleData = CmsModuleData::find($id);
        $current_status = (int)$moduleData->sts;
        $menuTableStatus = 'Y';
        if ($current_status == 1) {
            $new_status = 0;
            $menuTableStatus = 'N';
        } else {
            $new_status = 1;
            $menuTableStatus = 'Y';
        }
        $moduleData->sts = $new_status;
        $moduleData->save();
        $menu = Menu::where('menu_id', $id)->first();
        if ($menu != null) {
            $menu->status = $menuTableStatus;
            $menu->save();
        }

        /******************************* */
        /******************************* */
        $cmsModuleObj = CmsModule::find($moduleData->cms_module_id);
        $recordUpdateHistoryData = [
            'record_id' => $moduleData->id,
            'record_title' => $cmsModuleObj->title . ' - ' . $moduleData->heading,
            'record_link' => url('adminmedia/module/' . $cmsModuleObj->type . '/edit/' . $moduleData->id),
            'model_or_table' => 'CmsModuleData',
            'admin_id' => auth()->user()->id,
            'ip' => request()->ip(),
            'draft' => json_encode($moduleData->toArray()),
        ];
        recordUpdateHistory($recordUpdateHistoryData);
        /******************************* */
        /******************************* */

        echo $new_status;
        exit;
    }

    public function setIsFeatured($id, $new_is_featured)
    {
        $moduleData = CmsModuleData::find($id);

        if ($new_is_featured == 1) {
            $module = CmsModule::where('id', $moduleData->cms_module_id)->first();
            $totalFeatured = CmsModuleData::where('cms_module_id', $moduleData->cms_module_id)
                ->where('is_featured', 1)
                ->count();
            if ($totalFeatured == $module->how_many_featured) {
                echo 'Can not make featured; Already ' . $totalFeatured . ' are featured.';
                exit;
            }
        }
        $moduleData->is_featured = $new_is_featured;
        $moduleData->save();
        /******************************* */
        /******************************* */
        $cmsModuleObj = CmsModule::find($moduleData->cms_module_id);
        $recordUpdateHistoryData = [
            'record_id' => $moduleData->id,
            'record_title' => $cmsModuleObj->title . ' - ' . $moduleData->heading,
            'record_link' => url('adminmedia/module/' . $cmsModuleObj->type . '/edit/' . $moduleData->id),
            'model_or_table' => 'CmsModuleData',
            'admin_id' => auth()->user()->id,
            'ip' => request()->ip(),
            'draft' => json_encode($moduleData->toArray()),
        ];
        recordUpdateHistory($recordUpdateHistoryData);
        /******************************* */
        /******************************* */
        echo 'Done Successfully!';
        exit;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store($type, Request $request)
    {
        $module_id = $request->module_id;
        $moduleObj = CmsModule::find($module_id);
        $moduleData = new CmsModuleData();

        $rules = [
            'module_heading' => 'required',
        ];
        if ((bool)$moduleObj->show_page_slug_field) {
            $rules['module_slug'] = 'required';
        } else {
            $rules['module_slug'] = 'nullable';
        }
        $messages = [
            'module_heading.required' => 'Heading is required',
            'module_slug.required' => 'Slug is required',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }

        $moduleData->heading = $request->module_heading;
        $page_slug = $request->module_slug;
        $slugs = $page_slug;
        $slugs = ((isset($moduleObj) && $moduleObj->type && $moduleObj->id != 1) ? $moduleObj->type . '/' : '') . $slugs;
        $slugs = $this->createUniqueURL($slugs);
        $moduleData->post_slug = $slugs;
        $moduleData->content = myform_admin_cms_filter(adjustUrl($request->module_description));
        $moduleData->additional_field_1 = $request->additional_field_1;
        $moduleData->additional_field_2 = $request->additional_field_2;
        $moduleData->additional_field_3 = $request->additional_field_3;
        $moduleData->additional_field_4 = $request->additional_field_4;
        $moduleData->additional_field_5 = $request->additional_field_5;
        $moduleData->additional_field_6 = $request->additional_field_6;
        $moduleData->additional_field_7 = $request->additional_field_7;
        $moduleData->additional_field_8 = $request->additional_field_8;
        $moduleData->cms_module_id = $request->module_id;
        $moduleData->cat_id = $request->cat;
        $moduleData->is_pages = (strcmp($moduleObj->type, 'cms)') ? 1 : 0);
        $moduleData->show_follow = $request->show_follow;
        $moduleData->show_index = $request->show_index;
        $moduleData->meta_title = $request->meta_title;
        $moduleData->meta_keywords = $request->meta_keywords;
        $moduleData->meta_description = $request->meta_description;
        $moduleData->canonical_url = $request->canonical_url;
        $moduleData->dated = date('Y-m-d H:i:s');
        if (!empty($request->featured_img)) {
            $moduleData->featured_img = $request->featured_img;
        }
        $moduleData->featured_img_title = $request->featured_img_title;
        $moduleData->featured_img_alt = $request->featured_img_alt;
        $moduleData->save();
        /******************************* */
        /******************************* */
        $cmsModuleObj = CmsModule::find($moduleData->cms_module_id);
        $recordUpdateHistoryData = [
            'record_id' => $moduleData->id,
            'record_title' => $cmsModuleObj->title . ' - ' . $moduleData->heading,
            'record_link' => url('adminmedia/module/' . $cmsModuleObj->type . '/edit/' . $moduleData->id),
            'model_or_table' => 'CmsModuleData',
            'admin_id' => auth()->user()->id,
            'ip' => request()->ip(),
            'draft' => json_encode($moduleData->toArray()),
        ];
        recordUpdateHistory($recordUpdateHistoryData);
        /******************************* */
        /******************************* */
        /******************************* */
        $this->updateMoreImagesModuleDataId($request, $moduleData->id);
        /******************************* */
        /******************************* */
        $this->updateModuleVideosModuleDataId($request, $moduleData->id);
        /******************************* */
        /******************************* */
        $insert = $moduleData->id;
        $menu_types = $request->menu_type;
        if (isset($menu_types) && !empty($menu_types)) {
            foreach ($menu_types as $menu_type_id) {
                $menu = new Menu();
                $max_orders = DB::table('menus')->max('menu_sort_order');
                $max_order = $max_orders + 1;
                $menu->menu_id = $insert;
                $menu->menu_label = $request->module_heading;
                $slugPrefix = strcmp($moduleObj->type, 'cms)') ? '' : '';
                $menu->menu_url = $slugPrefix . $slugs;
                $menu->menu_types = $menu_type_id;
                $menu->menu_sort_order = $max_order;
                $menu->open_in_new_window = $request->open_in_new_window;
                $menu->show_no_follow = $request->show_no_follow;
                $menu->save();
            }
        }
        session(['message' => $moduleObj->term . ' added successfully', 'type' => 'success',]);
        return response()->json(['success' => 'Added new records.', 'module_id' => $request->module_id, 'module_data_id' => $moduleData->id]);
    }
    private function updateMoreImagesModuleDataId($request, $moduleDataId)
    {
        ModuleDataImage::where('session_id', 'like', $request->session_id)->update(['module_data_id' => $moduleDataId, 'session_id' => NULL]);
    }
    private function updateModuleVideosModuleDataId($request, $moduleDataId)
    {
        ModuleVideo::where('session_id', 'like', $request->session_id)->update(['module_data_id' => $moduleDataId, 'session_id' => NULL]);
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
    public function edit($type, $id)
    {
        $data = CmsModuleData::find($id);
        if ($data->content_type == 'module') {
            $data['module_data'] = CmsModule::find($data->belongs_to_module_id)->first();
        } else {
            $data['module_data'] = CmsModule::find($data->cms_module_id);
        }
        if (isset($data['module_data']->type)) {
            $data['post_slug'] = str_replace($data['module_data']->type . '/', '', $data['post_slug']);
        }
        $data['menus'] = Menu::where('menu_id', $id)->get();
        echo json_encode($data);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $type, $id)
    {
        $module_id = $type;
        $moduleObj = CmsModule::find($module_id);
        $moduleData = CmsModuleData::find($id);

        $rules = [
            'module_heading' => 'required',
        ];
        $messages = [
            'module_heading.required' => 'Heading is required',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect('adminmedia/module/' . $moduleObj->type . '/edit/' . $moduleData->id)->with('errors', $validator->errors());
        }

        $moduleData->heading = $request->module_heading;
        $page_slug = $request->module_slug;
        $slugs = $page_slug;
        $slugs = str_replace($moduleObj->type . '/', '', $slugs);
        $slugs = ((isset($moduleObj) && $moduleObj->type && $moduleObj->id != 1) ? $moduleObj->type . '/' : '') . $slugs;
        if (CmsModuleData::where('post_slug', $slugs)->where('id', '<>', $id)->exists()) {
            return response()->json(['error' => ['URL already assigned.']]);
        }
        $moduleData->post_slug = $slugs;
        $moduleData->content = myform_admin_cms_filter(adjustUrl($request->module_description));
        $moduleData->additional_field_1 = $request->additional_field_1;
        $moduleData->additional_field_2 = $request->additional_field_2;
        $moduleData->additional_field_3 = $request->additional_field_3;
        $moduleData->additional_field_4 = $request->additional_field_4;
        $moduleData->additional_field_5 = $request->additional_field_5;
        $moduleData->additional_field_6 = $request->additional_field_6;
        $moduleData->additional_field_7 = $request->additional_field_7;
        $moduleData->additional_field_8 = $request->additional_field_8;
        $moduleData->cat_id = $request->cat;
        $moduleData->is_pages = (strcmp($moduleObj->type, 'cms)') ? 1 : 0);
        $moduleData->show_follow = $request->show_follow;
        $moduleData->show_index = $request->show_index;
        $all_menus = '';
        $menu_types = $request->menu_type;
        if (isset($menu_types) && !empty($menu_types)) {
            foreach ($menu_types as $menu_type_id) {
                $all_menus .= $menu_type_id . ',';
            }
        }
        $all_menus = rtrim($all_menus, ',');
        $moduleData->menu_location = $all_menus;
        $moduleData->meta_title = $request->meta_title;
        $moduleData->meta_keywords = $request->meta_keywords;
        $moduleData->meta_description = $request->meta_description;
        $moduleData->canonical_url = $request->canonical_url;
        if (!empty($request->featured_img)) {
            $moduleData->featured_img = $request->featured_img;
        }
        $moduleData->featured_img_title = $request->featured_img_title;
        $moduleData->featured_img_alt = $request->featured_img_alt;
        $moduleData->save();
        /******************************* */
        /******************************* */
        $cmsModuleObj = CmsModule::find($moduleData->cms_module_id);
        $recordUpdateHistoryData = [
            'record_id' => $moduleData->id,
            'record_title' => $cmsModuleObj->title . ' - ' . $moduleData->heading,
            'record_link' => url('adminmedia/module/' . $cmsModuleObj->type . '/edit/' . $moduleData->id),
            'model_or_table' => 'CmsModuleData',
            'admin_id' => auth()->user()->id,
            'ip' => request()->ip(),
            'draft' => json_encode($moduleData->toArray()),
        ];
        recordUpdateHistory($recordUpdateHistoryData);
        /******************************* */
        /******************************* */
        $insert = $moduleData->id;
        $menu_types = $request->menu_type;
        $menus = Menu::where('menu_id', $insert)->get();
        if (isset($menu_types) && !empty($menu_types)) {
            foreach ($menus as $menu) {
                foreach ($menu_types as $menu_type_id) {
                    $exist = false;
                    if ($menu->menu_types == $menu_type_id) {
                        $exist = true;
                    }
                    if (!$exist) {
                        $menu->delete();
                    }
                }
            }
            foreach ($menu_types as $menu_type_id) {
                $exist = false;
                $menu = null;
                foreach ($menus as $menul) {
                    if ($menu_type_id == $menul->menu_types) {
                        $exist = true;
                        $menu = $menul;
                    }
                }
                if (!$exist) {
                    $menu = new Menu();
                    $max_orders = DB::table('menus')->max('menu_sort_order');
                    $max_order = $max_orders + 1;
                    $menu->menu_sort_order = $max_order;
                }
                $menu->menu_id = $insert;
                $menu->menu_label = $request->module_heading;
                $slugPrefix = strcmp($moduleObj->type, 'cms)') ? '' : '';
                $menu->menu_url = $slugPrefix . $slugs;
                $menu->menu_types = $menu_type_id;
                $menu->open_in_new_window = $request->open_in_new_window;
                $menu->show_no_follow = $request->show_no_follow;
                $menu->save();
            }
        } else {
            foreach ($menus as $menu) {
                $menu->delete();
            }
        }
        if (!empty($request->from_page_update)) {
            session(['message' => $moduleObj->term . ' updated successfully', 'type' => 'success',]);
            return redirect('adminmedia/module/' . $moduleObj->type . '/edit/' . $moduleData->id);
        } else {
            return response()->json(['success' => 'Added new records.' . $request->module_id]);
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
        $moduleData = CmsModuleData::find($id);
        $moduleObj = CmsModule::find($moduleData->cms_module_id);
        $moduleDataImages = ModuleDataImage::where('module_data_id', $id)->sorted()->get();
        foreach ($moduleDataImages as $image) {
            ImageUploader::deleteImage('module/' . $image->module_type, $image->image_name, true);
            $image->delete();
        }
        $moduleVideos = ModuleVideo::where('module_data_id', $id)->get();
        foreach ($moduleVideos as $videoObj) {
            ImageUploader::deleteFile('module/' . $moduleObj->type . '/videos/video/' . $videoObj->video_name);
            ImageUploader::deleteFile('module/' . $moduleObj->type . '/videos/thumb/' . $videoObj->video_thumb_img);
            $videoObj->delete();
        }
        ImageUploader::deleteImage('module/' . $moduleObj->type . '/' . $moduleData->featured_img, true);
        $moduleData->delete();
        Menu::where('menu_id', $id)->delete();
        session(['message' => $moduleObj->term . ' deleted successfully', 'type' => 'success',]);
        echo 'done';
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     */
    public function removeFeaturedImage(Request $request)
    {
        $id = $request->id;
        $data = CmsModuleData::find($id);
        if (!empty($data->featured_img) && file_exists(storage_uploads('module/' . $request->type . '/' . $data->featured_img))) {
            unlink(storage_uploads('module/' . $request->type . '/' . $data->featured_img));
        }
        $data->featured_img = '';
        $data->save();
        echo 'done';
    }
    public function ajax_crop_img(Request $request)
    {
        $module_id = $request->module_id;
        $module = CmsModule::find($module_id);
        $module_type = $module->type;
        $upload_dir = 'module/' . $module_type;
        $crop_x = (int)$request->crop_x;
        $crop_y = (int)$request->crop_y;
        $crop_height = (int)$request->crop_height;
        $crop_width = (int)$request->crop_width;
        $source_img = $request->source_image;
        ImageUploader::CropImageAndMakeThumb($upload_dir, $source_img, $crop_width, $crop_height, $crop_x, $crop_y);
        $data['cropped_image'] = $source_img;
        echo json_encode($data);
        exit;
    }
    public function showOrderPage($type)
    {
        $type = trim($type);
        if ($type != '') {
            $module = CmsModule::where('type', $type)->first();
            $moduleMembers = getModuleData($module->id);
            $title = FindInsettingArr('business_name') . ': ' . strtoupper($module->type) . ' Management';
            $msg = '';
            return view('back.module.order', compact('module', 'moduleMembers', 'title', 'msg'));
        }
        return redirect(back());
    }
    public function saveOrdering(Request $request)
    {
        $list_order = $request->list_order;
        $list = explode(',', $list_order);
        $i = 1;
        print_r($list);
        foreach ($list as $id) {
            $cmsModule = CmsModuleData::find($id);
            $cmsModule->item_order = $i;
            $cmsModule->save();
            ++$i;
            echo $i . ' ' . $id;
        }
    }
    public function add_single_module($type)
    {
        $type = trim($type);
        if ($type != '') {
            $module = CmsModule::where('type', $type)->first();
            if (!$module) {
                abort(404);
            }
        }
        $menu_types = MenuType::orderBy('id', 'ASC')->get();
        $title = FindInsettingArr('business_name') . ': ' . strtoupper($module->type) . ' Management';
        $msg = '';
        $allParentCategory = Category::orderBy('orderr', 'ASC')->get()->toArray();
        // >>>>>>>>>>>>>>>>> **Start** Media Section
        $albumsObj = $this->get_images();
        // FIles
        $filesObj = $this->filesObj();
        $filesExts = filesExtsAllowed();
        // <<<<<<<<<<<<<<<<< ***End*** Media Section
        // get template
        $templates = Template::all();
        $job_content = CmsModuleData::where('id', 226)->first();
        $moduleDataImages = ModuleDataImage::where('session_id', session()->getId())->sorted()->get();
        $moduleVideos = ModuleVideo::where('session_id', session()->getId())->get();
        return view('back.module.add_view', compact('module', 'menu_types', 'title', 'msg', 'allParentCategory', 'albumsObj', 'filesObj', 'filesExts', 'templates', 'job_content', 'moduleDataImages', 'moduleVideos'));
        // return view('back.module.add_edit_view', compact('module'));
    }
    public function filesObj()
    {
        $albumsObj = [];
        $folodersArr = [];
        $filesBasePath = filesBasePath();
        $folodersArr = array_filter(glob($filesBasePath . '*'), 'is_dir');
        $cnt = 0;
        // >>>>>>>>>>>>>>>>> **Start** Root Files
        $folderName = 'root';
        $filesArr = getFilesListInDir($filesBasePath, filesExtsAllowed());
        $albumsObj[] = [
            'album_id' => $cnt,
            'album_title' => $folderName,
            'album_path' => $filesBasePath,
            'album_img' => '',
            'all' => $filesArr,
        ];
        // <<<<<<<<<<<<<<<<< ***End*** Root Files
        foreach ($folodersArr as $key => $folder) {
            ++$cnt;
            $folderName = str_replace($filesBasePath, '', $folder);
            $currentFolderpath = $filesBasePath . $folderName . '/';
            $filesArr = getFilesListInDir($currentFolderpath, filesExtsAllowed());
            $albumsObj[] = [
                'album_id' => $cnt,
                'album_title' => $folderName,
                'album_path' => $currentFolderpath,
                'album_img' => '',
                'all' => $filesArr,
            ];
        }
        return $albumsObj;
    }
    public function get_images()
    {
        $albumsObj = [];
        $folodersArr = [];
        $mediaBasePath = mediaBasePath();
        $folodersArr = array_filter(glob($mediaBasePath . '*'), 'is_dir');
        $cnt = 0;
        // >>>>>>>>>>>>>>>>> **Start** Root Files
        $folderName = 'root';
        $filesArr = getImagesListInDir($mediaBasePath);
        $albumsObj[] = [
            'album_id' => $cnt,
            'album_title' => $folderName,
            'album_path' => $mediaBasePath,
            'album_img' => '',
            'all' => $filesArr,
        ];
        // <<<<<<<<<<<<<<<<< ***End*** Root Files
        foreach ($folodersArr as $key => $folder) {
            ++$cnt;
            $folderName = str_replace($mediaBasePath, '', $folder);
            $currentFolderpath = $mediaBasePath . $folderName . '/';
            $filesArr = getImagesListInDir($currentFolderpath);
            $albumsObj[] = [
                'album_id' => $cnt,
                'album_title' => $folderName,
                'album_path' => $currentFolderpath,
                'album_img' => '',
                'all' => $filesArr,
            ];
        }
        return $albumsObj;
    }
    public function edit_single_module($type, $id = 0)
    {
        $type = trim($type);
        if ($type != '') {
            $module = CmsModule::where('type', $type)->first();
            if (!$module) {
                abort(404);
            }
        }
        if ($id == 0) {
            abort(404);
        } else {
            $moduleData = CmsModuleData::where('id', $id)->first();
            if ($moduleData->post_slug && $type == 'cms') {
                $orig_module = CmsModule::where('type', $moduleData->post_slug)->first();
                if (isset($orig_module)) {
                    $module->show_page_slug_field = $orig_module->page_link;
                    $module->show_menu_field = $orig_module->page_menu_option;
                    $module->show_descp = $orig_module->page_content;
                    $module->show_feature_img_field = $orig_module->page_featured_img;
                    $module->show_follow = $orig_module->page_follow_index;
                    $module->show_index = $orig_module->page_follow_index;
                    $module->show_seo_field = $orig_module->page_seo_option;
                }
            }
        }
        $menu_types = MenuType::orderBy('id', 'ASC')->get();
        $menu = Menu::where('menu_id', $id)->get();
        $title = FindInsettingArr('business_name') . ': ' . strtoupper($module->type) . ' Management';
        $msg = '';
        $allParentCategory = Category::orderBy('orderr', 'ASC')->get()->toArray();
        // >>>>>>>>>>>>>>>>> **Start** Media Section
        $albumsObj = $this->get_images();
        // FIles
        $filesObj = $this->filesObj();
        $filesExts = filesExtsAllowed();
        $widget = DB::table('widgets')
            ->whereRaw("find_in_set('" . $id . "',pages_id)")
            ->get();
        $templates = Template::all();
        $moduleDataImages = ModuleDataImage::where('module_data_id', $id)->sorted()->get();
        $moduleVideos = ModuleVideo::where('module_data_id', $moduleData->id)->get();
        return view('back.module.edit_view', compact('module', 'moduleData', 'menu_types', 'title', 'msg', 'allParentCategory', 'menu', 'albumsObj', 'filesObj', 'filesExts', 'widget', 'templates', 'moduleDataImages', 'moduleVideos'));
    }
    public function createUniqueURL($slugs)
    {
        if (CmsModuleData::where('post_slug', $slugs)->exists()) {
            $slugs = $slugs . '-2';
            return $this->createUniqueURL($slugs);
        }
        return $slugs;
    }
    public function run_script()
    {
        $ID = 0;
        if (isset($_GET['url'])) {
            $url = trim($_GET['url']);
            $ID = DB::table('wp_postmeta')
                ->where('meta_key', 'custom_permalink')
                ->where('meta_value', $url)
                ->value('post_id');
        }
        $old_posts = DB::table('wp_posts')->where('id', $ID)->orderBy('id', 'ASC')->first();
        $old_postmeta = DB::table('wp_postmeta')->where('post_id', $ID)->get();
        $act_url = '';
        $act_url = DB::table('wp_postmeta')->where('meta_key', 'custom_permalink')->where('post_id', $ID)->value('meta_value');
        $meta_title = DB::table('wp_postmeta')->where('meta_key', '_yoast_wpmeta_title')->where('post_id', $ID)->value('meta_value');
        $meta_description = DB::table('wp_postmeta')->where('meta_key', '_yoast_wpseo_metadesc')->where('post_id', $ID)->value('meta_value');
        $meta_keywords = DB::table('wp_postmeta')->where('meta_key', '_yoast_wpseo_metakeywords')->where('post_id', $ID)->value('meta_value');
        if (DB::table('cms_module_datas')->where('post_slug', $act_url)->exists()) {
            cp('ERROR: EXISTS');
        }
        $arr = [];
        $arr['heading'] = $old_posts->post_title;
        // $arr['news_date_time']=$old_posts->news_date_time;
        $arr['sts'] = 1;
        $arr['dated'] = $old_posts->post_date;
        $arr['content'] = $old_posts->post_content;
        $arr['cms_module_id'] = (int) $_GET['mod_id'];
        if ($act_url != '') {
            $arr['post_slug'] = $act_url;
        } else {
            $arr['post_slug'] = $old_posts->post_name;
        }
        $arr['meta_title'] = $meta_title;
        $arr['meta_keywords'] = $meta_keywords;
        $arr['meta_description'] = $meta_description;
        $lastID = DB::table('cms_module_datas')->insertGetId($arr);
        // }
        return redirect()->back();
    }
    public function script_add_blog_posts()
    {
        $blogArr = DB::table('wp_posts')->where('post_type', 'post')->where('post_status', 'publish')
            ->get();
        foreach ($blogArr as $key => $value) {
            $ID = $value->id;
            $old_posts = DB::table('wp_posts')->where('id', $ID)->orderBy('id', 'ASC')->first();
            $old_postmeta = DB::table('wp_postmeta')->where('post_id', $ID)->get();
            $act_url = '';
            $act_url = DB::table('wp_postmeta')->where('meta_key', 'custom_permalink')->where('post_id', $ID)->value('meta_value');
            $meta_title = DB::table('wp_postmeta')->where('meta_key', '_yoast_wpmeta_title')->where('post_id', $ID)->value('meta_value');
            $meta_description = DB::table('wp_postmeta')->where('meta_key', '_yoast_wpseo_metadesc')->where('post_id', $ID)->value('meta_value');
            $meta_keywords = DB::table('wp_postmeta')->where('meta_key', '_yoast_wpseo_metakeywords')->where('post_id', $ID)->value('meta_value');
            $arr = [];
            $arr['title'] = $old_posts->post_title;
            // $arr['news_date_time']=$old_posts->news_date_time;
            $arr['sts'] = 1;
            $arr['dated'] = $old_posts->post_date;
            $arr['description'] = $old_posts->post_content;
            // $arr['cms_module_id']=(int)$_GET['mod_id'];
            if ($act_url != '') {
                $arr['post_slug'] = $act_url;
            } else {
                $arr['post_slug'] = $old_posts->post_name;
            }
            $arr['meta_title'] = $meta_title;
            $arr['meta_keywords'] = $meta_keywords;
            $arr['meta_description'] = $meta_description;
            $lastID = DB::table('blog_posts')->insertGetId($arr);
        }
    }
    public function prepareMenu($array)
    {
        $return = [];
        // 1
        krsort($array);
        foreach ($array as $k => &$item) {
            if (is_numeric($item['Parent'])) {
                $parent = $item['Parent'];
                if (empty($array[$parent]['Childs'])) {
                    $array[$parent]['Childs'] = [];
                }
                // 2
                array_unshift($array[$parent]['Childs'], $item);
                unset($array[$k]);
            }
        }
        // 3
        ksort($array);
        return $array;
    }
    public function buildMenu($array)
    {
        echo '<ul>';
        foreach ($array as $item) {
            echo '<li>';
            echo $item['Name'];
            if (!empty($item['Childs'])) {
                buildMenu($item['Childs']);
            }
            echo '</li>';
        }
        echo '</ul>';
    }
    public function commonContactSave(Request $request)
    {
        $data = CmsModuleData::where('id', $request->content_id)->first();
        $data->heading = $request->heading;
        $data->content = myform_admin_cms_filter(adjustUrl($request->editor3));
        $data->save();
        /******************************* */
        /******************************* */
        $cmsModuleObj = CmsModule::find($data->cms_module_id);
        $recordUpdateHistoryData = [
            'record_id' => $data->id,
            'record_title' => $cmsModuleObj->title . ' - ' . $data->heading,
            'record_link' => url('adminmedia/module/' . $cmsModuleObj->type . '/edit/' . $data->id),
            'model_or_table' => 'CmsModuleData',
            'admin_id' => auth()->user()->id,
            'ip' => request()->ip(),
            'draft' => json_encode($data->toArray()),
        ];
        recordUpdateHistory($recordUpdateHistoryData);
        /******************************* */
        /******************************* */
        return redirect('adminmedia/module/careers/add');
    }
    public function ajax_crop_module_data_img(Request $request)
    {
        $crop_x = (int) $request->crop_x;
        $crop_y = (int) $request->crop_y;
        $crop_height = (int) $request->crop_height;
        $crop_width = (int) $request->crop_width;
        $fileName = $request->source_image;
        $imageId = $request->image_id;
        $moduleDataImageObj = ModuleDataImage::find($imageId);
        $folder = 'module/' . $moduleDataImageObj->module_type;
        ImageUploader::CropImageAndMakeThumb($folder . '/', $fileName, $crop_width, $crop_height, $crop_x, $crop_y);
        $data['cropped_image'] = $fileName;
        echo json_encode($data);
        exit;
    }
    public function getModuleDataImageAltTitle(Request $request)
    {
        $imageObj = ModuleDataImage::find($request->image_id);
        return response([
            'image_alt' => $imageObj->image_alt,
            'image_title' => $imageObj->image_title,
        ]);
    }
    public function saveModuleDataImageAltTitle(Request $request)
    {
        $imageObj = ModuleDataImage::find($request->image_id);
        $imageObj->image_alt = $request->image_alt;
        $imageObj->image_title = $request->image_title;
        $imageObj->update();
        return response([
            'image_alt' => $imageObj->image_alt,
            'image_title' => $imageObj->image_title,
        ]);
    }
    public function saveModuleDataImagesMarkBeforeAfter(Request $request)
    {
        $image = ModuleDataImage::find($request->id);
        $folder = 'module/' . $image->module_type;
        ImageUploader::MarkImageBeforAfter($folder . '/', $image->image_name, true);
        $image->update([
            'isBeforeAfter' => 1,
        ]);
        return response([
            'status' => true,
            'message' => 'marked',
            'src' => asset_uploads($folder . '/thumb/', $image->image_name . '?' . time()),
        ]);
    }
    public function checkRoute(Request $request)
    {

        /********************** */
        $routeCollection = Route::getRoutes();
        /********************** */
        $id = (int)$request->id;
        $slug = $request->slug;
        $moduleType = $request->moduleType;
        $newModuleType = ($moduleType == 'cms') ? '' : $moduleType;
        $urlToCheck = url($newModuleType . '/' . $slug);
        $url = '';
        $urlToEdit = '';
        $urlIn = '';
        $status = true;
        /********************** */
        foreach ($routeCollection as $value) {
            $url = url($value->uri());
            if ($status && ($urlToCheck === $url)) {
                $status = false;
                $urlIn = 'Laravel Routes';
            }
        }
        /********************** */
        $slug = str_replace(url('/') . '/', '', $urlToCheck);
        $cmsModuleDataObj = CmsModuleData::where('post_slug', 'like', $slug)->first();
        if (null !== $cmsModuleDataObj && $cmsModuleDataObj->id != $id) {
            $urlToEdit = url('/adminmedia/module/' . $moduleType . '/edit/' . $cmsModuleDataObj->id);
            $status = false;
            $urlIn = 'CMS';
        } elseif (null !== $cmsModuleDataObj && $cmsModuleDataObj->id == $id) {
            $urlToEdit = '';
            $status = true;
            $urlIn = '';
        }
        /********************** */
        $slug = str_replace(url('/') . '/blog/', '', $urlToCheck);
        $blogPostObj = BlogPost::where('post_slug', 'like', $slug)->first();
        if (null !== $blogPostObj && $blogPostObj->id != $id) {
            $urlToEdit = url('/adminmedia/blog-post/' . $blogPostObj->id . '/edit');
            $status = false;
            $urlIn = 'Blog';
        } elseif (null !== $blogPostObj && $blogPostObj->id == $id) {
            $urlToEdit = '';
            $status = true;
            $urlIn = '';
        }
        /********************** */
        $slug = str_replace(url('/') . '/blog/category/', '', $urlToCheck);
        $blogCategoryObj = BlogCategory::where('cate_slug', 'like', $slug)->first();
        if (null !== $blogCategoryObj && $blogCategoryObj->id != $id) {
            $urlToEdit = url('/adminmedia/blog-category/' . $blogCategoryObj->id . '/edit');
            $status = false;
            $urlIn = 'BlogCategory';
        } elseif (null !== $blogCategoryObj && $blogCategoryObj->id == $id) {
            $urlToEdit = '';
            $status = true;
            $urlIn = '';
        }
        /********************** */
        $slug = str_replace(url('/') . '/product/', '', $urlToCheck);
        $productObj = Product::where('product_slug', 'like', $slug)->first();
        if (null !== $productObj && $productObj->id != $id) {
            $urlToEdit = url('/adminmedia/products/?id=' . $productObj->id);
            $status = false;
            $urlIn = 'Products';
        } elseif (null !== $productObj && $productObj->id == $id) {
            $urlToEdit = '';
            $status = true;
            $urlIn = '';
        }
        /********************** */
        return response([
            'status' => $status,
            'urlToCheck' => $urlToCheck,
            'urlToEdit' => $urlToEdit,
            'urlIn' => $urlIn
        ]);
    }
}

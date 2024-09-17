<?php

namespace App\Http\Controllers\Back;

use Illuminate\Http\Request;
use App\Helpers\ImageUploader;
// use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Models\Back\ModuleDataImage;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class ImageUploadController extends Controller
{
    public function store(Request $request)
    {
        $maxImageSize = getMaxUploadSize() * 1024;
        $validator = Validator::make($request->all(), [
            'module_img' => 'image|mimes:jpeg,png,jpg,gif,svg|max:' . $maxImageSize,
            'folder' => 'required'
        ]);
        if ($validator->passes()) {
            $folder = $request->folder;
            if ($image = $request->file('module_img')) {
                $name = ImageUploader::UploadImage($folder . '/', $image, '', 2500, 2500, true);
            }
            echo $name;
        } else {
            echo "error";
        }
    }

    public function uploadMoreImages(Request $request)
    {
        $maxImageSize = getMaxUploadSize() * 1024;
        $validator = Validator::make($request->all(), [
            'uploadFile.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:' . $maxImageSize,
            'module_type' => 'required',
            'module_id' => 'required',
            'module_data_id' => 'required',
            'folder' => 'required',
        ]);
        $html = '';
        if ($validator->passes()) {
            $folder = $request->folder;
            foreach ($request->file('uploadFile') as $key => $value) {
                $imageName = ImageUploader::UploadImage($folder . '/', $value, '', 2500, 2500, true);
                $image = new ModuleDataImage();
                $image->image_name = $imageName;
                $image->module_type = $request->input('module_type');
                $image->module_id = $request->input('module_id');
                $image->module_data_id = $request->input('module_data_id');
                $image->session_id = ($request->input('module_data_id', 0) == 0) ? $request->input('session_id') : NULL;
                $image->image_alt = $request->input('image_alt');
                $image->image_title = $request->input('image_title');
                $image->save();

                $html .= generateModuleDataImageHtml($folder, $image);
            }
        }
        $this->removeModuleDataUnusedImages();
        echo json_encode(['html' => $html]);
    }

    public function removeUploadedImage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file_name' => 'required',
            'folder' => 'required'
        ]);
        if ($validator->passes()) {
            $module_data_image_id = $request->input('module_data_image_id', 0);
            if ($module_data_image_id > 0) {
                ModuleDataImage::where('id', $module_data_image_id)->delete();
                ImageUploader::deleteImage($request->folder, $request->file_name, true);
            } else {
                ImageUploader::deleteImage($request->folder, $request->file_name);
            }
            echo "done";
        } else {
            echo "error";
        }
    }

    public function removeModuleDataUnusedImages()
    {
        $date = date_create(date('Y-m-d'));
        date_sub($date, date_interval_create_from_date_string("10 days"));
        $moduleDataImages = ModuleDataImage::whereNotNull('session_id')->where('module_data_id', 0)->whereDate('created_at', '<', $date)->get();

        foreach ($moduleDataImages as $image) {
            ImageUploader::deleteImage('module/' . $image->module_type, $image->image_name, true);
            $image->delete();
        }
    }

    public function uploadTinyMceImage(Request $request)
    {
        $maxImageSize = getMaxUploadSize() * 1024;
        $validator = Validator::make($request->all(), [
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:' . $maxImageSize
        ]);
        if ($validator->passes()) {
            $folder = 'editor/images';
            if ($image = $request->file('image')) {
                $name = ImageUploader::UploadImage($folder . '/', $image, '', 1500, 1500, false);
            }
            return response()->json([
                'location' => asset_uploads($folder . '/' . $name)
            ]);
        } else {
            return response()->json([
                'error' => ['message' => $validator->errors()->first()]
            ]);
        }
    }

    public function saveImagesSortOrder()
    {
        $list_order = request()->list_order;
        $list = explode(',', $list_order);
        $i = 1;
        foreach ($list as $id) {
            $id = str_replace('more_image_', '', $id);
            $image = ModuleDataImage::find($id);
            $image->sort_order = $i;
            $image->save();
            ++$i;
        }
    }
}

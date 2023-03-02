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
                $image->session_id = $request->input('session_id');
                $image->image_alt = $request->input('image_alt');
                $image->image_title = $request->input('image_title');
                $image->save();

                $html .= '<div class="col-md-4" id="' . $image->id . '">
                    <div class="mb-3">
                        <div class="imagebox">
                            <a href="javascript:void(0);" title="' . $image->image_title . '"
                                onclick="openGalleryImageZoomModal(\'' . base_url() . 'uploads/' . $folder . '/' . $image->image_name . '?' . time() . '\');">
                                <img id="image_' . $image->id . '"
                                    data-imgname="' . $image->image_name . '"
                                    src="' . base_url() . 'uploads/' . $folder . '/thumb/' . $image->image_name . '?' . time() . '"
                                    style="width:100%" alt="' . $image->image_alt . '"
                                    title="' . $image->image_title . '">
                            </a>
                        </div>
                        <div class="image_btn mt-2">
                            <a title="Delete Image"
                                onclick="deleteMoreImage(' . $image->id . ', this);"
                                class="mb-1 btn btn-danger" data-bs-toggle="tooltip"
                                data-placement="left" title="Delete this image"
                                href="javascript:;"> <i class="fa-solid fa-trash"></i></a>
                            <a title="Crop Image"
                                onClick="bind_cropper_preview_more_image(' . $image->id . ');"
                                href="javascript:void(0)" class="mb-1 btn btn-warning"><i
                                    class="fa-solid fa-crop" aria-hidden="true"></i></a>
                            <a title="Image Alt/Title"
                                onClick="openMoreImageAltTitleModal(' . $image->id . ');"
                                href="javascript:void(0)" class="mb-1 btn btn-success"><i
                                    class="fa-solid fa-bars" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>';
            }
        }
        echo json_encode(['html' => $html]);
    }

    public function removeUploadedImage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file_name' => 'required',
            'folder' => 'required'
        ]);
        if ($validator->passes()) {
            ImageUploader::deleteImage($request->folder, $request->file_name);
            echo "done";
        } else {
            echo "error";
        }
    }
}

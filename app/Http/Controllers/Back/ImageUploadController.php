<?php

namespace App\Http\Controllers\Back;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use App\Helpers\ImageUploader;

class ImageUploadController extends Controller
{
    public function store(Request $request)
    {
        $maxImageSize = session('max_image_size') * 1024;
        $validator = Validator::make($request->all(), [
            'module_img' => 'image|mimes:jpeg,png,jpg,gif,svg|max:'. $maxImageSize,
            'folder' => 'required'
        ]);
        if ($validator->passes()) {
            $folder = $request->folder;
            if ($image = $request->file('module_img')) {
                $name = ImageUploader::UploadImage($folder .'/', $image, '', 2500, 2500, true);
            }
            echo $name;
        } else {
            echo "error";
        }
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
        }else{
            echo "error";
        }
    }

    public function storebk(Request $request)
    {
        $maxImageSize = session('max_image_size') * 1024;
        $validator = Validator::make($request->all(), [
            'module_img' => 'image|mimes:jpeg,png,jpg,gif,svg|max:' . $maxImageSize,
            'folder' => 'required'
        ]);
        if ($validator->passes()) {
            $folder = $request->folder;
            if ($file = $request->file('module_img')) {
                $c_timestamp = time();
                $name = $c_timestamp . "_" . $file->getClientOriginalName();
                $file->move(public_path('/uploads/' . $folder . '/'), $name);
            }
            echo $name;
        } else {
            echo "error";
        }
    }
    public function removeUploadedImagebk(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file_name' => 'required',
            'folder' => 'required'
        ]);
        if ($validator->passes()) {
            unlink('uploads/' . $request->folder . '/' . $request->file_name);
            echo "done";
        } else
            echo "error";
    }
}

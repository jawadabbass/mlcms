<?php

namespace App\Http\Controllers\Back;

use Illuminate\Http\Request;
use App\Helpers\ImageUploader;
use App\Models\Back\CmsModule;
use App\Models\Back\ModuleVideo;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class VideoUploadController extends Controller
{
    function upload_video(Request $request)
    {
        $rules = [
            'video_link_embed_code' => 'required',
        ];
        if ($request->video_type == 'Upload') {
            $rules['video_link_embed_code'] = 'required|mimes:mp4';
            $rules['video_thumb_img'] = 'required|mimes:jpg,png,jpeg';
        }
        $messages = [
            'video_link_embed_code.required' => 'Video is required',
            'video_thumb_img.required' => 'Video Thumb is required',
            'video_thumb_img.mimes' => 'Video Thumb must be of jpg,png,jpeg',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['html' => '', 'error' => $validator->errors()->all()]);
            exit;
        }

        $moduleObj = CmsModule::find($request->moduleId);
        $moduleDataId = $request->moduleDataId;
        $post_slug = str_replace('/', '-', $request->post_slug);

        $html = '';
        if (!empty($request->video_link_embed_code)) {
            if (!file_exists(storage_uploads('module/' . $moduleObj->type . '/videos/video/'))) {
                mkdir(storage_uploads('module/' . $moduleObj->type . '/videos/video/'), 0755, true);
            }
            if (!file_exists(storage_uploads('module/' . $moduleObj->type . '/videos/thumb/'))) {
                mkdir(storage_uploads('module/' . $moduleObj->type . '/videos/thumb/'), 0755, true);
            }

            $moduleVideoObj = new ModuleVideo();
            $moduleVideoObj->module_id = $moduleObj->id;
            $moduleVideoObj->module_type = $moduleObj->type;

            if ($moduleDataId == 0) {
                $moduleVideoObj->session_id = $request->session_id;
            } else {
                $moduleVideoObj->module_data_id = $moduleDataId;
            }

            $moduleVideoObj->video_type = $request->video_type;

            if ($request->video_type == 'Upload') {
                $video_name = ImageUploader::UploadDoc('module/' . $moduleObj->type . '/videos/video/', $request->file('video_link_embed_code'), $post_slug);
                $localIframe = '<video width="100%" height="446" controls> <source src="' . asset_uploads('module/' . $moduleObj->type . '/videos/video/' . $video_name) . '" type="video/mp4"> <source src="movie.ogg" type="video/ogg"> Your browser does not support the video tag. </video>';
                /********************* */
                $img_name = ImageUploader::UploadDoc('module/' . $moduleObj->type . '/videos/thumb/', $request->file('video_thumb_img'), $post_slug);
                /********************* */
                $moduleVideoObj->video_link_embed_code = $localIframe;
                $moduleVideoObj->video_name = $video_name;
                $moduleVideoObj->video_thumb_img = $img_name;
            } elseif ($request->video_type == 'Youtube') {
                $youtubeID = youtubelink2id($request->video_link_embed_code);
                $image = @file_get_contents('https://img.youtube.com/vi/' . $youtubeID . '/0.jpg');
                $img_name = ImageUploader::getNewFileNameByName('module/' . $moduleObj->type . '/videos/thumb/', $post_slug, 'jpg');
                $image_source = storage_uploads('module/' . $moduleObj->type . '/videos/thumb/' . $img_name);
                file_put_contents($image_source, $image);
                $moduleVideoObj->video_link_embed_code = '<iframe width="100%" height="450" src="https://www.youtube.com/embed/' . $youtubeID . '" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>';
                $moduleVideoObj->video_thumb_img = $img_name;
            }
            $moduleVideoObj->save();
            $html .= view('back.module.module_videos.module_videos_html_sub', compact('moduleObj', 'moduleVideoObj'));
        }
        echo json_encode(['html' => $html]);
    }
    public function remove_video(Request $request)
    {
        $id = $request->id;
        $moduleVideoObj = ModuleVideo::find($id);
        ImageUploader::deleteFile('module/' . $moduleVideoObj->module_type . '/videos/video/', $moduleVideoObj->video_name);
        ImageUploader::deleteFile('module/' . $moduleVideoObj->module_type . '/videos/thumb/', $moduleVideoObj->video_thumb_img);
        $moduleVideoObj->delete();
        echo "done";
    }
}

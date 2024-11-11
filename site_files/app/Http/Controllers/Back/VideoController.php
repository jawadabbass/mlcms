<?php

namespace App\Http\Controllers\Back;

use App\Models\Back\Video;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = config('Constants.SITE_NAME') . ': Videos Management';
        $msg = '';
        $result = Video::orderBy('item_order', 'ASC')->paginate(100);
        $file_upload_max_size = $this->file_upload_max_size();
        return view('back.video.index', compact('title', 'msg', 'result', 'file_upload_max_size'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $video = Video::find($id);
        return json_encode($video);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        $new_status = 0;
        if ((int)$id > 0) {
            $video = Video::find($id);
            $status = (int)$video->sts;
            if ($status == 1) {
                $new_status = 0;
            } else {
                $new_status = 1;
            }
            $video->sts = $new_status;
            $video->save();
            /******************************* */
            /******************************* */
            $recordUpdateHistoryData = [
                'record_id' => $video->ID,
                'record_title' => $video->heading,
                'model_or_table' => 'Video',
                'admin_id' => auth()->user()->id,
                'ip' => request()->ip(),
                'draft' => json_encode($video->toArray()),
            ];
            recordUpdateHistory($recordUpdateHistoryData);
            /******************************* */
            /******************************* */
        }
        echo $new_status;
        return;
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Video::destroy($id);
        return json_encode(array("status" => true));
    }
    public function add_video()
    {
        $title = 'Add Video';
        $file_upload_max_size = $this->file_upload_max_size();
        return view('back.video.add_video', compact('title', 'file_upload_max_size'));
    }
    public function edit_video($id)
    {
        $title = 'Edit Video';
        $rec = Video::find($id);
        $file_upload_max_size = $this->file_upload_max_size();
        return view('back.video.edit_video', compact('title', 'file_upload_max_size', 'rec'));
    }
    public function post_add_video(Request $request)
    {
        $request->validate([
            'fimg' => 'mimes:jpg,png,jpeg'
        ]);
        $img_name = '';
        if (isset($_FILES['fimg']) && $_FILES['fimg']['tmp_name'] != '') {
            $file = $request->file('fimg');
            $fileExtension = $file->getClientOriginalExtension();
            $img_name = Str::slug($request->heading) . '.' . $fileExtension;
            $file->move(storage_public('/uploads/videos/thumb/'), $img_name);
        }
        $Video = new Video;
        if ($request->video_type == 'upload') {
            $request->validate([
                'linkk' => 'required|mimes:mp4'
            ]);
            $file = $request->file('linkk');
            $fileExtension = $file->getClientOriginalExtension();
            $video_name = Str::slug($request->heading) . '.' . $fileExtension;
            $file->move(storage_public('/uploads/videos/video/'), $video_name);

            $Video->content = $video_name;
        } else {
            $Video->content = $request->linkk;
            $time = time();
            $img_name = Str::slug($request->heading) . '-' . $time . ".jpg";
            if ($request->video_type == 'Youtube' || $request->video_type == 'Vimeo') {
                if ($request->video_type == 'Youtube') {
                    $youtubeID = youtubelink2id($request->linkk);
                    $image = @file_get_contents('https://img.youtube.com/vi/' . $youtubeID . '/0.jpg');
                }
                if ($request->video_type == 'Vimeo') {
                    $vimeoID = vimeolink2id($request->linkk);
                    $imgLink = vimeoid2img($vimeoID);
                    $image = @file_get_contents($imgLink);
                }
                $image_source = storage_public('/uploads/videos/thumb/' . $img_name);
                file_put_contents($image_source, $image);
            }
        }
        $Video->video_type = $request->video_type;
        $Video->short_detail = $request->descp;
        $Video->video_img = $img_name;
        $Video->heading = $request->heading;
        $Video->slug = Str::slug($request->heading);
        $Video->dated = date('Y-m-d H:i:s');
        $Video->save();
        /******************************* */
        /******************************* */
        $recordUpdateHistoryData = [
            'record_id' => $Video->ID,
            'record_title' => $Video->heading,
            'model_or_table' => 'Video',
            'admin_id' => auth()->user()->id,
            'ip' => request()->ip(),
            'draft' => json_encode($Video->toArray()),
        ];
        recordUpdateHistory($recordUpdateHistoryData);
        /******************************* */
        /******************************* */
        return redirect('adminmedia/videos')->with(['success' => 'Added new records.']);
    }
    public function post_edit_video(Request $request)
    {
        $idd = (int)$request->idd;
        if ($idd == 0) {
            abort(404);
        }
        $request->validate([
            'fimg' => 'mimes:jpg,png,jpeg'
        ]);

        $Video = Video::find($idd);
        $img_name = '';
        $file = $request->file('fimg');
        if (isset($_FILES['fimg']) && $_FILES['fimg']['tmp_name'] != '') {
            $fileExtension = $file->getClientOriginalExtension();
            $img_name = Str::slug($request->heading) . '.' . $fileExtension;
            @unlink(storage_public('/uploads/videos/thumb/' . $Video->video_img));
            $file->move(storage_public('/uploads/videos/thumb/'), $img_name);
        }
        if ($request->video_type == 'upload') {
            if (isset($_FILES['linkk']) && $_FILES['linkk']['tmp_name'] != '') {
                $request->validate([
                    'linkk' => 'required|mimes:mp4'
                ]);
                $file = $request->file('linkk');
                $fileExtension = $file->getClientOriginalExtension();
                $video_name = Str::slug($request->heading) . '.' . $fileExtension;
                @unlink(storage_public('/uploads/videos/video/' . $Video->content));
                $file->move(storage_public('/uploads/videos/video/'), $video_name);
                $Video->content = $video_name;
            }
        } else {
            if (!empty($request->linkk)) {
                $Video->content = $request->linkk;
                $time = time();
                $img_name = Str::slug($request->heading) . '-' . $time . ".jpg";
                if ($request->video_type == 'Youtube' || $request->video_type == 'Vimeo') {
                    if ($request->video_type == 'Youtube') {
                        $youtubeID = youtubelink2id($request->linkk);
                        $image = @file_get_contents('https://img.youtube.com/vi/' . $youtubeID . '/0.jpg');
                    }
                    if ($request->video_type == 'Vimeo') {
                        $vimeoID = vimeolink2id($request->linkk);
                        $imgLink = vimeoid2img($vimeoID);
                        $image = @file_get_contents($imgLink);
                    }
                    $image_source = storage_public('/uploads/videos/thumb/' . $img_name);
                    @unlink(storage_public('/uploads/videos/thumb/' . $Video->video_img));
                    file_put_contents($image_source, $image);
                }
            }
        }
        if (!empty($img_name)) {
            $Video->video_img = $img_name;
        }
        $Video->video_type = $request->video_type;
        $Video->dated = date('Y-m-d H:i:s');
        $Video->short_detail = $request->descp;
        $Video->heading = $request->heading;
        $Video->slug = Str::slug($request->heading);
        $Video->update();
        /******************************* */
        /******************************* */
        $recordUpdateHistoryData = [
            'record_id' => $Video->ID,
            'record_title' => $Video->heading,
            'model_or_table' => 'Video',
            'admin_id' => auth()->user()->id,
            'ip' => request()->ip(),
            'draft' => json_encode($Video->toArray()),
        ];
        recordUpdateHistory($recordUpdateHistoryData);
        /******************************* */
        /******************************* */
        return redirect('adminmedia/videos')->with(['success' => 'Updated records.']);
    }
    function file_upload_max_size()
    {
        static $max_size = -1;
        if ($max_size < 0) {
            // Start with post_max_size.
            $post_max_size = $this->parse_size(ini_get('post_max_size'));
            if ($post_max_size > 0) {
                $max_size = $post_max_size;
            }
            // If upload_max_size is less, then reduce. Except if upload_max_size is
            // zero, which indicates no limit.
            $upload_max = $this->parse_size(ini_get('upload_max_filesize'));
            if ($upload_max > 0 && $upload_max < $max_size) {
                $max_size = $upload_max;
            }
        }
        $max_size = $max_size / 1024;
        return $max_size / 1024;
    }
    function parse_size($size)
    {
        $unit = preg_replace('/[^bkmgtpezy]/i', '', $size); // Remove the non-unit characters from the size.
        $size = preg_replace('/[^0-9\.]/', '', $size); // Remove the non-numeric characters from the size.
        if ($unit) {
            // Find the position of the unit in the ordered string which is the power of magnitude to multiply a kilobyte by.
            return round($size * pow(1024, stripos('bkmgtpezy', $unit[0])));
        } else {
            return round($size);
        }
    }

    public function saveOrdering(Request $request)
    {
        $list_order = $request->list_order;
        $list = explode(',', $list_order);
        $i = 1;
        //print_r($list);
        foreach ($list as $id) {
            $videoObj = Video::find($id);
            $videoObj->item_order = $i;
            $videoObj->save();
            $i++;
            //echo $i . ' ' . $id;
        }
    }
}

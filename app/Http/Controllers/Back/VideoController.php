<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Back\Video;
use Illuminate\Http\Request;
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
        $title = FindInsettingArr('business_name') . ': Videos Management';
        $msg = '';
        $result = Video::orderBy('ID', 'DESC')->paginate(10);
        $file_upload_max_size = $this->file_upload_max_size();
        return view('back.video.index', compact('title', 'msg', 'result', 'file_upload_max_size'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'heading' => 'required',
        ]);
        if ($_POST['add_video_type'] == 'upload') {
            $request->validate([
                'add_uplad_video' => 'required|mimes:mp4'
            ]);
            $file = $request->file('add_uplad_video');
            $name = $file->getClientOriginalName();
            $fileExtension = $file->getClientOriginalExtension();
            $name = str_replace('.' . $fileExtension, '', $name) . '-' . time() . rand(1111, 4444) . '.' . $fileExtension;
            $video_name = strtolower(str_replace(' ', '-', $name));
            $file->move(public_path() . '/uploads/videos/video/', $video_name);
            $request->validate([
                'video_img' => 'required|mimes:jpg,png,jpeg'
            ]);
            $file = $request->file('video_img');
            $name = $file->getClientOriginalName();
            $fileExtension = $file->getClientOriginalExtension();
            $name = str_replace('.' . $fileExtension, '', $name) . '-' . time() . rand(1111, 4444) . '.' . $fileExtension;
            $img_name = strtolower(str_replace(' ', '-', $name));
            $file->move(public_path() . '/uploads/videos/thumb/', $img_name);



            $image = \Image::make(sprintf('uploads/videos/thumb/%s', $img_name))->resize(80, 60)->save();
            $localIframe = '<video width="100%" height="446" controls> <source src="' . base_url() . 'uploads/videos/video/' . $video_name . '" type="video/mp4"> <source src="movie.ogg" type="video/ogg"> Your browser does not support the video tag. </video>';
            $video = new Video;
            $video->heading    = $request->heading;
            $video->content = $localIframe;
            $video->short_detail = $request->short_detail;
            $video->video_type = 'file';
            $video->video_img = $img_name;
            $video->dated = date('Y-m-d H:i:s');
            $video->save();

            Session::flash('added_action', 'Created Successfully');
            return redirect(route('videos.index'));
        }
        if (!($this->check_iframe($request->contents))) {
            Session::flash('iframe_action', 'Error');
            return redirect(back());
        }
        $width = "100";
        $height = "200";
        $content = $request->contents;
        if (strpos($content, 'iframe') == false) {
            $content = $this->makeIframe($content);
        }
        $youtube = $this->resizeMarkup($content, array(
            'width' => $width,
            'height' => $height
        ));
        $thumbnail_url = get_video_thumbnail($content);
        $image = @file_get_contents($thumbnail_url);

        $video = new Video();
        $video->heading = $request->heading;
        $video->content = $content;
        $video->short_detail = $request->short_detail;
        $video->dated = date("Y-m-d H:i:s");
        $video->Save();

        $image_source = public_path() . '/uploads/videos/' . $video->ID . ".jpg";
        file_put_contents($image_source, $image);
        $output_file = public_path() . '/uploads/videos/thumb/' . $video->ID . ".jpg";
        copyImage1($image_source, 101, 60, $output_file);
        $video = Video::find($video->ID);
        $video->video_img = $video->ID . ".jpg";
        $video->Save();
        Session::flash('added_action', 'Created Successfully');
        return redirect(route('videos.index'));
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
        if ($id == '') {
            echo 'error';
            return;
        }
        $video = Video::find($id);
        $status = $video->sts;
        if ($status == '') {
            echo 'invalid current status provided.';
            return;
        }
        if ($status == 'active')
            $new_status = 'blocked';
        else
            $new_status = 'active';
        
        $video->sts = $new_status;
        $video->update();
        echo $new_status;
        return;
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'edit_heading' => 'required',
            'edit_content' => 'required',
            'video_id' => 'required'
        ]);
        if (!($this->check_iframe($request->edit_content))) {
            Session::flash('iframe_action', 'Error');
            echo "Error";
            return redirect()->back();
        }
        $width = "100";
        $height = "200";
        $content = $request->edit_content;
        if (strpos($content, 'iframe') == false) {
            $content = $this->makeIframe($content);
        }
        $youtube = $this->resizeMarkup($content, array(
            'width' => $width,
            'height' => $height
        ));

        $thumbnail_url = get_video_thumbnail($content);
        $image = @file_get_contents($thumbnail_url);
        $image_source = public_path() . '/uploads/videos/' . $request->video_id . ".jpg";
        file_put_contents($image_source, $image);
        $output_file = public_path() . '/uploads/videos/thumb/' . $request->video_id . ".jpg";
        copyImage1($image_source, 101, 60, $output_file);
        $video = Video::find($request->video_id);
        $video->video_img = $request->video_id . ".jpg";
        $video->heading = $request->edit_heading;
        $video->content = $content;
        $video->short_detail = $request->short_detail;
        $video->dated = date("Y-m-d H:i:s");
        $video->Save();
        Session::flash('update_action', 'Created Successfully');
        return redirect(route('videos.index'));
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
    /**
     * Custom Function inside Controller for Ifram Validation
     * and Creation for youtube and
     *
     */
    public function makeIframe($content)
    {
        $url = $content;
        if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
            $url = "http://" . $url;
        }
        if (stristr($url, 'youtube.com') == true) {
            $tmpArr = explode('watch?v=', $url);
            $id = '';
            if (isset($tmpArr[1])) {
                $id = $tmpArr[1];
                $width = '640';
                $height = '360'; //echo the embed code. You can even wrap it in a class
                $iframe_embed = '<iframe  width="' . $width . '" height="' . $height . '" src="https://www.youtube.com/embed/' . $id . '" frameborder="0" allowfullscreen></iframe>';
                return $iframe_embed;
            }
        }
        if (stristr($url, 'vimeo.com') == true) {
            $tmpArr = explode('/', $url);
            if (isset($tmpArr[sizeof($tmpArr) - 1])) {
                $id = (int)$tmpArr[sizeof($tmpArr) - 1];
                $width = '640';
                $height = '360';
                $iframe_embed = '<iframe src="https://player.vimeo.com/video/' . $id . '?title=0&amp;byline=0&amp;portrait=0&amp;badge=0&amp;color=ffffff" width="' . $width . '" height="' . $height . '" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
                return $iframe_embed;
            }
        }
        return "";
    }
    public function resizeMarkup($markup, $dimensions)
    {
        $w = $dimensions['width'];
        $h = $dimensions['height'];
        $patterns = array();
        $replacements = array();
        if (!empty($w)) {
            $patterns[] = '/width="([0-9]+)"/';
            $patterns[] = '/width:([0-9]+)/';
            $replacements[] = 'width="' . $w . '%"';
            $replacements[] = 'width:' . $w . '%';
        }
        if (!empty($h)) {
            $patterns[] = '/height="([0-9]+)"/';
            $patterns[] = '/height:([0-9]+)/';
            $replacements[] = 'height="' . $h . '"';
            $replacements[] = 'height:' . $h;
        }
        return preg_replace($patterns, $replacements, $markup);
    }
    public function check_iframe($str)
    {
        if (strpos($str, 'iframe') == false) {
            echo "if";
            $url = $str;
            if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
                $url = "http://" . $url;
            }
            if (stristr($url, 'youtube.com') == true) {
                $tmpArr = explode('watch?v=', $url);
                $id = '';
                if (isset($tmpArr[1]) && (!empty($tmpArr[1]))) {
                    return TRUE;
                } else {
                    return FALSE;
                }
            } else if (stristr($url, 'vimeo.com') == true) {
                $tmpArr = explode('/', $url);
                if (isset($tmpArr[sizeof($tmpArr) - 1])) {
                    $id = (int)$tmpArr[sizeof($tmpArr) - 1];
                    if ($id == 0) {
                        return FALSE;
                    } else {
                        return TRUE;
                    }
                } else {
                    return FALSE;
                }
            } else {
                return FALSE;
            }
        } else {
            echo "else";
            $videoEmbed = $str;
            $doc = new \DOMDocument();
            $doc->loadHTML($videoEmbed);
            $src = $doc->getElementsByTagName('iframe')->item(0)->getAttribute('src');
            $parse = parse_url($src);
            if ((stristr($src, 'youtube.com') == true || stristr($src, 'vimeo.com') == true)) {
                return TRUE;
            } else {
                return FALSE;
            }
        }
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
        $file = $request->file('fimg');
        $file2 = $request->file('fimg');
        if (isset($_FILES['fimg']) && $_FILES['fimg']['tmp_name'] != '') {
            $name = $file->getClientOriginalName();
            $fileExtension = $file->getClientOriginalExtension();
            $name = str_replace('.' . $fileExtension, '', $name) . '-' . time() . rand(1111, 4444) . '.' . $fileExtension;
            $img_name = strtolower(str_replace(' ', '-', $name));

            //$file2->move(public_path() . '/uploads/module/Videos/', $img_name);
            $file->move(public_path() . '/uploads/videos/thumb/', $img_name);

            $image = \Image::make(sprintf('uploads/videos/thumb/%s', $img_name))->resize(80, 60)->save();
        }
        if ($request->testimonial_type == 'upload') {
            $request->validate([
                'linkk' => 'required|mimes:mp4'
            ]);
            $file = $request->file('linkk');
            $name = $file->getClientOriginalName();
            $fileExtension = $file->getClientOriginalExtension();
            $name = str_replace('.' . $fileExtension, '', $name) . '-' . time() . rand(1111, 4444) . '.' . $fileExtension;
            $video_name = strtolower(str_replace(' ', '-', $name));
            $file->move(public_path() . '/uploads/videos/video/', $video_name);
            $Video = new Video;
            $Video->video_type = $request->testimonial_type;
            $Video->short_detail = $request->descp;
            $Video->content = $video_name;
            $Video->video_img = $img_name;
            $Video->heading = $request->heading;
            $Video->dated = date('Y-m-d H:i:s');
            $Video->save();
        } else {
            $Video = new Video;
            $Video->video_type = $request->testimonial_type;
            $Video->short_detail = $request->descp;
            $Video->content = $request->linkk;
            $Video->video_img = $img_name;
            $Video->dated = date('Y-m-d H:i:s');
            $Video->heading = $request->heading;
            $Video->save();
            if ($request->testimonial_type == 'Youtube' || $request->testimonial_type == 'Vimeo') {
                if ($request->testimonial_type == 'Youtube') {
                    $youtubeID = youtubelink2id($request->linkk);
                    $image = @file_get_contents('https://img.youtube.com/vi/' . $youtubeID . '/0.jpg');
                }
                if ($request->testimonial_type == 'Vimeo') {
                    $vimeoID = vimeolink2id($request->linkk);
                    $imgLink = vimeoid2img($vimeoID);
                    $image = @file_get_contents($imgLink);
                }
                $image_source = public_path() . '/uploads/videos/' . $Video->ID . ".jpg";
                file_put_contents($image_source, $image);
                $output_file = public_path() . '/uploads/videos/thumb/' . $Video->ID . ".jpg";
                copyImage1($image_source, 101, 60, $output_file);
                $video = Video::find($Video->ID);
                $video->video_img = $video->ID . ".jpg";
                $Video->heading = $request->heading;
                $video->save();
            }
        }
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
        $img_name = '';
        $file = $request->file('fimg');
        $file2 = $request->file('fimg');
        if (isset($_FILES['fimg']) && $_FILES['fimg']['tmp_name'] != '') {
            $name = $file->getClientOriginalName();
            $fileExtension = $file->getClientOriginalExtension();
            $name = str_replace('.' . $fileExtension, '', $name) . '-' . time() . rand(1111, 4444) . '.' . $fileExtension;
            $img_name = strtolower(str_replace(' ', '-', $name));

            //$file2->move(public_path() . '/uploads/module/Videos/', $img_name);
            $file->move(public_path() . '/uploads/videos/thumb/', $img_name);

            $image = \Image::make(sprintf('uploads/videos/thumb/%s', $img_name))->resize(80, 60)->save();
        }
        if ($request->testimonial_type == 'upload') {
            $request->validate([
                'linkk' => 'required|mimes:mp4'
            ]);
            $file = $request->file('linkk');
            $name = $file->getClientOriginalName();
            $fileExtension = $file->getClientOriginalExtension();
            $name = str_replace('.' . $fileExtension, '', $name) . '-' . time() . rand(1111, 4444) . '.' . $fileExtension;
            $video_name = strtolower(str_replace(' ', '-', $name));
            $file->move(public_path() . '/uploads/videos/video/', $video_name);
            $Video = Video::find($idd);
            $Video->video_type = $request->testimonial_type;
            if ($video_name != '') {
                $Video->content = $video_name;
            }

            if ($img_name != '') {
                $Video->featured_img = $img_name;
            }
            $Video->dated = date('Y-m-d H:i:s');
            $Video->short_detail = $request->descp;
            $Video->heading = $request->heading;
            $Video->save();
        } else {
            $Video = Video::find($idd);
            $Video->video_type = $request->testimonial_type;
            $Video->content = $request->linkk;
            $Video->short_detail = $request->descp;
            $Video->heading = $request->heading;
            if ($img_name != '') {
                $Video->video_img = $img_name;
            }
            $Video->dated = date('Y-m-d H:i:s');
            $Video->save();
        }
        return redirect('adminmedia/videos')->with(['success' => 'Added new records.']);
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
}

<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ThemeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = FindInsettingArr('business_name') . ': Theme Management';
        return view('back.manage_theme.index', compact('title'));
    }
    public function save(Request $request)
    {
        $title = FindInsettingArr('business_name') . ': Theme Management';
        if (isset($_POST['beforeHeadClose']) && trim($_POST['beforeHeadClose']) != "") {
            $_POST['beforeHeadClose'];
            $content = $this->replace_public_urls(htmlentities($_POST['beforeHeadClose']));

            $fp = base_path('resources\views\front\common_views\before_head_close.blade.php');
            $file = fopen($fp, 'w');
            fwrite($file, html_entity_decode($content));
            fclose($file);
        }
        if (isset($_POST['headerSection']) && trim($_POST['headerSection']) != "") {
            $content = $this->replace_public_urls(htmlentities($_POST['headerSection']));
            $fp = base_path('resources\views\front\common_views\header.blade.php');
            $file = fopen($fp, 'w');
            fwrite($file, html_entity_decode($content));
            fclose($file);
        }
        if (isset($_POST['mainContentSection']) && trim($_POST['mainContentSection']) != "") {
            $content = "@extends('front.layout.app')
                        @section('content')";
            $ncontent = $this->replace_public_urls(htmlentities($_POST['mainContentSection']));
            $ncontent = html_entity_decode($ncontent);
            $content .= $ncontent;
            $content .= "@endsection";
            $fp = base_path('resources\views\front\home\index.blade.php');
            $file = fopen($fp, 'w');
            fwrite($file, $content);
            fclose($file);
        }

        if (isset($_POST['footerSection']) && trim($_POST['footerSection']) != "") {
            $content = $this->replace_public_urls(htmlentities($_POST['footerSection']));
            $fp = base_path('resources\views\front\common_views\footer.blade.php');
            $file = fopen($fp, 'w');
            fwrite($file, html_entity_decode($content));
            fclose($file);
        }
        if (isset($_POST['beforeBodyClose']) && trim($_POST['beforeBodyClose']) != "") {
            $content = $this->replace_public_urls(htmlentities($_POST['beforeBodyClose']));
            $fp = base_path('resources\views\front\common_views\before_body_close.blade.php');
            $file = fopen($fp, 'w');
            fwrite($file, html_entity_decode($content));
            fclose($file);
        }
        Session::flash('update_action', 'Created Successfully');
        return redirect('adminmedia/manage-theme')->with(['success' => 'Updated records.']);
    }
    public function replace_public_urls($content)
    {
        $content = str_replace("href=&quot;", "href=&quot;{{asset('front/", $content);
        $content = str_replace("src=&quot;", "src=&quot;{{asset('front/", $content);
        $rep_from = [".css", ".ico", ".jpg", ".png", ".jpeg", ".js"];
        $rep_with = [".css')}}", ".ico')}}", ".jpg')}}", ".png')}}", ".jpeg')}}", ".js')}}"];
        //$rep_with=[".css')}}",".ico')}}",".jpg')}}",".png')}}",".jpeg')}}",".js')}}"];
        $content = str_replace($rep_from, $rep_with, $content);
        //After effecetd URLs  <a href="<?php echo e(asset('front/mailto
        $content = str_replace("a href=&quot;{{asset('front/", "a href=&quot;", $content);
        $content = str_replace("href=&quot;{{asset('front/#", "href=&quot;#", $content);
        $content = str_replace("href=&quot;{{asset('front/mailto", "href=&quot;mailto", $content);
        $content = str_replace("href=&quot;{{asset('front/tel", "href=&quot;tel", $content);

        return $content;
    }
}

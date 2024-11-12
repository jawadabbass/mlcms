<?php

use App\Models\Back\RecordUpdateHistory;

function cacheTime()
{
    return 60 * 60;
}
function exeTime()
{
    return microtime(true) - LARAVEL_START;
}
if (!function_exists('get_widgets')) {
    function get_widgets($widget = '62')
    {
        $widgetData = \App\Models\Back\Widget::find($widget);
        return $widgetData;
    }
}
if (!function_exists('get_widget')) {
    function get_widget($widget = '62')
    {
        $widgetData = \App\Models\Back\Widget::find($widget);
        return adjustUrl($widgetData->content);
    }
}
function cms_edit_page($type = "cms", $id = 0)
{
    if (is_admin()) {
        switch ($type) {
            case 'cms':
                $editUrl = admin_url() . 'module/cms/edit/' . $id;
                break;
            default:
                if ($id == 0) {
                    $editUrl = admin_url() . $type;
                } else {
                    $type = str_replace('module/', '', $type);
                    $editUrl = admin_url() . 'module/' . $type . '/edit/' . $id;
                }
                break;
        }
        return '';
        // return '<div class="editCont"><a data-bs-toggle="tooltip" data-placement="right" title="Edit" href="'.$editUrl.'" id="editBlog" target="_blank"><i class="fas fa-edit"></i></a></div>';
    }
}
function front_dashboard_links()
{
    if (is_admin()) {
        return '<div class="homePg editCont">
            <ul>
                <li><a data-bs-toggle="tooltip" data-placement="right" title="Dashboard" href="' . admin_url() . '" id="" target="_blank"><i class="fas fa-tachometer-alt"></i></a></li>
                <li> <a data-bs-toggle="tooltip" data-placement="right" title="Menus" href="' . admin_url() . 'menus" id="" target="_blank"><i class="fas fa-tasks"></i></a></li>
                <li><a data-bs-toggle="tooltip" data-placement="right" title="Widgets" href="' . admin_url() . 'widgets" id="" target="_blank"><i class="fas fa-puzzle-piece"></i></a></li>
            </ul>          
        </div>';
    }
}
function is_login()
{
    if (\Auth::check()) {
        return true;
    }
    return false;
}
function is_admin()
{
    if (\Auth::check()) {
        $type = \Auth::user()->type;
        if ($type == 'super-admin' || $type == 'normal-admin') {
            return true;
        }
    }
    return false;
}
function showUploadedVideo($link, $type, $w = '100%', $h = '400', $class = 'd-block', $videoURL = 'uploads/videos/video/')
{
    if ($type == 'upload') {
        return '
        <video width="' . $w . '" height="' . $h . '" class="' . $class . '" autoplay playsinline controls>
            <source src="' . asset_storage($videoURL . $link) . '" type="video/mp4">
        </video> ';
    } else {
        return $link;
    }
}
function youtubelink2id($link)
{
    preg_match('/embed\/([\w+\-+]+)[\"\?]/', $link, $match);
    if (isset($match[1])) {
        $youtube_id = $match[1];
        return $youtube_id;
    }
    return '';
}
function vimeolink2id($link)
{
    preg_match('/video\/([\w+\-+]+)[\"\?]/', $link, $match);
    if (isset($match[1])) {
        $vimeo_id = $match[1];
        return $vimeo_id;
    }
    return '';
}
function vimeoid2img($link)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'http://vimeo.com/api/v2/video/' . $link . '.php');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $hash = curl_exec($ch);
    curl_close($ch);
    ///$hash=file_get_contents('http://vimeo.com/api/v2/video/'.$link.'.php');
    $hash = unserialize($hash);
    if (isset($hash[0]['thumbnail_large'])) {
        return $hash[0]['thumbnail_large'];
    }
    return '';
}
// ************************************************** //
function settingArr()
{
    $settingsArr = \App\Models\Back\Setting::find(1);
    if ($settingsArr->web_down_status == 1) {
        echo $settingsArr->web_down_msg;
        exit;
    }
    return $settingsArr;
}
function FindInsettingArr($key)
{
    $settingsArr = \App\Models\Back\Setting::find(1);
    if ($settingsArr->web_down_status == 1) {
        echo $settingsArr->web_down_msg;
        exit;
    }
    if ($settingsArr->$key) {
        return $settingsArr->$key;
    } else {
        return false;
    }
}
function date_valid($date)
{
    $parts = explode("-", $date);
    if (count($parts) == 3) {
        $dd = (int)$parts[1];
        $mm = (int)$parts[0];
        $yyyy = (int)$parts[2];
        if (checkdate($mm, $dd, $yyyy)) {
            return true;
        }
    }
    $this->form_validation->set_message('date_valid', 'The {field} must be in form mm-dd-yyyy');
    return false;
}
function name_valid($str)
{
    $retr = (bool)preg_match('/^[a-z\']+$/i', $str);
    if ($retr == false) {
        $this->form_validation->set_message('name_valid', 'The {field} must contain only letters');
        return false;
    }
    return true;
}
function ssn_valid($str)
{
    $retr = true;
    if (strlen($str) != 11) {
        $this->form_validation->set_message('ssn_valid', 'Please enter valid {field}');
        return false;
    }
    $retr = (bool)preg_match('/^[0-9-]+$/i', $str);
    if ($retr == false) {
        $this->form_validation->set_message('ssn_valid', 'Please enter valid {field}');
        return false;
    }
    return true;
}
// Get Latest Blog Content
if (!function_exists('get_latest_blog')) {
    function get_latest_blog($limit = 2)
    {
        $blogData = \App\Models\Back\BlogPost::with('author', 'comments')->paginate($limit);
        return $blogData;
    }
}
// Get Services
if (!function_exists('get_services')) {
    function get_services($limit = 8)
    {
        $services = getModuleData(45);
        return $services;
    }
}
if (!function_exists('get_excerpt')) {
    function get_excerpt($text, $limit = 200, $readMore = '')
    {
        $text = strip_tags($text);
        $text = wordwrap($text, $limit, "....", FALSE);
        $text_arr = explode("....", $text);
        $excerpt = '';
        if (isset($text_arr[1])) {
            $excerpt = $text_arr[0] . "....";
            if (!empty($readMore)) {
                $excerpt = $excerpt . $readMore;
            }
        } else {
            $excerpt = $text_arr[0];
        }
        return $excerpt;
    }
}
function get_module_by_order($module_id, $limit)
{
    $data = getModuleData($module_id, $limit, 0);
    return $data;
}
function addHttpLink($url, $scheme = 'http://')
{
    return parse_url($url, PHP_URL_SCHEME) === null ?
        $scheme . $url : $url;
}
function getFilesListInDir($mediaBasePath, $extArr)
{
    $filesArr = array();
    $dirArr = glob($mediaBasePath . '*');
    foreach ($dirArr as $key => $value) {
        $path_info = pathinfo($value);
        if (isset($path_info['extension'])) {
            foreach ($extArr as $ek => $ev) {
                if (strtolower($ek) == strtolower($path_info['extension'])) {
                    $url = str_replace(storage_uploads(''), '', $value);
                    $fileName = str_replace($mediaBasePath, '', $value);
                    $filesArr[] = array('url' => $url, 'name' => $fileName);
                }
            }
        }
    }
    return $filesArr;
}
function getImagesListInDir($mediaBasePath)
{
    $filesArr = array();
    $dirArr = glob($mediaBasePath . '*');
    foreach ($dirArr as $key => $value) {
        $path_info = pathinfo($value);
        //cp($path_info['extension'], 'yes');
        if (isset($path_info['extension']) && ($path_info['extension'] == 'jpg' ||
            $path_info['extension'] == 'jpeg' ||
            $path_info['extension'] == 'png' ||
            $path_info['extension'] == 'gif' ||
            $path_info['extension'] == 'JPG' ||
            $path_info['extension'] == 'JPEG' ||
            $path_info['extension'] == 'PNG' ||
            $path_info['extension'] == 'GIF'
        )) {
            $url = str_replace(storage_uploads(''), '', $value);
            $fileName = str_replace($mediaBasePath, '', $value);
            $filesArr[] = array('url' => $url, 'name' => $fileName);
        }
    }
    return $filesArr;
}
function keyArray($arr)
{
    $tmpArr = array();
    foreach ($arr as $key => $value) {
        $tmpArr[] = $key;
    }
    return $tmpArr;
}
function human_filesize($bytes, $decimals = 2)
{
    $factor = floor((strlen($bytes) - 1) / 3);
    if ($factor > 0) $sz = 'KMGT';
    return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor - 1] . 'B';
}
function readMoreText($text, $limit = 10, $removeTags = true)
{
    if ($removeTags) {
        $text = strip_tags($text);
    }
    if (strlen($text) < $limit) {
        return $text;
    } else {
        $arr = explode(' ', substr($text, 0, $limit));
        unset($arr[sizeof($arr) - 1]);
        return implode(' ', $arr);
    }
}
function the_date($date, $dateF = 'd M Y')
{
    return date($dateF, strtotime($date));
}
function __shortcode($content)
{
    $content = str_replace('{{add_icon}}', '<i class="fas fa-plus" aria-hidden="true"></i>', $content);
    return $content;
}
function deleteExtraRecordUpdateHistory($data)
{
    $allHistory = RecordUpdateHistory::where('record_id', $data['record_id'])
        ->where('record_title', 'like', $data['record_title'])
        ->where('model_or_table', 'like', $data['model_or_table'])
        ->orderBy('created_at', 'asc')
        ->get();

    $totalHistoryRecordsToMaintain = 10;
    if ($allHistory->count() > $totalHistoryRecordsToMaintain) {
        $counter = $allHistory->count();
        foreach ($allHistory as $historyObj) {
            if ($counter > $totalHistoryRecordsToMaintain) {
                $historyObj->delete();
                $counter--;
            }
        }
    }
}
function recordUpdateHistory($data)
{
    deleteExtraRecordUpdateHistory($data);
    $history = new RecordUpdateHistory();
    foreach($data as $key=>$value){
        $history->{$key} = $value;
    }
    $history->save();
}

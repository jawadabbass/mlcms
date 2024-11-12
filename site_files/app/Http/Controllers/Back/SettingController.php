<?php

namespace App\Http\Controllers\Back;

use App\Helpers\ImageUploader;
use App\Http\Controllers\Controller;
use App\Models\Back\Country;
use App\Models\Back\Metadata;
use App\Models\Back\Setting;
use App\Rules\CheckIfFavicon;
use App\Rules\CheckIfJson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = FindInsettingArr('business_name') . ': Settings';
        $msg = '';
        $setting_result = Setting::first();
        $metaDatas = Metadata::all();
        $metaArray = [];
        foreach ($metaDatas as $metaData) {
            $metaArray[$metaData->data_key] = $metaData->val1;
        }
        $countries = Country::all();
        $maxSizeAllowed = $this->file_upload_max_size();
        return view('back.setting.index', compact('title', 'msg', 'setting_result', 'metaArray', 'countries', 'maxSizeAllowed'));
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
        $setting = Setting::first();
        $setting->google_analytics = $request->google_analytics;
        $setting->google_analytics = $request->google_analytics;
        $setting->save();
        /******************************* */
        /******************************* */
        $recordUpdateHistoryData = [
            'record_id' => $setting->ID,
            'record_title' => 'google_analytics',
            'record_link' => url('adminmedia/settings/'.$setting->ID.'/edit'),
            'model_or_table' => 'Setting',
            'admin_id' => auth()->user()->id,
            'ip' => request()->ip(),
            'draft' => json_encode($setting->toArray()),
        ];
        recordUpdateHistory($recordUpdateHistoryData);
        /******************************* */
        /******************************* */
        session(['message' => 'Updated Successfully', 'type' => 'success']);
        return redirect()->back();
    }
    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $title = FindInsettingArr('business_name') . ': Settings';
        $msg = '';
        $setting_result = Setting::first();
        $metaDatas = Metadata::all();
        $metaArray = [];
        foreach ($metaDatas as $metaData) {
            $metaArray[$metaData->data_key] = $metaData->val1;
        }
        $countries = Country::all();
        $maxSizeAllowed = $this->file_upload_max_size();
        if ($id == 'admin_logo_favicon') {
            return view('back.setting.admin_logo_favicon', compact('title', 'msg', 'setting_result', 'metaArray', 'countries', 'maxSizeAllowed'));
        } elseif ($id == 'basic') {
            return view('back.setting.basic', compact('title', 'msg', 'setting_result', 'metaArray', 'countries', 'maxSizeAllowed'));
        } elseif ($id == 'adsense') {
            return view('back.setting.adsense', compact('title', 'msg', 'setting_result', 'metaArray', 'countries', 'maxSizeAllowed'));
        } elseif ($id == 'analytics') {
            return view('back.setting.analytics', compact('title', 'msg', 'setting_result', 'metaArray', 'countries', 'maxSizeAllowed'));
        } elseif ($id == 'captcha') {
            return view('back.setting.captcha', compact('title', 'msg', 'setting_result', 'metaArray', 'countries', 'maxSizeAllowed'));
        } elseif ($id == 'disable-website') {
            return view('back.setting.disable-website', compact('title', 'msg', 'setting_result', 'metaArray', 'countries', 'maxSizeAllowed'));
        } elseif ($id == 'restriction') {
            return view('back.setting.restriction', compact('title', 'msg', 'setting_result', 'metaArray', 'countries', 'maxSizeAllowed'));
        } elseif ($id == 'js') {
            return view('back.setting.js', compact('title', 'msg', 'setting_result', 'metaArray', 'countries', 'maxSizeAllowed'));
        } elseif ($id == 'paypal') {
            return view('back.setting.paypal', compact('title', 'msg', 'setting_result', 'metaArray', 'countries', 'maxSizeAllowed'));
        } elseif ($id == 'analytics_property_id_and_json_file') {
            return view('back.setting.analytics_property_id_and_json_file', compact('title', 'msg', 'setting_result', 'metaArray', 'countries', 'maxSizeAllowed'));
        } elseif ($id == 'banner_popup') {
            return view('back.setting.banner_popup', compact('title', 'msg', 'setting_result', 'metaArray', 'countries', 'maxSizeAllowed'));
        } else {
            return view('back.setting.index', compact('title', 'msg', 'setting_result', 'metaArray', 'countries', 'maxSizeAllowed'));
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        $setting = Setting::first();
        if (isset($request->web_down_status)) {
            $setting->web_down_status = '1';
        } else {
            $setting->web_down_status = '0';
        }
        $setting->web_down_msg = $request->web_down_msg;
        $setting->save();
        /******************************* */
        /******************************* */
        $recordUpdateHistoryData = [
            'record_id' => $setting->ID,
            'record_title' => 'web_down_status',
            'record_link' => url('adminmedia/settings/'.$setting->ID.'/edit'),
            'model_or_table' => 'Setting',
            'admin_id' => auth()->user()->id,
            'ip' => request()->ip(),
            'draft' => json_encode($setting->toArray()),
        ];
        recordUpdateHistory($recordUpdateHistoryData);
        /******************************* */
        /******************************* */
        session(['message' => 'Updated Successfully', 'type' => 'success']);
        return redirect()->back();
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
        $setting = Setting::first();
        $setting->google_adsense_footer = $request->google_adsense_footer;
        $setting->google_adsense_left = $request->google_adsense_left;
        $setting->google_adsense_right = $request->google_adsense_right;
        $setting->save();
        /******************************* */
        /******************************* */
        $recordUpdateHistoryData = [
            'record_id' => $setting->ID,
            'record_title' => 'google_adsense',
            'record_link' => url('adminmedia/settings/'.$setting->ID.'/edit'),
            'model_or_table' => 'Setting',
            'admin_id' => auth()->user()->id,
            'ip' => request()->ip(),
            'draft' => json_encode($setting->toArray()),
        ];
        recordUpdateHistory($recordUpdateHistoryData);
        /******************************* */
        /******************************* */
        session(['message' => 'Updated Successfully', 'type' => 'success']);
        return redirect()->back();
    }
    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function updateMetaData(Request $request)
    {
        $metaDataObj = Metadata::where('data_key', 'time_zone')->first();
        $metaDataObj->val1 = $request->timeZone;
        $metaDataObj->save();
        /******************************* */
        /******************************* */
        $recordUpdateHistoryData = [
            'record_id' => $metaDataObj->id,
            'record_title' => $metaDataObj->data_key,
            'record_link' => url('adminmedia/setting/meta_data'),
            'model_or_table' => 'MetaData',
            'admin_id' => auth()->user()->id,
            'ip' => request()->ip(),
            'draft' => json_encode($metaDataObj->toArray()),
        ];
        recordUpdateHistory($recordUpdateHistoryData);
        /******************************* */
        /******************************* */


        $metaDataObj = Metadata::where('data_key', 'date_format')->first();
        $metaDataObj->val1 = $request->dateFormat;
        $metaDataObj->save();
        /******************************* */
        /******************************* */
        $recordUpdateHistoryData = [
            'record_id' => $metaDataObj->id,
            'record_title' => $metaDataObj->data_key,
            'record_link' => url('adminmedia/setting/meta_data'),
            'model_or_table' => 'MetaData',
            'admin_id' => auth()->user()->id,
            'ip' => request()->ip(),
            'draft' => json_encode($metaDataObj->toArray()),
        ];
        recordUpdateHistory($recordUpdateHistoryData);
        /******************************* */
        /******************************* */


        $metaDataObj = Metadata::where('data_key', 'date_time_format')->first();
        $metaDataObj->val1 = $request->dateTimeFormat;
        $metaDataObj->save();
        /******************************* */
        /******************************* */
        $recordUpdateHistoryData = [
            'record_id' => $metaDataObj->id,
            'record_title' => $metaDataObj->data_key,
            'record_link' => url('adminmedia/setting/meta_data'),
            'model_or_table' => 'MetaData',
            'admin_id' => auth()->user()->id,
            'ip' => request()->ip(),
            'draft' => json_encode($metaDataObj->toArray()),
        ];
        recordUpdateHistory($recordUpdateHistoryData);
        /******************************* */
        /******************************* */

        $metaDataObj = Metadata::where('data_key', 'max_image_size')->first();
        $metaDataObj->val1 = $request->imageMaxSize;
        $metaDataObj->save();
        /******************************* */
        /******************************* */
        $recordUpdateHistoryData = [
            'record_id' => $metaDataObj->id,
            'record_title' => $metaDataObj->data_key,
            'record_link' => url('adminmedia/setting/meta_data'),
            'model_or_table' => 'MetaData',
            'admin_id' => auth()->user()->id,
            'ip' => request()->ip(),
            'draft' => json_encode($metaDataObj->toArray()),
        ];
        recordUpdateHistory($recordUpdateHistoryData);
        /******************************* */
        /******************************* */



        session([
            'date_format' => $request->dateFormat,
            'date_time_format' => $request->dateTimeFormat,
            'time_zone' => $request->timeZone,
            'max_image_size' => $request->imageMaxSize,
        ]);
        session(['message' => 'Updated Successfully', 'type' => 'success']);
        return redirect()->back();
    }
    public function saveCaptcha(Request $request)
    {
        $metaDataObj = Metadata::where('data_key', 'recaptcha_site_key')->first();
        $metaDataObj->val1 = $request->siteKey;
        $metaDataObj->save();
        /******************************* */
        /******************************* */
        $recordUpdateHistoryData = [
            'record_id' => $metaDataObj->id,
            'record_title' => $metaDataObj->data_key,
            'record_link' => url('adminmedia/setting/captcha'),
            'model_or_table' => 'MetaData',
            'admin_id' => auth()->user()->id,
            'ip' => request()->ip(),
            'draft' => json_encode($metaDataObj->toArray()),
        ];
        recordUpdateHistory($recordUpdateHistoryData);
        /******************************* */
        /******************************* */

        $metaDataObj = Metadata::where('data_key', 'recaptcha_secret_key')->first();
        $metaDataObj->val1 = $request->secretKey;
        $metaDataObj->save();
        /******************************* */
        /******************************* */
        $recordUpdateHistoryData = [
            'record_id' => $metaDataObj->id,
            'record_title' => $metaDataObj->data_key,
            'record_link' => url('adminmedia/setting/captcha'),
            'model_or_table' => 'MetaData',
            'admin_id' => auth()->user()->id,
            'ip' => request()->ip(),
            'draft' => json_encode($metaDataObj->toArray()),
        ];
        recordUpdateHistory($recordUpdateHistoryData);
        /******************************* */
        /******************************* */

        session(['message' => 'Updated Successfully', 'type' => 'success']);
        return redirect()->back();
    }
    public function ipAddress(Request $request)
    {
        $metaDataObj = Metadata::where('data_key', 'blocked_ips')->first();
        $blockedIPs = $request->ipAddresses;
        $ip = $request->ip();
        $wholeBlock = strcmp($request->blocked_area, 'website') ? false : 'true';
        if (is_array($blockedIPs) && count($blockedIPs) > 0) {
            if ($wholeBlock && isSelfIpBlocked($ip, $blockedIPs)) {
                session(['message' => 'You have denied access to the IP address you are logged in from. This will lock you out of website. The request to add IP was denied by system.', 'type' => 'error']);
                return redirect()->back();
            }
            $metaDataObj->val1 = implode(',', $blockedIPs);
        } else {
            $metaDataObj->val1 = '';
        }
        $metaDataObj->save();
        /******************************* */
        /******************************* */
        $recordUpdateHistoryData = [
            'record_id' => $metaDataObj->id,
            'record_title' => $metaDataObj->data_key,
            'record_link' => url('adminmedia/setting/ip-address'),
            'model_or_table' => 'MetaData',
            'admin_id' => auth()->user()->id,
            'ip' => request()->ip(),
            'draft' => json_encode($metaDataObj->toArray()),
        ];
        recordUpdateHistory($recordUpdateHistoryData);
        /******************************* */
        /******************************* */


        $metaDataObj = Metadata::where('data_key', 'restrict_traffic')->first();
        if (isset($request->restrict_traffic)) {
            if ($request->block_list_active == 1) {
                if ($wholeBlock && isSelfCountryInBlockedList($ip, $request->blockedCounties)) {
                    session(['message' => 'Request Denied. Your own IP is within the list of countries you tried blocking.', 'type' => 'error']);

                    return redirect()->back();
                }
            } else {
                if ($wholeBlock && !isSelfCountryInAllowedList($ip, $request->openedCounties)) {
                    session(['message' => 'Request Denied. You have not included your own country in allowed list. You must include your own country and any other country where you want to allow access to your website.', 'type' => 'error']);
                    return redirect()->back();
                }
            }
            $metaDataObj->val1 = 1;
        } else {
            $metaDataObj->val1 = 0;
        }
        $metaDataObj->save();
        /******************************* */
        /******************************* */
        $recordUpdateHistoryData = [
            'record_id' => $metaDataObj->id,
            'record_title' => $metaDataObj->data_key,
            'record_link' => url('adminmedia/setting/ip-address'),
            'model_or_table' => 'MetaData',
            'admin_id' => auth()->user()->id,
            'ip' => request()->ip(),
            'draft' => json_encode($metaDataObj->toArray()),
        ];
        recordUpdateHistory($recordUpdateHistoryData);
        /******************************* */
        /******************************* */

        $metaDataObj = Metadata::where('data_key', 'block_list_active')->first();
        $metaDataObj->val1 = $request->block_list_active;
        $metaDataObj->save();
        /******************************* */
        /******************************* */
        $recordUpdateHistoryData = [
            'record_id' => $metaDataObj->id,
            'record_title' => $metaDataObj->data_key,
            'record_link' => url('adminmedia/setting/ip-address'),
            'model_or_table' => 'MetaData',
            'admin_id' => auth()->user()->id,
            'ip' => request()->ip(),
            'draft' => json_encode($metaDataObj->toArray()),
        ];
        recordUpdateHistory($recordUpdateHistoryData);
        /******************************* */
        /******************************* */

        $metaDataObj = Metadata::where('data_key', 'blocked_countries')->first();
        $metaDataObj->val1 = implode(',', $request->blockedCounties);
        $metaDataObj->save();
        /******************************* */
        /******************************* */
        $recordUpdateHistoryData = [
            'record_id' => $metaDataObj->id,
            'record_title' => $metaDataObj->data_key,
            'record_link' => url('adminmedia/setting/ip-address'),
            'model_or_table' => 'MetaData',
            'admin_id' => auth()->user()->id,
            'ip' => request()->ip(),
            'draft' => json_encode($metaDataObj->toArray()),
        ];
        recordUpdateHistory($recordUpdateHistoryData);
        /******************************* */
        /******************************* */

        $metaDataObj = Metadata::where('data_key', 'allowed_countries')->first();
        $metaDataObj->val1 = implode(',', $request->openedCounties);
        $metaDataObj->save();
        /******************************* */
        /******************************* */
        $recordUpdateHistoryData = [
            'record_id' => $metaDataObj->id,
            'record_title' => $metaDataObj->data_key,
            'record_link' => url('adminmedia/setting/ip-address'),
            'model_or_table' => 'MetaData',
            'admin_id' => auth()->user()->id,
            'ip' => request()->ip(),
            'draft' => json_encode($metaDataObj->toArray()),
        ];
        recordUpdateHistory($recordUpdateHistoryData);
        /******************************* */
        /******************************* */


        $metaDataObj = Metadata::where('data_key', 'blocked_area')->first();
        $metaDataObj->val1 = $request->blocked_area;
        $metaDataObj->save();
        /******************************* */
        /******************************* */
        $recordUpdateHistoryData = [
            'record_id' => $metaDataObj->id,
            'record_title' => $metaDataObj->data_key,
            'record_link' => url('adminmedia/setting/ip-address'),
            'model_or_table' => 'MetaData',
            'admin_id' => auth()->user()->id,
            'ip' => request()->ip(),
            'draft' => json_encode($metaDataObj->toArray()),
        ];
        recordUpdateHistory($recordUpdateHistoryData);
        /******************************* */
        /******************************* */

        $metaDataObj = Metadata::where('data_key', 'web_blocked_msg')->first();
        $metaDataObj->val1 = $request->web_blocked_msg;
        $metaDataObj->save();
        /******************************* */
        /******************************* */
        $recordUpdateHistoryData = [
            'record_id' => $metaDataObj->id,
            'record_title' => $metaDataObj->data_key,
            'record_link' => url('adminmedia/setting/ip-address'),
            'model_or_table' => 'MetaData',
            'admin_id' => auth()->user()->id,
            'ip' => request()->ip(),
            'draft' => json_encode($metaDataObj->toArray()),
        ];
        recordUpdateHistory($recordUpdateHistoryData);
        /******************************* */
        /******************************* */

        $metaDataObj = Metadata::where('data_key', 'negative_keywords')->first();
        $negativeKeywords = $request->negativeKeywords;
        if (is_array($negativeKeywords) && count($negativeKeywords) > 0) {
            $metaDataObj->val1 = implode(',', $negativeKeywords);
        } else {
            $metaDataObj->val1 = '';
        }
        $metaDataObj->save();
        /******************************* */
        /******************************* */
        $recordUpdateHistoryData = [
            'record_id' => $metaDataObj->id,
            'record_title' => $metaDataObj->data_key,
            'record_link' => url('adminmedia/setting/ip-address'),
            'model_or_table' => 'MetaData',
            'admin_id' => auth()->user()->id,
            'ip' => request()->ip(),
            'draft' => json_encode($metaDataObj->toArray()),
        ];
        recordUpdateHistory($recordUpdateHistoryData);
        /******************************* */
        /******************************* */

        $metaDataObj = Metadata::where('data_key', 'negative_TLDs')->first();
        $negativeTLDs = $request->negativeTLDs;
        if (is_array($negativeTLDs) && count($negativeTLDs) > 0) {
            $metaDataObj->val1 = implode(',', $negativeTLDs);
        } else {
            $metaDataObj->val1 = '';
        }
        $metaDataObj->save();
        /******************************* */
        /******************************* */
        $recordUpdateHistoryData = [
            'record_id' => $metaDataObj->id,
            'record_title' => $metaDataObj->data_key,
            'record_link' => url('adminmedia/setting/ip-address'),
            'model_or_table' => 'MetaData',
            'admin_id' => auth()->user()->id,
            'ip' => request()->ip(),
            'draft' => json_encode($metaDataObj->toArray()),
        ];
        recordUpdateHistory($recordUpdateHistoryData);
        /******************************* */
        /******************************* */
        session(['message' => 'Updated Successfully', 'type' => 'success']);
        return redirect()->back();
    }
    public function countries()
    {
        $data = Country::all();
        echo json_encode($data);
        return;
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {}
    public function file_upload_max_size()
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
    public function parse_size($size)
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
    public function js(Request $request)
    {
        $setting = Setting::first();
        $setting->head_js = $request->head_js;
        $setting->body_js = $request->body_js;
        $setting->save();
        /******************************* */
        /******************************* */
        $recordUpdateHistoryData = [
            'record_id' => $setting->ID,
            'record_title' => 'head_body_js',
            'record_link' => url('adminmedia/settings/'.$setting->ID.'/edit'),
            'model_or_table' => 'Setting',
            'admin_id' => auth()->user()->id,
            'ip' => request()->ip(),
            'draft' => json_encode($setting->toArray()),
        ];
        recordUpdateHistory($recordUpdateHistoryData);
        /******************************* */
        /******************************* */
        session(['message' => 'Updated Successfully', 'type' => 'success']);
        return redirect()->back();
    }
    public function adminLogoFavicon(Request $request)
    {
        $validated = $request->validate([
            'admin_login_page_logo' => 'image',
            'admin_header_logo' => 'image',
            'og_image' => 'image',
            'admin_favicon' => [new CheckIfFavicon()],
        ]);
        $setting = Setting::first();
        if ($request->hasFile('admin_login_page_logo')) {
            ImageUploader::deleteImage('admin_logo_favicon', $setting->admin_login_page_logo, true);
            $image = $request->file('admin_login_page_logo');
            $fileName = ImageUploader::UploadImage('admin_logo_favicon', $image, '', 800, 800, false);
            $setting->admin_login_page_logo = $fileName;
        }
        if ($request->hasFile('admin_header_logo')) {
            ImageUploader::deleteImage('admin_logo_favicon', $setting->admin_header_logo, true);
            $image = $request->file('admin_header_logo');
            $fileName = ImageUploader::UploadImage('admin_logo_favicon', $image, '', 800, 800, false);
            $setting->admin_header_logo = $fileName;
        }
        if ($request->hasFile('admin_favicon')) {
            ImageUploader::deleteImage('admin_logo_favicon', $setting->admin_favicon, true);
            $image = $request->file('admin_favicon');
            $fileName = ImageUploader::UploadDoc('admin_logo_favicon', $image);
            $setting->admin_favicon = $fileName;
        }
        if ($request->hasFile('og_image')) {
            ImageUploader::deleteImage('admin_logo_favicon', $setting->og_image, true);
            $image = $request->file('og_image');
            $fileName = ImageUploader::UploadImage('admin_logo_favicon', $image, '', 1200, 627, false);
            $setting->og_image = $fileName;
        }
        $setting->save();
        /******************************* */
        /******************************* */
        $recordUpdateHistoryData = [
            'record_id' => $setting->ID,
            'record_title' => 'admin_logo_favicon',
            'record_link' => url('adminmedia/settings/'.$setting->ID.'/edit'),
            'model_or_table' => 'Setting',
            'admin_id' => auth()->user()->id,
            'ip' => request()->ip(),
            'draft' => json_encode($setting->toArray()),
        ];
        recordUpdateHistory($recordUpdateHistoryData);
        /******************************* */
        /******************************* */
        session(['message' => 'Updated Successfully', 'type' => 'success']);
        return redirect()->back();
    }
    public function savePaypal(Request $request)
    {
        $metaDataObj = Metadata::where('data_key', 'paypal_live_client_id')->first();
        $metaDataObj->val1 = $request->paypal_live_client_id;
        $metaDataObj->save();
        /******************************* */
        /******************************* */
        $recordUpdateHistoryData = [
            'record_id' => $metaDataObj->id,
            'record_title' => $metaDataObj->data_key,
            'record_link' => url('adminmedia/setting/paypal'),
            'model_or_table' => 'MetaData',
            'admin_id' => auth()->user()->id,
            'ip' => request()->ip(),
            'draft' => json_encode($metaDataObj->toArray()),
        ];
        recordUpdateHistory($recordUpdateHistoryData);
        /******************************* */
        /******************************* */
        /*************************************** */
        $metaDataObj = Metadata::where('data_key', 'paypal_live_secret')->first();
        $metaDataObj->val1 = $request->paypal_live_secret;
        $metaDataObj->save();
        /******************************* */
        /******************************* */
        $recordUpdateHistoryData = [
            'record_id' => $metaDataObj->id,
            'record_title' => $metaDataObj->data_key,
            'record_link' => url('adminmedia/setting/paypal'),
            'model_or_table' => 'MetaData',
            'admin_id' => auth()->user()->id,
            'ip' => request()->ip(),
            'draft' => json_encode($metaDataObj->toArray()),
        ];
        recordUpdateHistory($recordUpdateHistoryData);
        /******************************* */
        /******************************* */
        /*************************************** */
        $metaDataObj = Metadata::where('data_key', 'paypal_sandbox_client_id')->first();
        $metaDataObj->val1 = $request->paypal_sandbox_client_id;
        $metaDataObj->save();
        /******************************* */
        /******************************* */
        $recordUpdateHistoryData = [
            'record_id' => $metaDataObj->id,
            'record_title' => $metaDataObj->data_key,
            'record_link' => url('adminmedia/setting/paypal'),
            'model_or_table' => 'MetaData',
            'admin_id' => auth()->user()->id,
            'ip' => request()->ip(),
            'draft' => json_encode($metaDataObj->toArray()),
        ];
        recordUpdateHistory($recordUpdateHistoryData);
        /******************************* */
        /******************************* */
        /*************************************** */
        $metaDataObj = Metadata::where('data_key', 'paypal_sandbox_secret')->first();
        $metaDataObj->val1 = $request->paypal_sandbox_secret;
        $metaDataObj->save();
        /******************************* */
        /******************************* */
        $recordUpdateHistoryData = [
            'record_id' => $metaDataObj->id,
            'record_title' => $metaDataObj->data_key,
            'record_link' => url('adminmedia/setting/paypal'),
            'model_or_table' => 'MetaData',
            'admin_id' => auth()->user()->id,
            'ip' => request()->ip(),
            'draft' => json_encode($metaDataObj->toArray()),
        ];
        recordUpdateHistory($recordUpdateHistoryData);
        /******************************* */
        /******************************* */
        /*************************************** */
        $metaDataObj = Metadata::where('data_key', 'paypal_mode')->first();
        $metaDataObj->val1 = $request->paypal_mode;
        $metaDataObj->save();
        /******************************* */
        /******************************* */
        $recordUpdateHistoryData = [
            'record_id' => $metaDataObj->id,
            'record_title' => $metaDataObj->data_key,
            'record_link' => url('adminmedia/setting/paypal'),
            'model_or_table' => 'MetaData',
            'admin_id' => auth()->user()->id,
            'ip' => request()->ip(),
            'draft' => json_encode($metaDataObj->toArray()),
        ];
        recordUpdateHistory($recordUpdateHistoryData);
        /******************************* */
        /******************************* */
        /*************************************** */
        session(['message' => 'Updated Successfully', 'type' => 'success']);
        return redirect()->back();
    }

    public function savePropertyIdAndJsonFile(Request $request)
    {
        $validated = $request->validate([
            'service_account_credentials_json' => [new CheckIfJson()],
        ]);
        $metaDataObj = Metadata::where('data_key', 'is_show_analytics')->first();
        $metaDataObj->val1 = $request->input('is_show_analytics', 0);
        $metaDataObj->save();

        /******************************* */
        /******************************* */
        $recordUpdateHistoryData = [
            'record_id' => $metaDataObj->id,
            'record_title' => $metaDataObj->data_key,
            'record_link' => url('adminmedia/setting/savePropertyIdAndJsonFile'),
            'model_or_table' => 'MetaData',
            'admin_id' => auth()->user()->id,
            'ip' => request()->ip(),
            'draft' => json_encode($metaDataObj->toArray()),
        ];
        recordUpdateHistory($recordUpdateHistoryData);
        /******************************* */
        /******************************* */

        $metaDataObj = Metadata::where('data_key', 'analytics_property_id')->first();
        $metaDataObj->val1 = $request->input('analytics_property_id', '');
        $metaDataObj->save();
        /******************************* */
        /******************************* */
        $recordUpdateHistoryData = [
            'record_id' => $metaDataObj->id,
            'record_title' => $metaDataObj->data_key,
            'record_link' => url('adminmedia/setting/savePropertyIdAndJsonFile'),
            'model_or_table' => 'MetaData',
            'admin_id' => auth()->user()->id,
            'ip' => request()->ip(),
            'draft' => json_encode($metaDataObj->toArray()),
        ];
        recordUpdateHistory($recordUpdateHistoryData);
        /******************************* */
        /******************************* */

        if ($request->hasFile('service_account_credentials_json')) {
            $metaDataObj = Metadata::where('data_key', 'service_account_credentials_json')->first();
            ImageUploader::deleteFile('analytics', $metaDataObj->val1);
            $service_account_credentials_json_file = $request->file('service_account_credentials_json');
            $fileName = ImageUploader::UploadFile('analytics', $service_account_credentials_json_file);
            $metaDataObj->val1 = $fileName;
            $metaDataObj->save();
            /******************************* */
            /******************************* */
            $recordUpdateHistoryData = [
                'record_id' => $metaDataObj->id,
                'record_title' => $metaDataObj->data_key,
                'record_link' => url('adminmedia/setting/savePropertyIdAndJsonFile'),
                'model_or_table' => 'MetaData',
                'admin_id' => auth()->user()->id,
                'ip' => request()->ip(),
                'draft' => json_encode($metaDataObj->toArray()),
            ];
            recordUpdateHistory($recordUpdateHistoryData);
            /******************************* */
            /******************************* */
        }
        session(['message' => 'Updated Successfully', 'type' => 'success']);
        return redirect()->back();
    }

    public function banner_popup(Request $request)
    {
        $validated = $request->validate([
            'banner_popup_image' => 'image',
            'banner_popup_status' => 'required'
        ]);
        $metaDataObj = Metadata::where('data_key', 'banner_popup_image')->first();
        if ($request->hasFile('banner_popup_image')) {
            ImageUploader::deleteImage('banner_popup', $metaDataObj->val1, false);
            $image = $request->file('banner_popup_image');
            $fileName = ImageUploader::UploadImage('banner_popup', $image, '', 2200, 2200, false);
            $metaDataObj->val1 = $fileName;
            $metaDataObj->save();
            /******************************* */
            /******************************* */
            $recordUpdateHistoryData = [
                'record_id' => $metaDataObj->id,
                'record_title' => $metaDataObj->data_key,
                'record_link' => url('adminmedia/setting/banner_popup'),
                'model_or_table' => 'MetaData',
                'admin_id' => auth()->user()->id,
                'ip' => request()->ip(),
                'draft' => json_encode($metaDataObj->toArray()),
            ];
            recordUpdateHistory($recordUpdateHistoryData);
            /******************************* */
            /******************************* */
        }
        $metaDataObj = Metadata::where('data_key', 'banner_popup_status')->first();
        $metaDataObj->val1 = $request->banner_popup_status;
        $metaDataObj->save();
        /******************************* */
        /******************************* */
        $recordUpdateHistoryData = [
            'record_id' => $metaDataObj->id,
            'record_title' => $metaDataObj->data_key,
            'record_link' => url('adminmedia/setting/banner_popup'),
            'model_or_table' => 'MetaData',
            'admin_id' => auth()->user()->id,
            'ip' => request()->ip(),
            'draft' => json_encode($metaDataObj->toArray()),
        ];
        recordUpdateHistory($recordUpdateHistoryData);
        /******************************* */
        /******************************* */
        Session::flash('updated_action', 'Updated');
        return redirect()->back();
    }
}

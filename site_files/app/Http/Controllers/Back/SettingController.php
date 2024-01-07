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
    public function create()
    {
    }
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
        $timeZone = Metadata::where('data_key', 'time_zone')->first();
        $timeZone->val1 = $request->timeZone;
        $timeZone->save();
        $dateFormat = Metadata::where('data_key', 'date_format')->first();
        $dateFormat->val1 = $request->dateFormat;
        $dateFormat->save();
        $dateTimeFormat = Metadata::where('data_key', 'date_time_format')->first();
        $dateTimeFormat->val1 = $request->dateTimeFormat;
        $dateTimeFormat->save();
        $imageSize = Metadata::where('data_key', 'max_image_size')->first();
        $imageSize->val1 = $request->imageMaxSize;
        $imageSize->save();
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
        $reCaptchaSite = Metadata::where('data_key', 'recaptcha_site_key')->first();
        $reCaptchaSite->val1 = $request->siteKey;
        $reCaptchaSite->save();
        $reCaptchaSecret = Metadata::where('data_key', 'recaptcha_secret_key')->first();
        $reCaptchaSecret->val1 = $request->secretKey;
        $reCaptchaSecret->save();
        session(['message' => 'Updated Successfully', 'type' => 'success']);
        return redirect()->back();
    }
    public function ipAddress(Request $request)
    {
        $blockIPs = Metadata::where('data_key', 'blocked_ips')->first();
        $blockedIPs = $request->ipAddresses;
        $ip = $request->ip();
        $wholeBlock = strcmp($request->blocked_area, 'website') ? false : 'true';
        if (is_array($blockedIPs) && count($blockedIPs) > 0) {
            if ($wholeBlock && isSelfIpBlocked($ip, $blockedIPs)) {
                session(['message' => 'You have denied access to the IP address you are logged in from. This will lock you out of website. The request to add IP was denied by system.', 'type' => 'error']);
                return redirect()->back();
            }
            $blockIPs->val1 = implode(',', $blockedIPs);
        } else {
            $blockIPs->val1 = '';
        }
        $blockIPs->save();
        $traffic = Metadata::where('data_key', 'restrict_traffic')->first();
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
            $traffic->val1 = 1;
        } else {
            $traffic->val1 = 0;
        }
        $traffic->save();
        $blockList = Metadata::where('data_key', 'block_list_active')->first();
        $blockList->val1 = $request->block_list_active;
        $blockList->save();
        $blockedCountries = Metadata::where('data_key', 'blocked_countries')->first();
        $blockedCountries->val1 = implode(',', $request->blockedCounties);
        $blockedCountries->save();
        $allowedCountries = Metadata::where('data_key', 'allowed_countries')->first();
        $allowedCountries->val1 = implode(',', $request->openedCounties);
        $allowedCountries->save();
        $blockList = Metadata::where('data_key', 'blocked_area')->first();
        $blockList->val1 = $request->blocked_area;
        $blockList->save();
        $blockMsg = Metadata::where('data_key', 'web_blocked_msg')->first();
        $blockMsg->val1 = $request->web_blocked_msg;
        $blockMsg->save();
        $negativeKeywordsMetaData = Metadata::where('data_key', 'negative_keywords')->first();
        $negativeKeywords = $request->negativeKeywords;
        if (is_array($negativeKeywords) && count($negativeKeywords) > 0) {
            $negativeKeywordsMetaData->val1 = implode(',', $negativeKeywords);
        } else {
            $negativeKeywordsMetaData->val1 = '';
        }
        $negativeKeywordsMetaData->save();
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
    public function destroy($id)
    {
    }
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
        session(['message' => 'Updated Successfully', 'type' => 'success']);
        return redirect()->back();
    }
    public function adminLogoFavicon(Request $request)
    {
        $validated = $request->validate([
            'admin_login_page_logo' => 'image',
            'admin_header_logo' => 'image',
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
        $setting->save();
        session(['message' => 'Updated Successfully', 'type' => 'success']);
        return redirect()->back();
    }
    public function savePaypal(Request $request)
    {
        $paypal_live_client_id = Metadata::where('data_key', 'paypal_live_client_id')->first();
        $paypal_live_client_id->val1 = $request->paypal_live_client_id;
        $paypal_live_client_id->save();
        /*************************************** */
        $paypal_live_secret = Metadata::where('data_key', 'paypal_live_secret')->first();
        $paypal_live_secret->val1 = $request->paypal_live_secret;
        $paypal_live_secret->save();
        /*************************************** */
        $paypal_sandbox_client_id = Metadata::where('data_key', 'paypal_sandbox_client_id')->first();
        $paypal_sandbox_client_id->val1 = $request->paypal_sandbox_client_id;
        $paypal_sandbox_client_id->save();
        /*************************************** */
        $paypal_sandbox_secret = Metadata::where('data_key', 'paypal_sandbox_secret')->first();
        $paypal_sandbox_secret->val1 = $request->paypal_sandbox_secret;
        $paypal_sandbox_secret->save();
        /*************************************** */
        $paypal_mode = Metadata::where('data_key', 'paypal_mode')->first();
        $paypal_mode->val1 = $request->paypal_mode;
        $paypal_mode->save();
        /*************************************** */
        session(['message' => 'Updated Successfully', 'type' => 'success']);
        return redirect()->back();
    }

    public function savePropertyIdAndJsonFile(Request $request)
    {
        $validated = $request->validate([
            'service_account_credentials_json' => [new CheckIfJson()],
        ]);
        $is_show_analytics = Metadata::where('data_key', 'is_show_analytics')->first();
        $is_show_analytics->val1 = $request->input('is_show_analytics', 0);
        $is_show_analytics->save();

        $analytics_property_id = Metadata::where('data_key', 'analytics_property_id')->first();
        $analytics_property_id->val1 = $request->input('analytics_property_id', '');
        $analytics_property_id->save();

        if ($request->hasFile('service_account_credentials_json')) {
            $service_account_credentials_json = Metadata::where('data_key', 'service_account_credentials_json')->first();
            ImageUploader::deleteFile('analytics', $service_account_credentials_json->val1);
            $service_account_credentials_json_file = $request->file('service_account_credentials_json');
            $fileName = ImageUploader::UploadFile('analytics', $service_account_credentials_json_file);
            $service_account_credentials_json->val1 = $fileName;
            $service_account_credentials_json->save();
        }
        session(['message' => 'Updated Successfully', 'type' => 'success']);
        return redirect()->back();
    }
}

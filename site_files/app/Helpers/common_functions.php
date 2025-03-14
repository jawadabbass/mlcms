<?php

use App\Models\Back\Menu;
use App\Models\Back\Goals;
use App\Models\Back\Setting;
use App\Models\Back\Category;
use App\Models\Back\Metadata;
use Illuminate\Support\Facades\Route;
use App\Models\Back\CmsModuleData;
use App\Models\Back\ClientPackages;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

if (!function_exists('showAllRoutes')) {
	function showAllRoutes()
	{
		$routeCollection = Route::getRoutes();

		echo "<table style='width:100%'>";
		echo "<tr>";
		echo "<td width='10%'><h4>HTTP Method</h4></td>";
		echo "<td width='10%'><h4>Route</h4></td>";
		echo "<td width='10%'><h4>Name</h4></td>";
		echo "<td width='70%'><h4>Corresponding Action</h4></td>";
		echo "</tr>";
		foreach ($routeCollection as $value) {
			echo "<tr>";
			echo "<td>" . $value->methods()[0] . "</td>";
			echo "<td>" . $value->uri() . "</td>";
			echo "<td>" . $value->getName() . "</td>";
			echo "<td>" . $value->getActionName() . "</td>";
			echo "</tr>";
		}
		echo "</table>";
	}
}
if (!function_exists('clearCache')) {
	function clearCache()
	{
		Cache::flush();
		DB::table('cache')->truncate();
		DB::table('cache_locks')->truncate();
		/*************************** */
	}
}
if (!function_exists('clearTempFiles')) {
	function clearTempFiles()
	{
		$ignoreFiles = ['.gitignore', '.', '..'];
		Cache::flush();
		DB::table('cache')->truncate();
		DB::table('cache_locks')->truncate();
		/*************************** */
		$directory = config('view.compiled');
		if (is_dir($directory)) {
			$files = scandir($directory);
			foreach ($files as $file) {
				if (!in_array($file, $ignoreFiles)) {
					unlink($directory . '/' . $file);
				}
			}
		}
		/*************************** */
		$directory = config('cache.stores.file.path');
		if (is_dir($directory)) {
			$files = scandir($directory);
			foreach ($files as $file) {
				if (!in_array($file, $ignoreFiles)) {
					unlink($directory . '/' . $file);
				}
			}
		}
		/*************************** */
		DB::table('sessions')->truncate();
		$directory = config('session.files');
		if (is_dir($directory)) {
			$files = scandir($directory);
			foreach ($files as $file) {
				if (!in_array($file, $ignoreFiles)) {
					unlink($directory . '/' . $file);
				}
			}
		}
		/*************************** */
		$directory = config('logfile.files');
		if (is_dir($directory)) {
			$files = scandir($directory);
			foreach ($files as $file) {
				if (!in_array($file, $ignoreFiles)) {
					unlink($directory . '/' . $file);
				}
			}
		}
		/*************************** */
	}
}
if (!function_exists('get_all_footer_details')) {
	function get_all_footer_details()
	{
		$data = Setting::all();
		return $data;
	}
}
if (!function_exists('make_phone_format_for_call')) {
	function make_phone_format_for_call($number)
	{
		$number = preg_replace("/[^a-zA-Z0-9]+/", "", $number);
		return $number;
	}
}
if (!function_exists('is_website_live')) {
	function is_website_live()
	{
		$whitelist = array('127.0.0.1', '::1');
		if (!in_array($_SERVER['REMOTE_ADDR'], $whitelist)) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}
function makeSlugOfAnyString($text)
{
	// replace non letter or digits by -
	$text = preg_replace('~[^\pL\d]+~u', '-', $text);
	// transliterate
	$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
	// remove unwanted characters
	$text = preg_replace('~[^-\w]+~', '', $text);
	// trim
	$text = trim($text, '-');
	// remove duplicate -
	$text = preg_replace('~-+~', '-', $text);
	// lowercase
	$text = strtolower($text);
	if (empty($text)) {
		return 'n-a';
	}
	return $text;
}
if (!function_exists('is_in_array')) {
	function is_in_array($array, $key, $key_value)
	{
		$within_array = false;
		foreach ($array as $k => $v) {
			if (is_array($v)) {
				$within_array = is_in_array($v, $key, $key_value);
				if ($within_array == true) {
					break;
				}
			} else {
				if ($v == $key_value && $k == $key) {
					$within_array = true;
					break;
				}
			}
		}
		return $within_array;
	}
}
function myform_admin_cms_filter($data)
{
	$siteLink = base_url();
	$data = str_replace('../', '', $data);
	$tmp = str_replace('public/userfile/', $siteLink . 'public/userfile/', $data);
	return $tmp;
}
if (!function_exists('format_date')) {
	function format_date($dated, $type = 'date')
	{
		if ($dated == '' || $dated == '0000-00-00') {
			return '';
		}
		if ($type == 'date_time') {
			$format = 'M d, Y H:i A';
		} elseif ($type == 'time_only') {
			$format = 'H:i A';
		} else {
			$format = 'M d, Y';
		}
		return date($format, strtotime($dated));
	}
}
if (!function_exists('format_date123')) {
	function format_date123($dated, $type = 'date')
	{
		if ($dated == '' || $dated == '0000-00-00') {
			return '';
		}
		$date = new DateTime($dated, new DateTimeZone('UTC'));
		$sess = 'America/New_York';
		if (session()->has('time_zone')) {
			$sess = session('time_zone');
		}
		$date->setTimezone(new DateTimeZone($sess));
		if ($type == 'date_time') {
			$format = session('date_time_format');
		} elseif ($type == 'time_only') {
			$format = 'H:i A';
		} else {
			$format = session('date_format');
		}
		return $date->format($format) . "\n";
	}
}
if (!function_exists('format_date_tz')) {
	function format_date_tz($dated, $format)
	{
		if ($dated == '' || $dated == '0000-00-00') {
			return '';
		}
		$sess = 'America/New_York';
		if (session()->has('time_zone')) {
			$sess = session('time_zone');
		}
		$date = new DateTime($dated, new DateTimeZone('UTC'));
		$date->setTimezone(new DateTimeZone($sess));
		return $date->format($format) . "\n";
	}
}
if (!function_exists('format_date_front')) {
	function format_date_front($dated, $type = 'date')
	{
		if ($dated == '' || $dated == '0000-00-00') {
			return '';
		}
		$date = new DateTime($dated, new DateTimeZone('UTC'));
		$format = 'M d, Y';
		return $date->format($format) . "\n";
	}
}
if (!function_exists('currency_format')) {
	function currency_format($number)
	{
		$formatted = number_format($number, 2, '.', '');
		return $formatted;
	}
}
if (!function_exists('format_date_time')) {
	function format_date_time($dated, $type = 'both')
	{
		if ($dated == '' || $dated == '0000-00-00') {
			return '';
		}
		$format = Metadata::where('data_key', 'date_time_format')->first()->val1;
		$new_date = date($format, strtotime($dated));
		return $new_date;
	}
}
if (!function_exists('date_formats')) {
	function date_formats($dated, $format = 'm-d-Y')
	{
		if ($dated == '0000-00-00' || $dated == '0000-00-00 00:00:00' || $dated == '') {
			return '';
		}
		$formated_date = date($format, strtotime($dated));
		return $formated_date;
	}
}
if (!function_exists('stext')) {
	function stext($string, $limit = 200, $link = '#')
	{
		$string = strip_tags($string);
		if (strlen($string) > $limit) {
			$stringCut = substr($string, 0, $limit);
			$string = substr($stringCut, 0, strrpos($stringCut, ' ')) . '... <a href="' . $link . '">Read More</a>';
		}
		return $string;
	}
}
if (!function_exists('generate_random_password')) {
	function generate_random_password()
	{
		$data = 'ABCDEFGHJKLMNPQRSTUVWXYZ2345';
		$Random = substr($data, rand() % strlen($data), 1);
		$Random .= substr($data, rand() % strlen($data), 1);
		$Random .= substr($data, rand() % strlen($data), 1);
		$Random .= substr($data, rand() % strlen($data), 1);
		$Random .= substr($data, rand() % strlen($data), 1);
		$Random .= substr($data, rand() % strlen($data), 1);
		$Random .= substr($data, rand() % strlen($data), 1);
		$Random .= substr($data, rand() % strlen($data), 1);
		$pass = $Random;
		return $pass;
	}
}
if (!function_exists('get_extension_name')) {
	function get_extension_name($ext)
	{
		switch ($ext) {
			case 'doc':
				$icon_name = 'word';
				break;
			case 'docx':
				$icon_name = 'word';
				break;
			case 'pdf':
				$icon_name = 'pdf';
				break;
			case 'jpg':
				$icon_name = 'image';
				break;
			case 'jpeg':
				$icon_name = 'image';
				break;
			case 'gif':
				$icon_name = 'image';
				break;
			case 'png':
				$icon_name = 'image';
				break;
			case 'rtf':
				$icon_name = 'text';
				break;
			case 'txt':
				$icon_name = 'text';
				break;
		}
		return $icon_name;
	}
}
if (!function_exists('us_phone_format')) {
	function us_phone_format($strPhone)
	{
		if (strlen($strPhone) != 10) {
			return $strPhone;
		}
		$strArea = substr($strPhone, 0, 3);
		$strPrefix = substr($strPhone, 3, 3);
		$strNumber = substr($strPhone, 6, 4);
		$strPhone = '(' . $strArea . ') ' . $strPrefix . '-' . $strNumber;
		return $strPhone;
	}
}
function tz_list()
{
	$zones_array = [];
	$timestamp = time();
	foreach (timezone_identifiers_list() as $key => $zone) {
		date_default_timezone_set($zone);
		$zones_array[$key]['zone'] = $zone;
		$zones_array[$key]['diff_from_GMT'] = 'UTC/GMT ' . date('P', $timestamp);
	}
	return $zones_array;
}
if (!function_exists('us_ssn_format')) {
	function us_ssn_format($ssn)
	{
		if (strlen($ssn) != 9) {
			return $ssn;
		}
		$strArea = substr($ssn, 0, 3);
		$strPrefix = substr($ssn, 3, 2);
		$strNumber = substr($ssn, 5, 4);
		$strSSN = $strArea . '-' . $strPrefix . '-' . $strNumber;
		return $strSSN;
	}
}
if (!function_exists('helptooltip')) {
	function helptooltip($key)
	{
		$msg = '';
		$arr = [
			'google_adsense_content' => 'This feature lets you advertise other services (including your competitors) to advertise on your website. Once you sign up for Google Adsense and put the provided code in here, the Ads will start to show up on your website. Any one clicking on these Ads will result in per click payment to you. Please only do this if you clearly understand. Note: On many websites we do not designate the place to advertise. If you would like to start advertising on your website, please contact MediaLinkers and we will setup your advertising program.',
			'google_analytics_content' => 'Google offers powerful Visitors Analysis. It helps you see important analysis of how many visitors you had and how they landed on your website and how long did they stayed etc. ',
			'meta_data_content' => 'This section is used to control Time Zone, Date Time formatting and image size in admin section only',
			'news_date_time' => 'This is Event Date.',
			'news_link' => 'This will be NEWs entry link, like http://www.yourdomain.com/news/{link}',
			'cms_link' => 'This will be page link, like http://www.yourdomain.com/{link}',
			'admin_logo_favicon' => 'Manage Admin Logo and Favicon',
			'analytics_property_id_and_json_file' => 'Manage Analytics Property ID and json file',
			'setting_email' => 'This is the default email address used on website. Contact us email will also be sent on this email address.',
			'setting_cc' => 'If you would like to copy your Contact Us email to another email, please enter that email here.',
			'setting_bcc' => 'If you would like to Blind Copy your contact form, please enter it here. A blind copy means the original recipient will not be able to see this email address as one of the recipients.',
			'meta_title' => 'A Page Title is one of the most important on-page ranking factors and should be treated with care. Your page title tag shows up in Search Engine Result Pages (SERPs). Search engines such as Google, Yahoo, and Bing use the title tag as the search results\' title for that page.',
			'meta_description' => 'A Page description is one of the most important on-page ranking factors and should be treated with care. Your page description tag shows up in Search Engine Result Pages (SERPs). Search engines such as Google, Yahoo, and Bing use the description tag as the search results\' description for that page.',
			'canonical_url' => 'If you have a single page that\'s accessible by multiple URLs, or different pages with similar content (for example, a page with both a mobile and a desktop version), Google sees these as duplicate versions of the same page. Google will choose one URL as the canonical version and crawl that, and all other URLs will be considered duplicate URLs and crawled less often.',
			'meta_keywords' => 'A Page keywords is one of the most important on-page ranking factors and should be treated with care. Your page keywords tag shows up in Search Engine Result Pages (SERPs). Search engines such as Google, Yahoo, and Bing use the keywords tag as the search results\' keywords for that page.',
			'banner_img' => 'Banner size should be (1920W X 450H) for good result.',
			'banner_img_alt' => 'An image with an alternate text specified.Used for SEO',
			'page_link' => 'This would be Link of your page',
			'add_ip' => 'IP address OR range of IP address to block on contact us page.',
			'google_map_status' => 'If Status will be {Off} then map will not be display on Contact us page',
			'google_map' => 'This map is displayinsg according to your Main Office address provided above.',
			'spam_words' => 'if any following mention word existed in contact us submitted form that means it is spam and email will not be sent to admin.',
			'web_down_status' => 'If Disable Status will be {On} then website will be down and above Warning message will be displayed',
			'alert_to' => '',
			'recaptcha_msg' => 'Turn On Google reCaptcha on your site, If Off default Image Captcha will be shown.',
			'country_block_message' => 'Block your site based on Country of the visitor, if On website will be blocked based on below selected countries',
			'alert_cc' => 'If you would like to copy your alert email to another email, please enter that email here.',
			'alert_bcc' => 'If you would like to Blind Copy alert email, please enter it here. A blind copy means the original recipient will not be able to see this email address as one of the recipients.',
			'office_address' => 'You can add more than one Office Addresses by click on {Add New Office Address} link',
			'main_office' => 'It is main office address which will be displayed on top on contact us page. it cannot be deleted',
			'proper_url' => 'add a proper link(url) in this field e.g https://www.google.com',
			'block_ip_addresses' => 'Block traffic from specific IP addresses by adding them in the following list',
			'follow' => 'If this is checked, then Google will further crawl to any other link from this page.',
			'no_follow' => 'If this is checked, then Google will not further crawl to any other link from this page.',
			'indexing' => 'If you select this, it means you want Google to index this page. In other words, it will appear in Google search engine. We recommend this option should be checked.',
			'no_indexing' => 'If you select this, it means you do not want Google to index this page. In other words, it will never appear in Google search engine. We recommend this option should be unchecked.',
			'max_image_size' => 'Maximum allowed image size: ' . getMaxUploadSize() . 'MB',
			'sub_cat_link' => 'This would be the link of your sub category ',
			'seo_title' => '',
		];
		if (isset($arr[$key])) {
			$msg = $arr[$key];
			if (!empty($msg)) {
				return '<i class="fas fa-info help_icon" data-bs-toggle="tooltip" title="' . $msg . '" style="font-size: 15px;"></i>';
			}
		} else {
			return '';
		}
	}
}
if (!function_exists('RandomStr')) {
	function RandomStr($noOfDigits)
	{
		$time = md5(rand());
		return substr($time, 1, $noOfDigits);
	}
}
if (!function_exists('filter_text')) {
	function filter_text($str, $type = 'text_num')
	{
		if ($type == 'text_num') {
			return strtolower(preg_replace('~[^A-Za-z-0-9]+~u', '', $str));
		}
		return '';
	}
}
function myform_getmsg($text = '', $msgType = 's')
{
	if ($msgType == 's') {
		$msgType = 'success';
	} elseif ($msgType == 'e') {
		$msgType = 'danger';
	} elseif ($msgType == 'w') {
		$msgType = 'warning';
	} elseif ($msgType == 'i') {
		$msgType = 'info';
	} else {
		$msgType = 'success';
	}
	if ($text != '') {
		return '<div class="alert alert-' . $msgType . ' alert-dismissible fade in" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button> ' . $text . '</div>';
	}
}
function display_with_children($parentRow, $level, $type)
{
	$prelink = $link_str = $page = '';
	$prelink = ($parentRow['is_external_link'] == 'N') ? base_url() : '';
	if ($parentRow['menu_id'] == 0) {
		$link_str .= '<a class="page-linke clickable" target="_blank" href="' . $prelink . $parentRow['menu_url'] . '">Link</a>';
	} else {
		$pageObj = CmsModuleData::where('id', $parentRow['menu_id'])->first();
		$page = ' - (Page : ' . $pageObj->heading . ')';
		$link_str .= '<a class="page-linke clickable" target="_blank" href="' . $prelink . $parentRow['menu_url'] . '">Link</a>';
	}
	$action_str = '<li class="sortableListsOpen" id="item_' . $parentRow['id'] . '" data-module="' . $parentRow['id'] . '">'
		. '<div class="chilnav row">'
		. '<div class="col-lg-9">' . $parentRow['menu_label'] . $page . '</div>'
		. '<div class="col-lg-3">'
		. '<a class="btn btn-sm btn-primary clickable" href="javascript:void(0)" title="Edit" onclick="edit_menu(' . $parentRow['menu_id'] . ',' . $parentRow['id'] . ')"><i class="glyphicon glyphicon-pencil"></i> Edit Text</a>'
		. '&nbsp<a class="btn btn-sm btn-danger clickable" href="javascript:void(0)" title="Delete" onclick="delete_menu(' . $parentRow['id'] . ')"><i class="glyphicon glyphicon-trash"></i> Remove Link</a>&nbsp' . $link_str;
	$action_str .= '</div></div>';
	echo $action_str;
	$result = get_child_pages_array_by_parent_id($parentRow['id'], $type);
	if ($result) {
		echo '<ul class="">';
		foreach ($result as $key => $row) {
			display_with_children($row, $level + 1, $type);
		}
		echo '</ul>';
	}
	echo '</li>';
}
function get_child_pages_array_by_parent_id($parent_id, $type_id)
{
	$result = Menu::where('menu_types', $type_id)
		->where('status', 'Y')
		->where('parent_id', $parent_id)
		->orderBy('menu_sort_order', 'ASC')
		->get();
	if (count($result) > 0) {
		return $result;
	} else {
		return 0;
	}
}
function base_url()
{
	return url('/') . '/';
}
function site_link()
{
	return base_url();
}
function admin_url()
{
	return base_url() . 'adminmedia/';
}
/**
 * Check whether contact us page is block for this specific ip.
 **/
function isIpBlocked($ip)
{
	$blockIPsData = \App\Models\ContactBlockIps::all();
	$blockIps = [];
	foreach ($blockIPsData as $blockIP) {
		array_push($blockIps, $blockIP->ip_list);
	}
	if ($ip != '::1') {
		$arrIP = explode('.', $ip);
		$ip3 = $arrIP[0] . '.' . $arrIP[1] . '.' . $arrIP[2] . '.*';
		$ip2 = $arrIP[0] . '.' . $arrIP[1] . '.*.*';
		if (in_array($ip, $blockIps) || in_array($ip3, $blockIps) || in_array($ip2, $blockIps)) {
			return true;
		}
	}
	return false;
}
/**
 * Check whether user has blocked his own ip or not.
 **/
function isSelfIpBlocked($ip, $blockIPsData)
{
	$blockIps = [];
	foreach ($blockIPsData as $blockIP) {
		array_push($blockIps, $blockIP);
	}
	if ($ip != '::1') {
		$arrIP = explode('.', $ip);
		$ip3 = $arrIP[0] . '.' . $arrIP[1] . '.' . $arrIP[2] . '.*';
		$ip2 = $arrIP[0] . '.' . $arrIP[1] . '.*.*';
		if (in_array($ip, $blockIps) || in_array($ip3, $blockIps) || in_array($ip2, $blockIps)) {
			return true;
		}
	}
	return false;
}
/**
 * Check whether user has blocked his own country or not.
 **/
function isSelfCountryInBlockedList($ip, $blockCountryList)
{
	$blockCountries = [];
	foreach ($blockCountryList as $blockCountry) {
		array_push($blockCountries, $blockCountry);
	}
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'https://api.iplocation.net/?ip=' . $ip);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$data = curl_exec($ch);
	if (curl_errno($ch)) {
	}
	curl_close($ch);
	$data = json_decode($data);
	$countryCode = $data->country_code2;
	if (in_array($countryCode, $blockCountries)) {
		return true;
	}
	return false;
}
/**
 * Check whether user has blocked his own country or not.
 **/
function isSelfCountryInAllowedList($ip, $allowedCountryList)
{
	$allowedCountries = [];
	foreach ($allowedCountryList as $allowedCountry) {
		array_push($allowedCountries, $allowedCountry);
	}
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'https://api.iplocation.net/?ip=' . $ip);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$data = curl_exec($ch);
	if (curl_errno($ch)) {
	}
	curl_close($ch);
	$data = json_decode($data);
	$countryCode = $data->country_code2;
	if (in_array($countryCode, $allowedCountries)) {
		return true;
	}
	return false;
}
/**
 * Check whether contact us page is block in this country or not based on ip.
 **/
function isContactUsBlock($ip)
{
	$metaDatas = Metadata::where('data_key', 'restrict_traffic')
		->orWhere('data_key', 'block_list_active')
		->orWhere('data_key', 'blocked_countries')
		->orWhere('data_key', 'allowed_countries')
		->orWhere('data_key', 'blocked_area')
		->orWhere('data_key', 'blocked_ips')
		->get();
	$metaArray = [];
	foreach ($metaDatas as $metaData) {
		$metaArray[$metaData->data_key] = $metaData->val1;
	}
	if ($metaArray['restrict_traffic'] == 1) {
		$blockIps = explode(',', $metaArray['blocked_ips']);
		if ($ip != '::1') {
			$arrIP = explode('.', $ip);
			$ip3 = $arrIP[0] . '.' . $arrIP[1] . '.' . $arrIP[2] . '.0';
			$ip2 = $arrIP[0] . '.' . $arrIP[1] . '.0.0';
			$ip1 = $arrIP[0] . '.0.0.0';
			if (in_array($ip, $blockIps) || in_array($ip3, $blockIps) || in_array($ip2, $blockIps) || in_array($ip1, $blockIps)) {
				return true;
			}
		}
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://api.iplocation.net/?ip=' . $ip);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$data = curl_exec($ch);
		if (curl_errno($ch)) {
			return false;
		}
		curl_close($ch);
		$data = json_decode($data);
		$countryCode = $data->country_code2;
		if ($metaArray['block_list_active'] == 1) {
			if (strpos($metaArray['blocked_countries'], $countryCode) !== false) {
				if (!strcmp($metaArray['blocked_area'], 'contact_us')) {
					return true;
				} else {
					return false;
				}
			}
		} else {
			if (strpos($metaArray['allowed_countries'], $countryCode) !== false) {
				return false;
			} else {
				if (!strcmp($metaArray['blocked_area'], 'contact_us')) {
					return true;
				} else {
					return false;
				}
			}
		}
	}
	return false;
}
function IsNullOrEmptyString($str)
{
	return !isset($str) || trim($str) === '';
}
if (!function_exists('break_email')) {
	function break_email($matches)
	{
		$mailto = true;
		$email_address = $matches[0];
		$script_open = '<script type="text/javascript">document.write(';
		$script_close = '</script>';
		$mail_to_open = '"<a href=\'" + "mai" + "lto:" + ';
		$mail_to_close = ' + "</a>"';
		$email_body = '';
		$script_body = '';
		$email_address = explode('@', $email_address);
		$username = $email_address[0];
		$dom = explode('.', $email_address[1]);
		$email_body .= '"' . $username . '" + "&#64;" + ';
		foreach ($dom as $key => $d) {
			$email_body .= '"' . $d . '"';
			if ($key < (count($dom) - 1)) {
				$email_body .= ' + "&#46;" + ';
			}
		}
		if ($mailto) {
			$script_body .= $mail_to_open;
			$script_body .= $email_body;
			$script_body .= ' + "\'>" + ';
			$script_body .= $email_body;
			$script_body .= $mail_to_close;
		} else {
			$script_body .= $email_body;
		}
		$script_body .= ');';
		$script = $script_open . $script_body . $script_close;
		return $script;
	}
}
if (!function_exists('break_mailto')) {
	function break_mailto($matches)
	{
		$mailto = true;
		$email_address = $matches[2];
		$text = $matches[4];
		$script_open = '<script type="text/javascript">document.write(';
		$script_close = '</script>';
		$mail_to_open = '"<a href=\'" + "mai" + "lto:" + ';
		$mail_to_close = ' + "</a>"';
		$email_body = '';
		$script_body = '';
		$email_address = explode('@', $email_address);
		$username = $email_address[0];
		$dom = explode('.', $email_address[1]);
		$email_body .= '"' . $username . '" + "&#64;" + ';
		foreach ($dom as $key => $d) {
			$email_body .= '"' . $d . '"';
			if ($key < (count($dom) - 1)) {
				$email_body .= ' + "&#46;" + ';
			}
		}
		if ($mailto) {
			$script_body .= $mail_to_open;
			$script_body .= $email_body;
			$script_body .= ' + "\'>" + ';
			$regex = '/[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})/';
			if (!(preg_match($regex, trim($text), $email_is) === 1)) {
				$script_body .= '"' . $text . '"';
			} else {
				$script_body .= $email_body;
			}
			$script_body .= $mail_to_close;
		} else {
			$script_body .= $email_body;
		}
		$script_body .= ');';
		$script = $script_open . $script_body . $script_close;
		return $script;
	}
}
function replaceEmail($str)
{
	$mail_pattern = "/([A-z0-9_-]+\@[A-z0-9_-]+\.)([A-z0-9\_\-\.]{1,}[A-z])/";
	$str = preg_replace_callback($mail_pattern, 'break_email', $str);
	return $str;
}
function replaceMailTo($str)
{
	$mail_pattern = '`\<a([^>]+)href\=\"mailto\:([^">]+)\"([^>]*)\>(.*?)\<\/a\>`ism';
	$str = preg_replace_callback($mail_pattern, 'break_mailto', $str);
	return $str;
}
function sanitizeEmail($str)
{
	$str = replaceMailTo($str);
	$str = replaceEmail($str);
	return $str;
}
if (!function_exists('show_text')) {
	function show_text($string, $limit = 200)
	{
		$string = strip_tags($string);
		if (strlen($string) > $limit) {
			$stringCut = substr($string, 0, $limit);
			$string = substr($stringCut, 0, strrpos($stringCut, ' ')) . '...';
		}
		return $string;
	}
}
if (!function_exists('cp')) {
	function cp($text = '', $no = '')
	{
		if (is_array($text) || is_object($text)) {
			echo '<pre>';
			print_r($text);
			echo '</pre>';
		} else {
			if ($text == 'fix_working') {
				echo '<h2>This page is under construction.</h2>';
				exit;
			}
			if ($text == 'fix_error') {
				echo '<h2>ERROR: Sorry there is something wrong.</h2>';
				exit;
			}
			if ($text == '_sepr') {
				echo '<br/>========================</br/>';
			} else {
				echo '<span style="color:red;"><strong>HERE: ' . $no . '::=>::</strong></span>' . $text;
			}
		}
		if ($no == '') {
			exit;
		} else {
			echo '<br/>';
		}
	}
}
function selectVal($val, $selectedV)
{
	$vv = 'value="' . $val . '"';
	if ($val == $selectedV) {
		$vv .= ' selected';
	}
	return $vv;
}
function childCategories($id)
{
	$childCategoryObj = Category::where('cat', $id)->get();
	return $childCategoryObj;
}
function dev_ips()
{
	$devIpsStr = getMetaKeyValue('development_ips');
	$ipArr = explode(',', $devIpsStr);
	if (in_array($_SERVER['REMOTE_ADDR'], $ipArr)) {
		return true;
	}
	return false;
}
function package_use_member($id)
{
	$sm = ClientPackages::where('sts', 1)->where('package_id', $id)->get();
	$total = count($sm);
	return $total;
}
function client_package($id, $response)
{
	if ($response == 'all') {
		$packages = ClientPackages::with('clientPackage')->where('client_id', $id)->groupBy('package_id')->get();
	} else {
		$packages = ClientPackages::with('clientPackage')->where('client_id', $id)->where('package_id', $response)->groupBy('package_id')->get();
	}
	$html = '';
	$i = 1;
	foreach ($packages as $package) {
		$html .= '<div>' . $i . '= ' . $package->clientPackage['heading'] . '</div>';
		++$i;
	}
	return $html;
}
function goals($id)
{
	$sm = Goals::where('goals_id', $id)->first();
	$res = '';
	if (!empty($sm)) {
		$goals = json_decode($sm['goals_values']);
		foreach ($goals as $goal) {
			$res .= '<tr style="display:block;"><td style="display:block;">' . $goal . '</td></tr>';
		}
	}
	return $res;
}
function phoneForAnchor($num)
{
	return str_replace([' ', '+', '-'], '', $num);
}
function getFormatedDate($date, $explodeOn = '-')
{
	$dateArray = explode($explodeOn, $date);
	$newDate = $dateArray[2] . '-' . $dateArray[0] . '-' . $dateArray[1];
	return $newDate;
}
function fmtDate($date, $formate = 'm-d-Y')
{
	if (null !== $date) {
		return date($formate, strtotime($date));
	} else {
		return date($formate);
	}
}
function getProfileImage()
{
	$user = auth()->user();
	return getUserImage($user);
}
function getProfileAddress()
{
	$address_line_1 = auth()->user()->address_line_1;
	$address_line_2 = auth()->user()->address_line_2;
	$zipcode = auth()->user()->zipcode;
	$city = auth()->user()->city;
	$state = auth()->user()->state;
	$country = auth()->user()->country;
	$address_line_2 = (!empty($address_line_2)) ? ', ' . $address_line_2 : '';
	$zipcode = (!empty($zipcode)) ? ', ' . $zipcode : '';
	$city = (!empty($city)) ? ', ' . $city : '';
	$state = (!empty($state)) ? ', ' . $state : '';
	$country = (!empty($country)) ? ', ' . $country : '';
	$address = $address_line_1 . $address_line_2 . $zipcode . $city . $state . $country;
	if (!empty($address) && !is_null($address)) {
		return '<p><i class="fas fa-map-marker-alt"></i>' . $address . '</p>';
	} else {
		return '';
	}
}
function fmtNum($amount)
{
	return number_format((float) $amount, 2, '.', ',');
}
function generateUrl($url)
{
	if ($ret = parse_url($url)) {
		if (!isset($ret['scheme'])) {
			$url = "http://{$url}";
		}
	}
	return $url;
}
function getMaxUploadSize()
{
	if ((int) session('max_image_size') > 0) {
		return session('max_image_size');
	} else {
		$metaValue = getMetaKeyValue('max_image_size');
		session('max_image_size', $metaValue);
		return $metaValue;
	}
}
function printSqlQuery($builder, $dd = true)
{
	$query = vsprintf(str_replace(['?'], ['\'%s\''], $builder->toSql()), $builder->getBindings());
	if ($dd) {
		dd($query);
	} else {
		echo $query;
	}
}
function adjustUrl($text = '')
{
	$text = preg_replace('/http[A-Za-z0-9_:\/\.-]+\/mlstorage\//i', url('/') . '/mlstorage/', $text, -1, $count);
	//echo $count;
	return $text;
}

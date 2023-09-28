<?php
use App\Models\Back\Setting;
if (!function_exists('get_all_footer_details')) {
	function get_all_footer_details() {
		$data = Setting::all();
		return $data;
	}
}
if (!function_exists('make_phone_format_for_call')) {
	function make_phone_format_for_call($number) {
		$number = preg_replace("/[^a-zA-Z0-9]+/", "", $number);
		return $number;
	}
}
if (!function_exists('is_website_live')) {
	function is_website_live() {
		$whitelist = array('127.0.0.1', '::1');
		if (!in_array($_SERVER['REMOTE_ADDR'], $whitelist)) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}
function makeSlugOfAnyString($text) {
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

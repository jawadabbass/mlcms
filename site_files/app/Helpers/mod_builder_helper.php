<?php
function ModFBuild($fieldArr, $key, $val, $fieldFunc = '', $otherAttr = '')
{ //main Func
	$type = $fieldArr[1];
	$fieldName = $fieldArr[0];
	$fieldID = $fieldFunc . '_' . $key;
	$validationClassArr = array('phone' => 'vv_phone', 'email' => 'vv_email');
	$validationClass = '';
	if (isset($validationClassArr[$type])) {
		$validationClass = ' ' . $validationClassArr[$type];
	}
	if ($type == 'img' || substr($type, 0, 4) == 'img_') {
		$img = '<input type="file" class="form-control" name="' . $key . '" id="' . $key . '" value="' . $val . '" />';
		return $img;
	} else if (stristr($type, 'slide_flag__')) {
		$retData = '';
		$tstArr = explode('__', $type);
		$isChecked = '';
		if ($val == 'Yes') {
			$isChecked = 'checked';
		}
		$retData = '<input type="checkbox" ' . $isChecked . '  data-toggle="toggle_ajax" data-onstyle="success" data-offstyle="danger" data-on="' . $tstArr[1] . '" data-off="' . $tstArr[2] . '"  name="' . $key . '" data-size="mini" id="' . $key . '" onChange="updatePageStatus(this.checked,\'idddd\',\'' . $key . '\')"> ';
		return $retData;
	} else if ($type == 'date') {
		$img = '<input type="' . $type . '" class="form-control date_cal' . $validationClass . '" placeholder="' . $fieldName . '" name="' . $key . '" id="' . $fieldID . '" value="' . htmlspecialchars($val) . '" />';
		return $img;
	} else if ($type == 'date_cal') {
		$img = '<input type="' . $type . '" class="form-control date_cal' . $validationClass . '" placeholder="' . $fieldName . '" name="' . $key . '" id="' . $fieldID . '" value="' . htmlspecialchars(date('m/d/Y h:i A', strtotime($val))) . '" />';
		return $img;
	} else if ($type == 'dd_status_yn') {
		$arrD = myform_fname($type, $fieldName);
		return Arr2Dropdown($key, $arrD, $val, '', '');
	} else if ($type == 'dd_paid_status') {
		$arrD = Mod_site_arr($type, $fieldName);
		return Arr2Dropdown($key, $arrD, $val, '', '');
	} else if ($type == 'sub_level') {
		$arrD = myform_fname($type, $fieldName);
		return Arr2Dropdown($key, $arrD, $val, '', '');
	} else if ($type == 'slide_status_yn') {
		$isChecked = '';
		if ($val == 'Yes') {
			$isChecked = 'checked';
		}
		return '
				 <div class="checkbox checkbox-danger">
				<label class="checkbox-inline">
                        <input type="checkbox" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" name="' . $key . '" id="' . $fieldID . '" data-on="Yes" data-off="No" value="Yes" ' . $isChecked . '>
                             </label></div>';
	} else if ($type == 'slide_status_ai') {
		$isChecked = '';
		if ($val == 'Yes') {
			$isChecked = 'checked';
		}
		return '
				 <div class="checkbox checkbox-danger">
				<label class="checkbox-inline">
                        <input type="checkbox" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" name="' . $key . '" id="' . $fieldID . '" data-on="Active" data-off="Inactive" value="Yes" ' . $isChecked . '>
                             </label></div>';
	} else if ($type == 'dd_status') {
		return drawDropDown($key, 'select * from categories WHERE cat=1 order by orderr asc', 'title', 'title', $val, '', '-Status-');
	} else if ($type == 'timezone') {
		return drawDropDown($key, 'select timezone,timezone_key from ml_timezones WHERE 1', 'timezone', 'timezone_key', $val, '', '-TimeZone-');
	} else if ($type == 'dd_status_order') {
		return drawDropDown($key, 'select * from ml_sa_appointment_status WHERE 1 order by orderr asc', 'id', 'Title', $val, '', '-Status-');
	} else if ($type == 'dd_plan') {
		return drawDropDown($key, 'select * from categories WHERE cat=14 order by orderr asc', 'id', 'title', $val, '', '-Package-');
	} else if ($type == 'type_of_serv') {
		return drawDropDown($key, 'select * from settings_category WHERE cat=1 order by orderr asc', 'title', 'title', $val, '', '-Type of Service-');
	} else if ($type == 'SA_Product') {
		$loc_id = GetDbValue('loc_id', 'ml_loc_categories', "id='" . (int)$val . "'");
		$loc_id = checkLocID($loc_id);
		$dropDownDbValue = 'id';
		$dropDownDbText = 'title';
		$selectValue = $val;
		$tempVar = '<select class="form-control" name="' . $key . '" id="' . $fieldID . '">';
		$tempVar .= '<option value="" selected>-Product-</option>';
		$RSParent = Run('select * from ml_loc_cat_group WHERE loc_id=\'' . $loc_id . '\' order by orderr asc');
		foreach ($RSParent as $kkkk => $val) {
			$tempVar .= '<optgroup label="' . $val->title . '">';
			$RS = Run('select * from ml_loc_categories WHERE cat=\'' . $val->id . '\' order by orderr asc');
			foreach ($RS as $key => $getVal) {
				$tempVar .= '<option value="' . $getVal->$dropDownDbValue . '" ';
				if ($selectValue == $getVal->$dropDownDbValue)
					$tempVar .= 'selected';
				$tempVar .= '>' . $getVal->$dropDownDbText . '</option>';
			}
			$tempVar .= '</optgroup>';
		}
		$tempVar .= '</select>';
		return $tempVar;
	} else if ($type == 'Package_ID') {
		$pkArr = GetDbRowArr('*', 'ml_sa_appointment_packages', "id='" . (int)$val . "'");
		$loc_id = $pkArr['loc_id'];
		$dropDownDbValue = 'id';
		$dropDownDbText = 'title';
		$dropDownDbValue2 = 'id';
		$dropDownDbText2 = 'title';
		$selectValue = $val;
		$tempVar = '<select class="form-control" onchange="change_feet_base(this.value);" name="' . $key . '" id="' . $fieldID . '">';
		$tempVar .= '<option value="" selected>-Package-</option>';
		$RSParent = Run('select * from ml_loc_cat_group WHERE loc_id=\'' . $loc_id . '\' order by orderr asc');
		foreach ($RSParent as $kkkk => $val) {
			$tempVar .= '<optgroup label="' . $val->title . '">';
			$RS = Run('select * from ml_loc_categories WHERE cat=\'' . $val->id . '\' order by orderr asc');
			foreach ($RS as $key => $getVal) {
				$tempVar .= '<optgroup label="-' . $getVal->$dropDownDbText . '">';
				$RS2 = Run('select * from ml_sa_appointment_packages WHERE product_id=\'' . $getVal->id . '\' order by orderr asc');
				foreach ($RS2 as $key2 => $getVal2) {
					$tempVar .= '<option value="' . $getVal2->$dropDownDbValue2 . '" ';
					if ($selectValue == $getVal2->$dropDownDbValue2)
						$tempVar .= 'selected';
					$tempVar .= '>--' . $getVal2->$dropDownDbText2 . '</option>';
				}
			}
			$tempVar .= '</optgroup>';
		}
		$tempVar .= '</select>';
		return $tempVar;
	} else if ($type == 'textarea' || $type == 'editor') {
		$img = '<textarea class="form-control" name="' . $key . '" id="' . $fieldID . '">' . htmlspecialchars(stripslashes($val)) . '</textarea>';
		return $img;
	} else if ($type == 'qty') {
		$img = '<input min="1" type="number" class="form-control' . $validationClass . '" placeholder="' . $fieldName . '" name="' . $key . '" id="' . $fieldID . '" value="' . htmlspecialchars($val) . '" />';
		return $img;
	} else if ($type == 'gmap_zoom') {
		$img = '<input min="0" type="range" max="18" class="form-control' . $validationClass . '" placeholder="' . $fieldName . '" name="' . $key . '" id="' . $key . '" value="' . htmlspecialchars($val) . '" />';
		return $img;
	} else if (stristr($type, 'range__')) {
		$tstArr = explode('__', $type);
		$img = '<div class="input-group"><div class="input-group-prepend">
    <span class="input-group-text"><span id="' . $key . '_info">' . $val . '</span>/' . $tstArr[2] . '</span>
  </div><input min="' . $tstArr[1] . '" type="range" max="' . $tstArr[2] . '" class="form-control' . $validationClass . '" onchange="document.getElementById(\'' . $key . '_info\').innerHTML=this.value" placeholder="' . $fieldName . '" name="' . $key . '" id="' . $key . '" value="' . htmlspecialchars($val) . '" /></div>';
		return $img;
	} else if ($type == 'dd_loc') {
		return drawDropDown($key, 'select * from ml_locations WHERE 1', 'id', 'loc_name', $val, '', '-Location-');
	} else if ($type == 'dd_state') {
		$img = myform_state_dd($val, $key);
		return $img;
	} else if (substr($type, 0, 3) == 'dd_') { //General Dropdown
		$arrD = myform_fname($type, $fieldName);
		return Arr2Dropdown($key, $arrD, $val, '', '');
	} else if (substr($type, 0, 4) == 'dyn_') { //General Dropdown
		$arrD = Mod_site_Dynmic($type);
		//$arrD=myform_fname($type,$fieldName);
		return Arr2Dropdown($key, $arrD, $val, '', '');
	} else if ($type == 'cb') {
		$checkedOrNOt = '';
		if ($val == 'Yes') {
			$checkedOrNOt = 'checked';
		}
		$img = '<input ' . $checkedOrNOt . ' class="form-control"  type="checkbox" name="' . $key . '" id="' . $key . '" placeholder="Yes" />';
		return $img;
	} else if ($type == 'price') {
		$img = myform_currency_f_wrap('<input type="' . $type . '" class="form-control' . $validationClass . '" placeholder="' . $fieldName . '" name="' . $key . '" id="' . $key . '" value="' . htmlspecialchars($val) . '" />', '$');
		return $img;
	} else if ($type == '') {
		$type = 'text';
	}
	$img = '<input type="' . $type . '" class="form-control' . $validationClass . '" placeholder="' . $fieldName . '" name="' . $key . '" id="' . $fieldID . '" value="' . htmlspecialchars($val) . '" />';
	return $img;
} //end ModFBuild
//Post to Query Array			
function ModBuildPostData($dataArr)
{
	$dataArrInsert = array();
	$autoArr = array();
	if (isset($dataArr['auto'])) {
		$autoArr = $dataArr['auto'];
		unset($dataArr['auto']);
	}
	$CI = &get_instance();
	foreach ($dataArr as $key => $val) {
		if ($val[1] == 'cb' || $val[1] == 'dd_status_yn') {
			if (isset($_POST[$key])) {
				if ($_POST[$key] == 'No') {
					$dataArrInsert[$key] = 'No';
				} else {
					$dataArrInsert[$key] = 'Yes';
				}
			} else {
				$dataArrInsert[$key] = 'No';
			}
		} else {
			if (in_array($val[1], array('img'))) {
			} else if (substr($val[1], 0, 4) == 'img_') {
				$imgSettingArr = explode('__', $val[1]);
				$upload_dir_name = $imgSettingArr[3]; //directory
				$field_name = $key;
				$thumb_width = $imgSettingArr[1];
				$thumb_height = ($imgSettingArr[2] > 0) ? $imgSettingArr[2] : '';
				$extensions = array('jpg', 'jpeg', 'png');
				$data_upload = array(
					'file_field_name' => $field_name,
					'files' => $_FILES,
					'upload_dir' => storage_uploads($upload_dir_name),
					'thumb_width' => $thumb_width,
					'thumb_height' => $thumb_height,
					'max_size' => MAX_IMAGE_SIZE, // 5MB
					'extensions' => $extensions
				);
				$data = upload_file_helper($data_upload);
				$dataArrInsert[$key] = $data['file_name'];
			} else {
				$dataArrInsert[$key] = $CI->input->post($key);
			}
		}
	}
	if (!empty($autoArr)) {
		foreach ($autoArr as $key => $val) {
			$dataArrInsert[$key] = ModAutoFValue($val[1], $val[2]);
		}
	}
	return $dataArrInsert;
}
//Auto Add/update Case
function ModAutoFValue($keyy, $def = '')
{
	if ($keyy == 'date') {
		return date('Y-m-d');
	} else if ($keyy == 'datetime') {
		return date('Y-m-d H:i:s');
	} else if ($keyy == 'ip') {
		return $_SERVER['REMOTE_ADDR'];
	} else if ($keyy == 'def') {
		if (substr($def, 0, 6) == 'post__') {
			$CI = &get_instance();
			$postName = str_replace('post__', '', $def);
			return $CI->input->post($postName);
		} else if (substr($def, 0, 9) == 'session__') {
			$CI = &get_instance();
			$sessName = str_replace('session__', '', $def);
			return $CI->session->userdata($sessName);
		} else {
			return $def;
		}
	} else {
		return '';
	}
}
//Field Format .... on Listing Page.
function ModTBuild($txt, $format = '', $baseImg = '')
{
	if ($txt == '') return '-';
	if ($format == '')
		return stripslashes($txt);
	else if ($format == 'date' || $format == 'cdate' || $format == 'date_only') {
		return format_date($txt, 'M. d, Y'); //'M. d, Y'
	} else if ($format == 'datetime')
		return format_date($txt);
	else if (stristr($format, 'slide_flag__')) {
		$tstArr = explode('__', $format);
		if ($txt == 'Yes') {
			return '<div class="text text-success">' . $tstArr[1] . '</div>';
		}
		if ($txt == 'No') {
			return $tstArr[2];
		}
	} else if ($format == 'date_web') {
		return format_date($txt, 'l F d, Y \a\t h:i A');
	} else if ($format == 'price')
		return '$' . $txt;
	else if ($format == 'code')
		return '<code>' . $txt . '</code>';
	else if ($format == 'price_code')
		return '<code>$' . $txt . '</code>';
	else if ($format == 'link')
		return '<a target="_blank" href="' . $txt . '">' . $txt . '</a>';
	else if ($format == 'mailto')
		return '<a href="mailto:' . $txt . '">' . $txt . '</a>';
	else if ($format == 'link_site')
		return '<a target="_blank" href="' . base_url() . $baseImg . $txt . '">' . base_url() . $baseImg . $txt . '</a>';
	else if ($format == 'state')
		return myform_state($txt);
	else if ($format == 'plan')
		return myform_plan($txt);
	else if ($format == 'img')
		return '<img src="' . base_url() . $baseImg . $txt . '" >';
	else if ($format == 'img_round')
		return '<img src="' . base_url() . $baseImg . $txt . '" class="img-circle" >';
	else if ($format == 'img_pop')
		return '<img style="cursor:pointer;" onclick="displayImage(\'' . asset_uploads('gallery/' . $txt) . '\');" src="' . base_url() . $baseImg . $txt . '" width="100" >';
	else if ($format == 'img_new')
		return '<img src="' . base_url() . $baseImg . 'small/' . $txt . '?abc=' . rand() . '" width="100" >';
	else if ($format == 'img_new2')
		return '<img src="' . base_url() . $baseImg . 'icon/small/' . $txt . '?abc=' . rand() . '" width="100" >';
	else if ($format == 'tick_cross') {
		return ($txt == 'Yes') ? '<i class="fas fa-check text-success" aria-hidden="true"></i>' : '<i class="fas fa-times text-danger" aria-hidden="true"></i>';
	} else if ($format == 'dd_status_order')
		return GetDbValue('Title', 'ml_sa_appointment_status', "id='" . $txt . "'");
	else if ($format == 'e-msg')
		return myform_msg($txt, 'e', false);
	else if ($format == 's-msg')
		return myform_msg($txt, 's', false);
	else if ($format == 'w-msg')
		return myform_msg($txt, 'w', false);
	else if ($format == 'sub_level') {
		if ($txt == '1') {
			return 'Website Manager';
		} else if ($txt == '2') {
			return 'Content Manager';
		} else {
			return 'Not Defined';
		}
	} else if ($format == 'loc_name' || $format == 'dd_loc')
		return GetDbValue('loc_name', 'ml_locations', "id='" . (int)$txt . "'");
	else if ($format == 'dd_paid_status') {
		$txtArr = Mod_site_arr($format);
		if (isset($txtArr[$txt])) {
			if ($txt == 'Yes') {
				return '<span class="text-success"><strong><i class="fas fa-check" aria-hidden="true"></i> ' . $txtArr[$txt] . '</strong><span>';
			} else {
				return '<span class="text-danger">' . $txtArr[$txt] . '<span> <i class="fas fa-times" aria-hidden="true"></i>';
			}
		} else {
			return $txt;
		}
	} else if ($format == 'gmap_zoom')
		return '<meter min="0" max="18" value="' . $txt . '">' . $txt . '</meter>';
	else if ($format == 'video') {
		$retV = youtube_link_to_iframe($txt, '200', '200');
		if ($retV == $txt && stristr($txt, '.mp4')) {
			$retV = '<video controls="" width="200" height="200"><source src="' . asset_uploads('video/' . $txt) . '" type="video/mp4">
	  <source src="movie.ogg" type="video/ogg">Your browser does not support the video tag.</video>';
		}
		return $retV;
	} else
		return stripslashes($txt);
}
//BreadCrumbs
function ModBC($heading, $parentArr = array())
{
	$tmpStr = '';
	$tmpStr .= '<ol class="breadcrumb"><li><a href="' . admin_url('dashboard') . '"><i class="fas fa-tachometer-alt"></i> Home</a>
									</li>';
	if (!empty($parentArr)) {
		foreach ($parentArr as $key => $val) {
			$tmpStr .= '<li><a href="' . admin_url() . $key . '">' . $val . '</a></li>';
		}
	}
	$tmpStr .= '<li class="active">' . $heading . '</li></ol>';
	return $tmpStr;
}
function Mod_f($fType, $key, $label, $defaultValue = '', $validate = 'trim', $fieldFunc = '', $otherAttr = '')
{
	$fieldArr = array($label, $fType, $validate);
	return ModFBuild($fieldArr, $key, $defaultValue, $fieldFunc, $otherAttr);
}
//Create Textbox HTML
function Mod_tb($key, $label, $defaultValue = '', $validate = 'trim', $fieldFunc = '', $otherAttr = '')
{
	$fieldArr = array($label, 'text', $validate);
	return ModFBuild($fieldArr, $key, $defaultValue, $fieldFunc, $otherAttr);
}
//Create Textarea HTML
function Mod_ta($key, $label, $validate = 'trim', $defaultValue = '', $fieldFunc = '', $otherAttr = '')
{
	$fieldArr = array($label, 'textarea', $validate);
	return ModFBuild($fieldArr, $key, $defaultValue, $fieldFunc, $otherAttr);
}
//Create Auto Complete
function Mod_list($id, $type)
{ //Textbox autcomplete
	if ($type == 'city') {
		$arr = Q2Arr('cities', 'city', 'city', "countryid=187");
		return Mod_arr_list($id, $arr);
	} else if ($type == 'caste') {
		$arr = Q2Arr('categories', 'title', 'title', "cat=8");
		return Mod_arr_list($id, $arr);
	}
}
//Auto Complete HTML Build
function Mod_arr_list($id, $arr)
{
	$str = '<datalist id="' . $id . '">';
	foreach ($arr as $key => $val) {
		$str .= '<option value="' . $val . '">';
	}
	$str .= '</datalist>';
	return $str;
}
//This will change Site wide
function Mod_site_arr($type, $selectText = '')
{
	$arr = array(
		'dd_user_access_level' => array('0' => 'Everyone', '1' => 'Allowed Users', '2' => 'None'),
		'dd_gender' => array('Male' => 'Male', 'Female' => 'Female'),
		'dd_paid_status' => array('' => '-Payment Status-', 'Yes' => 'Paid', 'No' => 'Payment not confirmed yet'),
		'dd_othernationality' => array(
			'' => '-None-',
			'US Citizen' => 'US Citizen',
			'British Citizen' => 'British Citizen',
			'European Citizen' => 'European Citizen',
			'Middle East Citizen' => 'Middle East Citizen',
			'African Citizen' => 'African Citizen',
			'Australian Citizen' => 'Australian Citizen',
			'New Zealand Citizen' => 'New Zealand Citizen',
			'Afghan Citizen' => 'Afghan Citizen',
			'Russia Citizen' => 'Russia Citizen'
		),
	);
	//if($type=='dd_serv'){return Q2Arr('ml_loc_services_templates','loc_sid','title','1');}
	if (!isset($arr[$type])) {
		echo error_show($type . 'create Array for "mod/Mod_site_arr"');
		exit;
	}
	return $arr[$type];
}
function Mod_site_Dynmic($type)
{
	if ($type == 'dyn_admin_users') {
		return Q2Arr('dve_admin', 'id', 'admin_name', "1", '-User-');
	} else {
		echo 'Dynmic Value not set mod file';
		exit;
	}
}
//Create Add/Edit Array for auto add/edit.
function Mod_create_process_arr($row, $default_val = 'trim')
{
	foreach ($row as $key => $val) {
		echo "'" . $key . "'=>array('" . Mod_auto_name_to_Key($key) . "','text','" . $default_val . "'),";
		echo '<br/>';
	}
}
//Auto Field name with DB key(id)
function Mod_auto_name_to_Key($key)
{
	$arrCommaon = array(
		'fname' => 'First Name',
		'lname' => 'Last Name',
		'id' => 'id',
		'ip' => 'IP',
		'pass' => 'Password',
		'userid' => 'id'
	);
	if (isset($arrCommaon[$key])) {
		return $arrCommaon[$key];
	} else {
		return ucwords(str_replace('_', ' ', strtolower($key)));
	}
}
// validation step 1
function Mod_convert_validation_arr($arr)
{
	$validationArr = array(
		array(),
		array()
	);
	$tmpArr1 = array();
	$tmpArr2 = array();
	foreach ($arr as $key => $value) {
		if ($value[2] != 'op') {
			if ($value[2] == '' && $value[1] != 'cb' && stristr($value[1], 'slide_flag__') == false) {
				$tmpArr1[$key] = 'required';
			} else {
				$tmpArr1[$key] = $value[2];
			}
			$tmpArr2[$key . '.required'] = $value[0] . ' field is required.';
		}
	}
	return array($tmpArr1, $tmpArr2);
}
// validation step 2 *** insert in db
function Mod_convert_db_value($request, $kk, $vv)
{
	if ($vv[1] == 'cb' || stristr($vv[1], 'slide_flag__')) {
		if ($request->has($kk)) {
			return 'Yes';
		} {
			return 'No';
		}
	} else {
		return $request->$kk;
	}
}
//Image upload code
function upload_file_helper($data_upload)
{
	$CI = &get_instance();
	if ($data_upload['files']) {
		$_FILES[$data_upload['file_field_name']]['name'] = $data_upload['files'][$data_upload['file_field_name']]['name'];
		$_FILES[$data_upload['file_field_name']]['type'] = $data_upload['files'][$data_upload['file_field_name']]['type'];
		$_FILES[$data_upload['file_field_name']]['tmp_name'] = $data_upload['files'][$data_upload['file_field_name']]['tmp_name'];
		$_FILES[$data_upload['file_field_name']]['error'] = $data_upload['files'][$data_upload['file_field_name']]['error'];
		$_FILES[$data_upload['file_field_name']]['size'] = $data_upload['files'][$data_upload['file_field_name']]['size'];
		$upload_dir = $data_upload['upload_dir'];
		if (!is_dir($upload_dir)) {
			mkdir($upload_dir);
		}
		chmod($upload_dir, 0777);
		$config['upload_path']   = $upload_dir;
		$config['allowed_types'] = (is_array($data_upload['extensions'])) ? implode('|', $data_upload['extensions']) : 'gif|jpg|png|jpeg';
		$config['file_name']     = 'userimage_' . substr(md5(rand()), 0, 7);
		$config['overwrite']     = false;
		$config['max_size']	 =  $data_upload['max_size'];
		$CI->load->library(array('upload', 'image_lib'));
		$CI->upload->initialize($config);
		if (!$CI->upload->do_upload($data_upload['file_field_name'])) {
			$upload_data['error'] = 'Yes';
			$upload_data['msg'] = $CI->upload->display_errors();
			return $upload_data;
		} else {
			$upload_data = $CI->upload->data();
			chmod($upload_dir . '/thumb/', 0777);
			$thumb_config['image_library'] = 'gd2';
			$thumb_config['source_image']	= $upload_dir . '/' . $upload_data['file_name'];
			$thumb_config['new_image']	= $upload_dir . '/thumb/' . $upload_data['file_name'];
			$thumb_config['width']	 = $data_upload['thumb_width'];
			if ($data_upload['thumb_height'] != '') {
				$thumb_config['height']	 = $data_upload['thumb_height'];
				$thumb_config['maintain_ratio'] = FALSE;
			} else {
				$thumb_config['maintain_ratio'] = TRUE;
			}
			$CI->image_lib->clear();
			$CI->image_lib->initialize($thumb_config);
			$CI->image_lib->resize();
			$upload_data['error'] = 'No';
			return $upload_data;
		}
	}
}
function viewtxt($keyy, $searchDataArr)
{
	if (isset($searchDataArr[$keyy]) && $searchDataArr[$keyy] != '') {
		return stripslashes($searchDataArr[$keyy]);
	}
	return '';
}
function filter_search_param($get, $searchArr)
{
	$retArr = [];
	foreach ($searchArr as $key => $value) {
		if (isset($get[$key]) && $get[$key] != '') {
			$retArr[$key] = $get[$key];
		}
	}
	return $retArr;
}

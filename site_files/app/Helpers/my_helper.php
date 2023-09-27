<?php

use App\Helpers\ImageUploader;
use App\Models\Back\City;
use App\Models\Back\CmsModule;
use App\Models\Back\CmsModuleData;
use App\Models\Back\Country;
use App\Models\Back\County;
use App\Models\Back\FleetCategory;
use App\Models\Back\Metadata;
use App\Models\Back\ModuleDataImage;
use App\Models\Back\State;

function getMetaData()
{
    $metaDatas = Metadata::get();
    $metaArray = new stdClass();
    foreach ($metaDatas as $metaData) {
        $key = $metaData->data_key;
        $value = $metaData->val1;
        $metaArray->$key = $value;
    }

    return $metaArray;
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

function getModuleDataByType($moduleType, $limit = 20, $start = 0, $orderBy = 'item_order', $ascDesc = 'asc')
{
    $module = CmsModule::where('type', $moduleType)->first();

    return getModuleData($module->id, $limit, $start, $orderBy, $ascDesc);
}

function getModuleData($moduleId, $limit = 20, $start = 0, $orderBy = 'item_order', $ascDesc = 'asc')
{
    $data = \App\Models\Back\CmsModuleData::where('sts', 'active')
        ->where('cms_module_id', $moduleId)
        ->where('sts', 'active');

    $data->orderBy($orderBy, $ascDesc);
    $data->limit($limit, $start);

    return $data->get();
}

function getProfileImage()
{
    $user = auth()->user();

    return getUserImage($user);
}

function getUserImage($user)
{
    $profileImage = $user->profile_image;

    return ImageUploader::print_image_src($profileImage, 'profile_images', 'storage/front/images/no-image.jpg');
}

function getImage($folder, $image, $defaultSize = 'main')
{
    if ($defaultSize == 'main') {
        $defaultSize = '';
    } else {
        $defaultSize = '/' . $defaultSize;
    }

    return ImageUploader::print_image_src($image, $folder . $defaultSize, 'storage/front/images/no-image-available.png');
}

function storage_path_to_uploads($path)
{
    return ImageUploader::real_public_path() . $path;
}

function storage_path_to_public($path)
{
    return ImageUploader::storage_path_to_public() . $path;
}

function public_path_to_uploads($path)
{
    return ImageUploader::public_path() . $path;
}

function public_path_to_storage($path)
{
    return ImageUploader::public_path_to_storage() . $path;
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

function generateGenderDropDown($defaultSelected = '', $empty = true)
{
    $str = ($empty) ? '<option value="">Select...</option>' : '';
    $genderArray = ['Male' => 'Male', 'Female' => 'Female'];
    foreach ($genderArray as $key => $value) {
        $selected = ($key == $defaultSelected) ? 'selected="selected"' : '';
        $str .= '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
    }

    return $str;
}

function generateStatusDropDown($defaultSelected = '', $empty = true)
{
    $str = ($empty) ? '<option value="">Select...</option>' : '';
    $genderArray = ['active' => 'Active', 'blocked' => 'Blocked'];
    foreach ($genderArray as $key => $value) {
        $selected = ($key == $defaultSelected) ? 'selected="selected"' : '';
        $str .= '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
    }

    return $str;
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

function generateCountriesDropDown($defaultSelected = 0, $empty = true)
{
    $str = ($empty) ? '<option value="">Select...</option>' : '';
    $countryArray = Country::select('name', 'id')->active()->sorted()->pluck('name', 'id')->toArray();
    foreach ($countryArray as $key => $value) {
        $selected = ($key == $defaultSelected) ? 'selected="selected"' : '';
        $str .= '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
    }

    return $str;
}

function generateStatesDropDown($defaultSelected = 0, $empty = true)
{
    $str = ($empty) ? '<option value="">Select...</option>' : '';
    $stateArray = State::select('state_name', 'id')->active()->sorted()->pluck('state_name', 'id')->toArray();
    foreach ($stateArray as $key => $value) {
        $selected = ($key == $defaultSelected) ? 'selected="selected"' : '';
        $str .= '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
    }

    return $str;
}

function generateCountiesDropDown($defaultSelected = 0, $state_id = 0, $empty = true)
{
    $str = ($empty) ? '<option value="">Select...</option>' : '';
    $query = County::select('county_name', 'id');
    $query->where('state_id', $state_id);
    $countyArray = $query->active()->sorted()->pluck('county_name', 'id')->toArray();
    foreach ($countyArray as $key => $value) {
        $selected = ($key == $defaultSelected) ? 'selected="selected"' : '';
        $str .= '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
    }

    return $str;
}

function generateCitiesDropDown($defaultSelected = 0, $state_id = 0, $empty = true)
{
    $str = ($empty) ? '<option value="">Select...</option>' : '';
    $query = City::select('city_name', 'id');
    $query->where('state_id', $state_id);
    $cityArray = $query->active()->sorted()->pluck('city_name', 'id')->toArray();
    foreach ($cityArray as $key => $value) {
        $selected = ($key == $defaultSelected) ? 'selected="selected"' : '';
        $str .= '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
    }

    return $str;
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

function getMetaKeyValue($key)
{
    $metaDataObj = Metadata::Where('data_key', 'like', $key)->first();

    return $metaDataObj->val1;
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

function hasError($errors, $field)
{
    return ($errors->first($field) != '') ? 'is-invalid msg_cls_for_focus' : '';
}

function showErrors($errors, $field)
{
    $html = '';
    if ($errors->first($field) != '') {
        foreach ($errors->get($field) as $message) {
            $html .= '<span class="invalid-feedback" role="alert"><strong>' . $message . '</strong></span>';
        }
    }

    return $html;
}

function showErrorsNotice($errors)
{
    $html = '';
    if (count($errors) > 0) {
        $html .= '<div class="alert alert-danger">You have some form errors. Please check below.<ul>';
        foreach ($errors->all() as $message) {
            $html .= '<li><span class="invalid-feedback" role="alert"><strong>' . $message . '</strong></span></li>';
        }
        $html .= '</ul></div>';
    }

    return $html;
}

function showOnlyErrorsNotice($errors)
{
    $html = '';
    if (count($errors) > 0) {
        $html = '<div class="alert alert-danger">You have some form errors. Please check below.</div>';
    }

    return $html;
}

function generateModuleDataImageHtml($folder, $image)
{
    $html = '<div class="col-md-4" id="more_image_' . $image->id . '">
                    <div class="mb-3">
                        <div class="imagebox">
                            <a href="javascript:void(0);" title="' . $image->image_title . '"
                                onclick="openModuleDataImageZoomModal(\'' . public_path_to_uploads($folder . '/' . $image->image_name . '?' . time()) . '\');">
                                <img id="image_' . $image->id . '"
                                    data-imgname="' . $image->image_name . '"
                                    src="' . public_path_to_uploads($folder . '/thumb/' . $image->image_name . '?' . time()) . '"
                                    style="width:100%" alt="' . $image->image_alt . '"
                                    title="' . $image->image_title . '">
                            </a>
                        </div>
                        <div class="image_btn mt-2">
                            <a title="Delete Image"
                                onclick="deleteModuleDataImage(' . $image->id . ', \'' . $image->image_name . '\');"
                                class="mb-1 btn btn-danger" data-bs-toggle="tooltip"
                                data-placement="left" title="Delete this image"
                                href="javascript:;"> <i class="fas fa-trash"></i></a>
                            <a title="Crop Image"
                                onClick="bind_cropper_preview_module_data_image(' . $image->id . ');"
                                href="javascript:void(0)" class="mb-1 btn btn-warning"><i
                                    class="fas fa-crop" aria-hidden="true"></i></a>
                            <a title="Image Alt/Title"
                                onClick="openModuleDataImageAltTitleModal(' . $image->id . ');"
                                href="javascript:void(0)" class="mb-1 btn btn-success"><i
                                    class="fas fa-bars" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>';

    return $html;
}

function getCmsModuleDataImagesById($module_data_id)
{
    $images = ModuleDataImage::where('module_data_id', $module_data_id)->get();
    return getCmsModuleDataImages($images);
}

function getCmsModuleDataImagesBySlug($post_slug)
{
    $moduleData = CmsModuleData::where('post_slug', 'like', $post_slug)->first();
    $images = ModuleDataImage::where('module_data_id', $moduleData->id)->get();
    return getCmsModuleDataImages($images);
}

function getCmsModuleDataImages($images)
{
    $imagesArray = [];
    if (count($images) > 0) {
        foreach ($images as $image) {
            $thumb = public_path_to_uploads('module/' . $image->module_type . '/thumb/' . $image->image_name);
            $main = public_path_to_uploads('module/' . $image->module_type . '/' . $image->image_name);
            $imagesArray[] = (object)['thumb' => $thumb, 'main' => $main, 'image_alt' => $image->image_alt, 'image_title' => $image->image_title ];
        }
    }
    return $imagesArray;
}

function generateFleetCategoriesStatusDropDown($defaultSelected = '', $empty = true)
{
    $str = ($empty) ? '<option value="">Select...</option>' : '';
    $statusArray = ['Active' => 'Active', 'Inactive' => 'Inactive'];
    foreach ($statusArray as $key => $value) {
        $selected = ($key == $defaultSelected) ? 'selected="selected"' : '';
        $str .= '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
    }

    return $str;
}

function generatePassengerCapacitiesStatusDropDown($defaultSelected = '', $empty = true)
{
    $str = ($empty) ? '<option value="">Select...</option>' : '';
    $statusArray = ['Active' => 'Active', 'Inactive' => 'Inactive'];
    foreach ($statusArray as $key => $value) {
        $selected = ($key == $defaultSelected) ? 'selected="selected"' : '';
        $str .= '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
    }

    return $str;
}

function generateCabinDimensionsStatusDropDown($defaultSelected = '', $empty = true)
{
    $str = ($empty) ? '<option value="">Select...</option>' : '';
    $statusArray = ['Active' => 'Active', 'Inactive' => 'Inactive'];
    foreach ($statusArray as $key => $value) {
        $selected = ($key == $defaultSelected) ? 'selected="selected"' : '';
        $str .= '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
    }

    return $str;
}

function generateBaggageCapacitiesStatusDropDown($defaultSelected = '', $empty = true)
{
    $str = ($empty) ? '<option value="">Select...</option>' : '';
    $statusArray = ['Active' => 'Active', 'Inactive' => 'Inactive'];
    foreach ($statusArray as $key => $value) {
        $selected = ($key == $defaultSelected) ? 'selected="selected"' : '';
        $str .= '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
    }

    return $str;
}

function generatePerformancesStatusDropDown($defaultSelected = '', $empty = true)
{
    $str = ($empty) ? '<option value="">Select...</option>' : '';
    $statusArray = ['Active' => 'Active', 'Inactive' => 'Inactive'];
    foreach ($statusArray as $key => $value) {
        $selected = ($key == $defaultSelected) ? 'selected="selected"' : '';
        $str .= '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
    }

    return $str;
}

function generateCabinAmenitiesStatusDropDown($defaultSelected = '', $empty = true)
{
    $str = ($empty) ? '<option value="">Select...</option>' : '';
    $statusArray = ['Active' => 'Active', 'Inactive' => 'Inactive'];
    foreach ($statusArray as $key => $value) {
        $selected = ($key == $defaultSelected) ? 'selected="selected"' : '';
        $str .= '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
    }

    return $str;
}

function generateSafetiesStatusDropDown($defaultSelected = '', $empty = true)
{
    $str = ($empty) ? '<option value="">Select...</option>' : '';
    $statusArray = ['Active' => 'Active', 'Inactive' => 'Inactive'];
    foreach ($statusArray as $key => $value) {
        $selected = ($key == $defaultSelected) ? 'selected="selected"' : '';
        $str .= '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
    }

    return $str;
}

function generateFleetCategoriesDropDown($defaultSelected = 0, $empty = true)
{
    $str = ($empty) ? '<option value="">Select...</option>' : '';
    $categoryArray = FleetCategory::select('title', 'id')->active()->sorted()->pluck('title', 'id')->toArray();
    foreach ($categoryArray as $key => $value) {
        $selected = ($key == $defaultSelected) ? 'selected="selected"' : '';
        $str .= '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
    }

    return $str;
}

function generateFleetPlaneStatusDropDown($defaultSelected = '', $empty = true)
{
    $str = ($empty) ? '<option value="">Select...</option>' : '';
    $statusArray = ['Active' => 'Active', 'Inactive' => 'Inactive'];
    foreach ($statusArray as $key => $value) {
        $selected = ($key == $defaultSelected) ? 'selected="selected"' : '';
        $str .= '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
    }

    return $str;
}

function generateNewsStatusDropDown($defaultSelected = '', $empty = true)
{
    $str = ($empty) ? '<option value="">Select...</option>' : '';
    $statusArray = ['Active' => 'Active', 'Inactive' => 'Inactive'];
    foreach ($statusArray as $key => $value) {
        $selected = ($key == $defaultSelected) ? 'selected="selected"' : '';
        $str .= '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
    }

    return $str;
}

function generateNewsHasRegistrationLinkDropDown($defaultSelected = '', $empty = true)
{
    $str = ($empty) ? '<option value="">Select...</option>' : '';
    $statusArray = ['1' => 'Yes', '0' => 'No'];
    foreach ($statusArray as $key => $value) {
        $selected = ($key == $defaultSelected) ? 'selected="selected"' : '';
        $str .= '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
    }

    return $str;
}

function generateNewsIsThirdPartyLinkDropDown($defaultSelected = '', $empty = true)
{
    $str = ($empty) ? '<option value="">Select...</option>' : '';
    $statusArray = ['1' => 'Yes', '0' => 'No'];
    foreach ($statusArray as $key => $value) {
        $selected = ($key == $defaultSelected) ? 'selected="selected"' : '';
        $str .= '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
    }

    return $str;
}

function generateNewsIsFeaturedDropDown($defaultSelected = '', $empty = true)
{
    $str = ($empty) ? '<option value="">Select...</option>' : '';
    $statusArray = ['1' => 'Yes', '0' => 'No'];
    foreach ($statusArray as $key => $value) {
        $selected = ($key == $defaultSelected) ? 'selected="selected"' : '';
        $str .= '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
    }

    return $str;
}
function generateIsHideEventAfterDateDropDown($defaultSelected = '', $empty = true)
{
    $str = ($empty) ? '<option value="">Select...</option>' : '';
    $statusArray = ['1' => 'Yes', '0' => 'No'];
    foreach ($statusArray as $key => $value) {
        $selected = ($key == $defaultSelected) ? 'selected="selected"' : '';
        $str .= '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
    }

    return $str;
}

function generateModuleCodeFieldLabel($field_counter, $errors, $oldData, $hide_show)
{
    $field_counter_minus_1 = $field_counter - 1;
    $field_name = (isset($oldData['field_name'][$field_counter_minus_1])) ? $oldData['field_name'][$field_counter_minus_1] : '';
    $field_label = (isset($oldData['field_label'][$field_counter_minus_1])) ? $oldData['field_label'][$field_counter_minus_1] : '';
    return '
        <div class="row">
            <div class="col-md-5 mb-1 field_' . $field_counter . '">
                <label class="form-label">Field Name:*</label>
                <input name="field_name[]" value="' . $field_name . '"
                    type="text"
                    class="form-control ' . hasError($errors, "field_name.$field_counter_minus_1") . '"
                    placeholder="student_name">
                ' . showErrors($errors, "field_name.$field_counter_minus_1") . '
            </div>
            <div class="col-md-5 mb-1 field_' . $field_counter . '">
                <label class="form-label">Field Label:*</label>
                <input name="field_label[]" value="' . $field_label . '"
                    type="text"
                    class="form-control ' . hasError($errors, "field_label.$field_counter_minus_1") . '"
                    placeholder="Student Name">
                ' . showErrors($errors, "field_label.$field_counter_minus_1") . '
            </div>
            <div class="col-md-2 mb-1 field_' . $field_counter . ' ' . $hide_show . '">
                <label class="form-label">&nbsp;</label><br/>
                <button type="button" class="btn btn-danger" onclick="removeField(' . $field_counter . ');">Remove</button>
            </div>
        </div>';
}

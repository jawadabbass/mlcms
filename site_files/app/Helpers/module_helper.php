<?php

use App\Models\Back\CmsModule;
use App\Models\Back\ModuleVideo;
use App\Models\Back\CmsModuleData;
use App\Models\Back\ModuleDataImage;

function getModuleDataByType($moduleType, $limit = 20, $start = 0, $orderBy = 'item_order', $ascDesc = 'asc')
{
    $module = CmsModule::where('type', $moduleType)->first();

    return getModuleData($module->id, $limit, $start, $orderBy, $ascDesc);
}

function getModuleData($moduleId, $limit = 0, $start = 0, $orderBy = 'item_order', $ascDesc = 'asc', $active = true, $additionalFieldsFilter = [])
{
    $data = CmsModuleData::where('cms_module_id', $moduleId);
    if ($active) {
        $data->where('sts', 1);
    }
    if (count($additionalFieldsFilter) > 0) {
        for ($counter = 1; $counter < 9; $counter++) {
            if (isset($additionalFieldsFilter['additional_field_' . $counter])) {
                $data->where('additional_field_' . $counter, 'like', $additionalFieldsFilter['additional_field_' . $counter]);
            }
        }
    }
    $data->orderBy($orderBy, $ascDesc);
    $data->orderBy('heading', 'asc');
    if ($limit > 0) {
        $data->limit($limit, $start);
    }
    return $data->get();
}

function generateModuleDataImageHtml($folder, $image)
{
    $html = '<div class="col-md-4" id="more_image_' . $image->id . '">
                    <div class="mb-3">
                        <div class="imagebox">
                            <a href="javascript:void(0);" title="' . $image->image_title . '"
                                onclick="openModuleDataImageZoomModal(\'' . asset_uploads($folder . '/' . $image->image_name . '?' . time()) . '\');">
                                <img id="image_' . $image->id . '"
                                    data-imgname="' . $image->image_name . '"
                                    src="' . asset_uploads($folder . '/thumb/' . $image->image_name . '?' . time()) . '"
                                    style="width:100%" alt="' . $image->image_alt . '"
                                    title="' . $image->image_title . '">
                            </a>
                        </div>
                        <div class="mt-2 image_btn">
                            <div class="drag sortable_div" title="Drag and Drop to sort">
                                <i class="fas fa-arrows" aria-hidden="true"></i>
                            </div>
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
    $images = ModuleDataImage::where('module_data_id', $module_data_id)->sorted()->get();
    return getCmsModuleDataImages($images);
}

function getCmsModuleDataImagesBySlug($post_slug)
{
    $moduleData = CmsModuleData::where('post_slug', 'like', $post_slug)->first();
    $images = ModuleDataImage::where('module_data_id', $moduleData->id)->sorted()->get();
    return getCmsModuleDataImages($images);
}

function getCmsModuleDataImages($images)
{
    $imagesArray = [];
    if (count($images) > 0) {
        foreach ($images as $image) {
            $thumb = asset_uploads('module/' . $image->module_type . '/thumb/' . $image->image_name);
            $main = asset_uploads('module/' . $image->module_type . '/' . $image->image_name);
            $thumb2 = asset_uploads('module/' . $image->module_type . '/thumb/' . $image->image_name2);
            $main2 = asset_uploads('module/' . $image->module_type . '/' . $image->image_name2);
            $isBeforeAfter = $image->isBeforeAfter;
            $isBeforeAfterHaveTwoImages = $image->isBeforeAfterHaveTwoImages;
            $imagesArray[] = (object)[
                'id' => $image->id,
                'thumb' => $thumb,
                'main' => $main,
                'thumb2' => $thumb2,
                'main2' => $main2,
                'image_alt' => $image->image_alt,
                'image_title' => $image->image_title,
                'isBeforeAfter' => $isBeforeAfter,
                'isBeforeAfterHaveTwoImages' => $isBeforeAfterHaveTwoImages,
            ];
        }
    }
    return $imagesArray;
}
/******************************** */
function getCmsModuleVideosById($module_data_id)
{
    $videos = ModuleVideo::where('module_data_id', $module_data_id)->get();
    return getCmsModuleVideos($videos);
}

function getCmsModuleVideosBySlug($post_slug)
{
    $moduleData = CmsModuleData::where('post_slug', 'like', $post_slug)->first();
    $videos = ModuleVideo::where('module_data_id', $moduleData->id)->get();
    return getCmsModuleVideos($videos);
}

function getCmsModuleVideos($videos)
{
    $videosArray = [];
    if (count($videos) > 0) {
        foreach ($videos as $videoObj) {
            $thumb = getImage('module/' . $videoObj->module_type . '/videos', $videoObj->video_thumb_img, 'thumb');
            $video = $videoObj->video_link_embed_code;
            $videosArray[] = (object)[
                'id' => $videoObj->id,
                'thumb' => $thumb,
                'video' => $video,
            ];
        }
    }
    return $videosArray;
}
/******************************** */
function generateModuleCodeFieldLabel($field_counter, $errors, $oldData, $hide_show)
{
    $field_counter_minus_1 = $field_counter - 1;
    $field_name = (isset($oldData['field_name'][$field_counter_minus_1])) ? $oldData['field_name'][$field_counter_minus_1] : '';
    $field_label = (isset($oldData['field_label'][$field_counter_minus_1])) ? $oldData['field_label'][$field_counter_minus_1] : '';
    return '
        <div class="row">
            <div class="mb-1 col-md-5 field_' . $field_counter . '">
                <label class="form-label">Field Name:*</label>
                <input name="field_name[]" value="' . $field_name . '"
                    type="text"
                    class="form-control ' . hasError($errors, "field_name.$field_counter_minus_1") . '"
                    placeholder="student_name">
                ' . showErrors($errors, "field_name.$field_counter_minus_1") . '
            </div>
            <div class="mb-1 col-md-5 field_' . $field_counter . '">
                <label class="form-label">Field Label:*</label>
                <input name="field_label[]" value="' . $field_label . '"
                    type="text"
                    class="form-control ' . hasError($errors, "field_label.$field_counter_minus_1") . '"
                    placeholder="Student Name">
                ' . showErrors($errors, "field_label.$field_counter_minus_1") . '
            </div>
            <div class="mb-1 col-md-2 field_' . $field_counter . ' ' . $hide_show . '">
                <label class="form-label">&nbsp;</label><br/>
                <button type="button" class="btn btn-danger" onclick="removeField(' . $field_counter . ');">Remove</button>
            </div>
        </div>';
}
function get_all($limit, $start, $module_id)
{
    $data = getModuleData($module_id, $limit, $start);
    return $data;
}
function get_alls($limit, $start, $module_id, $dateFormat = 'M d, Y')
{
    $moduleArr = CmsModule::find($module_id)->toArray();
    $getArr = getModuleData($module_id, $limit, $start);
    if (sizeof($getArr) > 0) {
        $getArr = $getArr->toArray();
    } else {
        return [];
    }
    return format_records($getArr, $module_id, $moduleArr, $dateFormat);
}
function get_one($parent, $slug, $dateFormat = 'M d, Y')
{
    $moduleArr = CmsModule::where('type', $parent)->first()->toArray();
    $getArr = CmsModuleData::where('sts', 1)
        ->where('cms_module_id', $moduleArr['id'])
        ->where('sts', 1)
        ->where('post_slug', $parent . '/' . $slug);
    $getArr = $getArr->first();
    if (isset($getArr)) {
        $getArr = $getArr->toArray();
    } else {
        abort(404);
    }
    return format_record($getArr, $moduleArr['id'], $moduleArr, $dateFormat);
}
function format_records($getArr, $module_id, $moduleArr, $dateFormat)
{
    $dataArr = array();
    foreach ($getArr as $key => $subValsArr) {
        foreach ($subValsArr as $subKey => $subValue) {
            if ($subKey == 'post_slug') {
                $dataArr[$key][$subKey] = base_url() . $subValue;
            } else if ($subKey == 'featured_img') {
                if ($subValue != '') {
                    if ($module_id == 2 || $module_id == 33) {
                        $dataArr[$key][$subKey] = asset_uploads('module/' . $moduleArr['type'] . '/' . $subValue);
                        $dataArr[$key]['main_img'] = asset_uploads('module/' . $moduleArr['type'] . '/' . $subValue);
                    } else {
                        $dataArr[$key][$subKey] = asset_uploads('module/' . $moduleArr['type'] . '/thumb/' . $subValue);
                        $dataArr[$key]['main_img'] = asset_uploads('module/' . $moduleArr['type'] . '/' . $subValue);
                    }
                } else {
                    // noImg.jpg
                    if (file_exists(storage_uploads('module/' . $moduleArr['type'] . '/thumb/no_image.jpg'))) {
                        $dataArr[$key][$subKey] = asset_uploads('module/' . $moduleArr['type'] . '/thumb/no_image.jpg');
                    } else {
                        $dataArr[$key][$subKey] = getImage('front/images', 'no_image.jpg');
                    }
                }
            } else if ($subKey == 'dated') {
                $dataArr[$key][$subKey] = date($dateFormat, strtotime($subValue));
            } else {
                $dataArr[$key][$subKey] = $subValue;
            }
        }
    }
    return $dataArr;
}
function format_record($subValsArr, $module_id, $moduleArr, $dateFormat)
{
    $dataArr = array();
    foreach ($subValsArr as $kk => $vv) {
        if ($kk == 'post_slug') {
            $dataArr[$kk] = base_url() . $subValsArr[$kk];
        } else if ($kk == 'featured_img') {
            if ($subValsArr[$kk] != '') {
                $dataArr[$kk] = asset_uploads('module/' . $moduleArr['type'] . '/' . $subValsArr[$kk]);
            } else {
                $dataArr[$kk] = '';
            }
        } else if ($kk == 'dated') {
            $dataArr[$kk] = date($dateFormat, strtotime($subValsArr[$kk]));
        } else {
            $dataArr[$kk] = $subValsArr[$kk];
        }
    }
    return $dataArr;
}
function get_all_order($limit, $start, $module_id)
{
    $data = getModuleData($module_id, $limit, $start);
    return $data;
}
function get_permalink($id)
{
    $link = CmsModuleData::where('id', $id)->value('post_slug');
    if ($link != '') {
        return base_url() . $link;
    }
    return '';
}
function get_page($id)
{
    $page = CmsModuleData::where('id', $id)->first();
    if ($page) {
        return $page;
    }
    return '';
}

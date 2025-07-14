<?php

use App\Models\Back\Service;
use App\Helpers\ImageUploader;
use App\Models\Back\ServiceExtraImage;

function generateServiceIsFeaturedDropDown($defaultSelected = 2, $empty = true)
{
    $str = ($empty) ? '<option value="">Select...</option>' : '';
    $statusArray = [1 => 'Featured', 0 => 'Not Featured'];
    foreach ($statusArray as $key => $value) {
        $selected = ($key == $defaultSelected) ? 'selected="selected"' : '';
        $str .= '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
    }

    return $str;
}

function generateServiceStatusDropDown($defaultSelected = 2, $empty = true)
{
    $str = ($empty) ? '<option value="">Select...</option>' : '';
    $statusArray = [1 => 'Active', 0 => 'Inactive'];
    foreach ($statusArray as $key => $value) {
        $selected = ($key == $defaultSelected) ? 'selected="selected"' : '';
        $str .= '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
    }

    return $str;
}

function deleteService($id)
{
    $serviceSubIdsArray = Service::select('id')->where('parent_id', $id)->active()->sorted()->pluck('id')->toArray();
    if (count($serviceSubIdsArray) > 0) {
        foreach ($serviceSubIdsArray as $subCatId) {
            deleteService($subCatId);
        }
    }
    /********************* */
    $serviceObj = Service::find($id);
    ImageUploader::deleteImage('services', $serviceObj->featured_image, true);
    ImageUploader::deleteImage('services', $serviceObj->featured_image, true);
    /********************* */
    $extraImages = ServiceExtraImage::where('service_id', $id)->get();
    foreach ($extraImages as $extraImageObj) {
        ImageUploader::deleteImage('services', $extraImageObj->image_name, true);
        ImageUploader::deleteImage('services', $extraImageObj->image_name2, true);
        $extraImageObj->delete();
    }

    $serviceObj->delete();
}

function generateServicesDropDown($defaultSelected = '', $empty = true)
{
    $html = ($empty) ? '<option value="">Select...</option>' : '';
    $parentTitleArray = [];
    getServiceOptions($html, $parentTitleArray, 0, $defaultSelected);

    return $html;
}

function generateParentServicesDropDown($defaultSelected = '', $empty = true)
{
    $html = ($empty) ? '<option value="0">Root Level</option>' : '';
    $parentTitleArray = [];
    getServiceOptions($html, $parentTitleArray, 0, $defaultSelected);

    return $html;
}

function getServiceOptions(&$html, &$parentTitleArray, $parent_id = 0, $defaultSelected = '')
{
    $services = Service::select('id', 'title', 'slug', 'parent_id')->where('parent_id', $parent_id)->active()->sorted()->get();
    if (count($services) > 0) {
        foreach ($services as $service) {
            $selected = ($service->id == $defaultSelected) ? 'selected="selected"' : '';
            $parentTitleArray[] = $service->title;
            $html .= '<option value="' . $service->id . '" ' . $selected . '>' . implode(' &rArr; ', $parentTitleArray) . '</option>';
            getServiceOptions($html, $parentTitleArray, $service->id, $defaultSelected);
            array_pop($parentTitleArray);
        }
    }
}

function getServiceli(&$html, &$parentTitleArray, $parent_id = 0)
{
    $services = Service::select('id', 'title', 'slug', 'parent_id')->where('parent_id', $parent_id)->active()->sorted()->get();
    if (count($services) > 0) {
        foreach ($services as $service) {

            $parentTitleArray[] = $service->title;
            $html .= '<li class="ui-state-default" id="' . $service->id . '"><i class="fa fa-sort"></i> ' . implode(' &rArr; ', $parentTitleArray) . '</li>';

            getServiceli($html, $parentTitleArray, $service->id);
            array_pop($parentTitleArray);
        }
    }
}

function getParentServicesList(&$html, $parent_id = 0, $indent = ' &rArr; ')
{
    $parentServiceObj = Service::where('id', $parent_id)->first();
    if (null != $parentServiceObj) {
        $html = $parentServiceObj->title . $indent . $html;
        if ($parentServiceObj->parent_id > 0) {
            getParentServicesList($html, $parentServiceObj->parent_id, $indent);
        }
    }
}

function getServiceliFront(&$html, $parent_id = 0)
{
    $services = Service::select('id', 'title', 'slug', 'parent_id')->where('parent_id', $parent_id)->active()->sorted()->get();
    if (count($services) > 0) {
        foreach ($services as $service) {
            $childClass = 'child-li child-li-of-' . $service->parent_id;
            if ($service->parent_id == 0) {
                //$html .= '</ul><ul class="listing row">';
                $childClass = 'parent-li';
            }

            $serviceTitle = $service->title;
            $serviceSlug = $service->slug;
            $html .= '<li class="col-lg-4 col-md-6 box' . $childClass . '" id="' . $service->id . '" data-parent-id="' . $service->parent_id . '"><a href="' . url('services/' . $serviceSlug) . '"
                title="' . $serviceTitle . '">' . $serviceTitle . '</a>
            </li>';
            getServiceliFront($html, $service->id);
        }
    }
}

function getServiceliFrontSide(&$html, $parent_id = 0, $levelCounter = -1)
{
    $services = Service::select('id', 'title', 'slug', 'parent_id')->where('parent_id', $parent_id)->active()->sorted()->get();
    if (count($services) > 0) {
        $levelCounter = $levelCounter + 1;
        $paraClass = 'pad-left-' . $levelCounter;
        foreach ($services as $service) {
            $serviceTitle = $service->title;
            $serviceSlug = $service->slug;
            $anchorClass = ' ';
            if (url('services/' . $serviceSlug) === url()->current()) {
                $anchorClass .= 'underline ';
            }
            $html .= '
            <p class="' . $paraClass . '" id="' . $service->id . '" data-parent-id="' . $service->parent_id . '">
            <a class="' . $anchorClass . '" href="' . url('services/' . $serviceSlug) . '" title="' . $serviceTitle . '">' . $serviceTitle . '</a>
            </p>';
            getServiceliFrontSide($html, $service->id, $levelCounter);
        }
        $levelCounter = $levelCounter - 1;
    }
}

function getIdsOfThoseServicesWhichHaveSubServices($parent_id = 0)
{
    $serviceIdsArray = [];
    getIdsOfServices($serviceIdsArray, $parent_id);

    return $serviceIdsArray;
}

function getIdsOfServices(&$serviceIdsArray, $parent_id)
{
    $services = Service::select('id', 'title', 'slug', 'parent_id')->where('parent_id', $parent_id)->active()->sorted()->get();
    if (count($services) > 0) {
        foreach ($services as $service) {
            $hasSubServices = Service::select('id', 'title', 'slug', 'parent_id')->where('parent_id', $service->id)->active()->count();
            if ($hasSubServices > 0) {
                $serviceIdsArray[] = $service->id;
                getIdsOfServices($serviceIdsArray, $service->id);
            }
        }
    }
}

function getServiceliForSort(&$html, $parent_id = 0)
{
    $services = Service::select('id', 'title', 'slug', 'parent_id')->where('parent_id', $parent_id)->active()->sorted()->get();
    if (count($services) > 0) {
        foreach ($services as $service) {
            $html .= '<li class="ui-state-default" id="' . $service->id . '"><i class="fa fa-sort"></i> ' . $service->title . '</li>';
        }
    }
}

function getServicesExtraImages($serviceId)
{
    $serviceExtraImages = ServiceExtraImage::where('service_id', $serviceId)->sorted()->get();
    $imagesArray = [];
    if (count($serviceExtraImages) > 0) {
        foreach ($serviceExtraImages as $imageObj) {
            $thumb = asset_uploads('services/thumb/' . $imageObj->image_name);
            $main = asset_uploads('services/' . $imageObj->image_name);
            $thumb2 = asset_uploads('services/thumb/' . $imageObj->image_name2);
            $main2 = asset_uploads('services/' . $imageObj->image_name2);
            $isBeforeAfter = $imageObj->isBeforeAfter;
            $isBeforeAfterHaveTwoImages = $imageObj->isBeforeAfterHaveTwoImages;
            $imagesArray[] = (object)[
                'id' => $imageObj->id,
                'thumb' => $thumb,
                'main' => $main,
                'thumb2' => $thumb2,
                'main2' => $main2,
                'image_alt' => $imageObj->image_alt,
                'image_title' => $imageObj->image_title,
                'isBeforeAfter' => $isBeforeAfter,
                'isBeforeAfterHaveTwoImages' => $isBeforeAfterHaveTwoImages,
            ];
        }
    }
    return $imagesArray;
}

function updateChildrenServicesSortOrder($serviceId, $serviceSortOrder)
{
    $childServices = Service::where('parent_id', $serviceId)->get();
    if (count($childServices) > 0) {
        $count = 1;
        foreach ($childServices as $childServiceObj) {
            $childServiceObj->sort_order = $serviceSortOrder . '-' . $count;
            $childServiceObj->update();
            updateChildrenServicesSortOrder($childServiceObj->id, $childServiceObj->sort_order);
            $count++;
        }
    }
}

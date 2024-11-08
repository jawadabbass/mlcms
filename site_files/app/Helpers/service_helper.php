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
    $parentHtml = '';
    getServiceOptions($html, $parentHtml, 0, $defaultSelected);

    return $html;
}

function generateParentServicesDropDown($defaultSelected = '', $empty = true)
{
    $html = ($empty) ? '<option value="0">No Parent</option>' : '';
    $parentHtml = '';
    getServiceOptions($html, $parentHtml, 0, $defaultSelected);

    return $html;
}

function getServiceOptions(&$html, &$parentHtml, $parent_id = 0, $defaultSelected = '')
{
    $services = Service::select('id', 'title', 'slug', 'parent_id')->where('parent_id', $parent_id)->active()->sorted()->get();
    if (count($services) > 0) {
        if ($parent_id != 0) {
            $parentHtml .= ' -> ';
        }
        foreach ($services as $service) {
            if ($service->parent_id == 0) {
                $parentHtml = '';
            }

            $selected = ($service->id == $defaultSelected) ? 'selected="selected"' : '';

            $parentHtml .= $service->title;
            $html .= '<option value="' . $service->id . '" ' . $selected . '>' . $parentHtml . '</option>';

            getServiceOptions($html, $parentHtml, $service->id, $defaultSelected);
        }
    } else {
        $parentHtmlArray = explode(' -> ', $parentHtml);
        array_pop($parentHtmlArray);
        $parentHtml = implode(' -> ', $parentHtmlArray) . ' -> ';
    }
}

function getServiceli(&$html, &$parentHtml, $parent_id = 0)
{
    $services = Service::select('id', 'title', 'slug', 'parent_id')->where('parent_id', $parent_id)->active()->sorted()->get();
    if (count($services) > 0) {
        if ($parent_id != 0) {
            $parentHtml .= ' -> ';
        }
        foreach ($services as $service) {
            if ($service->parent_id == 0) {
                $parentHtml = '';
            }
            $parentHtml .= $service->title;
            $html .= '<li class="ui-state-default" id="' . $service->id . '"><i class="fa fa-sort"></i> ' . $parentHtml . '</li>';

            getServiceli($html, $parentHtml, $service->id);
        }
    } else {
        $parentHtmlArray = explode(' -> ', $parentHtml);
        array_pop($parentHtmlArray);
        $parentHtml = implode(' -> ', $parentHtmlArray) . ' -> ';
    }
}

function getParentServicesList(&$html, $parent_id = 0, $indent = ' -> ')
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

/*
function getServiceForSeo(&$html, $parent_id = 0)
{
    $services = Service::select('id', 'title', 'slug', 'parent_id')->where('parent_id', $parent_id)->active()->sorted()->get();
    if (count($services) > 0) {
        foreach ($services as $service) {
            $serviceTitle = $service->title;
            $html .= ', ' . $serviceTitle;
            getServiceForSeo($html, $service->id);
        }
    }
}
*/

/*
function getFoundInServicesForSeo($serviceIds, $indent = ', ')
{
    $html = '';
    foreach ($serviceIds as $serviceId) {
        $serviceObj = Service::where('id', $serviceId)->first();
        if (null != $serviceObj) {
            $html .= $serviceObj->title . $indent;
        }
    }

    return rtrim($html, $indent);
}
*/

/*
function getCategorySeoArray($service)
{
    return [
        'title' => 'Prestige local :: ' . $service . ' services',
        'keywords' => $service . ' services, find ' . $service . ' services, best ' . $service . ' services',
        'descp' => 'Find the best ' . $service . ' services',
        'index' => 1,
        'no_index' => 0,
        'follow' => 1,
        'no_follow' => 0,
    ];
}
*/

/*
function getParentServicesListLink(&$html, $parent_id = 0, $indent = ' - ')
{
    $parentServiceObj = Service::where('id', $parent_id)->first();
    if (null != $parentServiceObj) {
        $html = '<a href="' . url('/services/' . $parentServiceObj->slug) . '" >' . $parentServiceObj->title . '</a>' . $indent . $html;
        if ($parentServiceObj->parent_id > 0) {
            getParentServicesListLink($html, $parentServiceObj->parent_id, $indent);
        }
    }
}
*/

/*
function getFoundInServicesListLink($serviceIds, $indent = ' / ')
{
    $html = '';
    foreach ($serviceIds as $serviceId) {
        $serviceObj = Service::where('id', $serviceId)->first();
        if (null != $serviceObj) {
            $html .= '<a href="' . url('/services/' . $serviceObj->slug) . '" >' . $serviceObj->title . '</a>' . $indent;
        }
    }

    return rtrim($html, $indent);
}

*/


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

/*
function generateParentOnlyServicesDropDown($defaultSelected = '', $empty = true)
{
    $serviceIdsArray = getIdsOfThoseServicesWhichHaveSubServices(0);

    $str = ($empty) ? '<option value="0">Select...</option>' : '';
    foreach ($serviceIdsArray as $serviceId) {
        $serviceObj = Service::find($serviceId);
        $selected = ($serviceObj->id == $defaultSelected) ? 'selected="selected"' : '';
        $str .= '<option value="' . $serviceObj->id . '" ' . $selected . '>' . $serviceObj->title . '</option>';
    }

    return $str;
}
*/

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

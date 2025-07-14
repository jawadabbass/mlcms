<?php

use App\Models\Back\SiteMap;

function generateSiteMapStatusDropDown($defaultSelected = 2, $empty = true)
{
    $str = ($empty) ? '<option value="">Select...</option>' : '';
    $statusArray = [1 => 'Active', 0 => 'Inactive'];
    foreach ($statusArray as $key => $value) {
        $selected = ($key == $defaultSelected) ? 'selected="selected"' : '';
        $str .= '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
    }

    return $str;
}

function generateSiteMapIsLinkInternalDropDown($defaultSelected = 1, $empty = true)
{
    $str = ($empty) ? '<option value="">Select...</option>' : '';
    $statusArray = [1 => 'Yes', 0 => 'No'];
    foreach ($statusArray as $key => $value) {
        $selected = ($key == $defaultSelected) ? 'selected="selected"' : '';
        $str .= '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
    }

    return $str;
}

function deleteSiteMap($id)
{
    $siteMapSubIdsArray = SiteMap::select('id')->where('parent_id', $id)->active()->sorted()->pluck('id')->toArray();
    if (count($siteMapSubIdsArray) > 0) {
        foreach ($siteMapSubIdsArray as $subCatId) {
            deleteSiteMap($subCatId);
        }
    }
    /********************* */
    $siteMapObj = SiteMap::find($id);
    /********************* */
    $siteMapObj->delete();
}

function generateSiteMapsDropDown($defaultSelected = '', $empty = true)
{
    $html = ($empty) ? '<option value="">Select...</option>' : '';
    $parentTitleArray = [];
    getSiteMapOptions($html, $parentTitleArray, 0, $defaultSelected);

    return $html;
}

function generateParentSiteMapsDropDown($defaultSelected = '', $empty = true)
{
    $html = ($empty) ? '<option value="0">Root Level</option>' : '';
    $parentTitleArray = [];
    getSiteMapOptions($html, $parentTitleArray, 0, $defaultSelected);

    return $html;
}

function getSiteMapOptions(&$html, &$parentTitleArray = [], $parent_id = 0, $defaultSelected = '')
{
    $siteMapCollection = SiteMap::select('id', 'title', 'link', 'parent_id')->where('parent_id', $parent_id)->active()->sorted()->get();
    if (count($siteMapCollection) > 0) {
        foreach ($siteMapCollection as $siteMap) {
            $parentTitleArray[] = $siteMap->title;
            $selected = ($siteMap->id == $defaultSelected) ? 'selected="selected"' : '';
            $html .= '<option value="' . $siteMap->id . '" ' . $selected . '>' . implode(' &rArr; ', $parentTitleArray) . '</option>';
            getSiteMapOptions($html, $parentTitleArray, $siteMap->id, $defaultSelected);
            array_pop($parentTitleArray);
        }
    }
}

function getParentSiteMapsList(&$html, $parent_id = 0, $indent = ' &rArr; ')
{
    $parentSiteMapObj = SiteMap::where('id', $parent_id)->first();
    if (null != $parentSiteMapObj) {
        $html = $parentSiteMapObj->title . $indent . $html;
        if ($parentSiteMapObj->parent_id > 0) {
            getParentSiteMapsList($html, $parentSiteMapObj->parent_id, $indent);
        }
    }
}

function getSiteMapliFront(&$html, $parent_id = 0, $levelCounter = -1)
{
    $siteMapCollection = SiteMap::select('id', 'title', 'link', 'parent_id', 'sort_order')->where('parent_id', $parent_id)->active()->sorted()->get();
    if (count($siteMapCollection) > 0) {
        $levelCounter = $levelCounter + 1;
        $html .= '<ul class="site-map-ul">';
        foreach ($siteMapCollection as $siteMap) {
            $siteMapTitle = $siteMap->title;
            $siteMapLink = $siteMap->link;
            if (!empty($siteMapLink)) {
                if ($siteMap->is_link_internal) {
                    $siteMapLink = url($siteMapLink);
                }
            } else {
                $siteMapLink = 'javascript:void(0);';
            }
            $arrowHtml = '&nbsp;&nbsp;<i class="fa-solid fa-angles-right"></i>&nbsp;&nbsp;';
            $html .= '
            <li class="site-map-level-' . $levelCounter . '" data-parent-id="' . $siteMap->parent_id . '" data-level="' . $levelCounter . '">
            <a class="site-map-border" href="' . $siteMapLink . '" title="' . $siteMapTitle . '">' . $arrowHtml . $siteMapTitle . '&nbsp;&nbsp;</a>
            ';
            getSiteMapliFront($html, $siteMap->id, $levelCounter);
            $html .= '</li>';
        }
        $html .= '</ul>';
        $levelCounter = $levelCounter - 1;
    }
}

function getSiteMapliForSort(&$html, $parent_id = 0)
{
    $siteMapCollection = SiteMap::select('id', 'title', 'link', 'parent_id')->where('parent_id', $parent_id)->active()->sorted()->get();
    if (count($siteMapCollection) > 0) {
        foreach ($siteMapCollection as $siteMap) {
            $html .= '<li class="ui-state-default" id="' . $siteMap->id . '"><i class="fa fa-sort"></i> ' . $siteMap->title . '</li>';
        }
    }
}

function updateChildrenSiteMapSortOrder($siteMapId, $siteMapSortOrder)
{
    $childSiteMap = SiteMap::where('parent_id', $siteMapId)->get();
    if (count($childSiteMap) > 0) {
        $count = 1;
        foreach ($childSiteMap as $childSiteMapObj) {
            $childSiteMapObj->sort_order = $siteMapSortOrder . '-' . $count;
            $childSiteMapObj->update();
            updateChildrenSiteMapSortOrder($childSiteMapObj->id, $childSiteMapObj->sort_order);
            $count++;
        }
    }
}

<?php

function generateBlogCategoryIsFeaturedDropDown($defaultSelected = 0, $empty = true){
    $str = ($empty) ? '<option value="2">Select...</option>' : '';
    $statusArray = [1 => 'Featured', 0 => 'Not Featured'];
    foreach ($statusArray as $key => $value) {
        $selected = ($key == $defaultSelected) ? 'selected="selected"' : '';
        $str .= '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
    }
    return $str;
}
function generateBlogCategoryStatusDropDown($defaultSelected = 0, $empty = true)
{
    $str = ($empty) ? '<option value="2">Select...</option>' : '';
    $statusArray = [1 => 'Active', 0 => 'Inactive'];
    foreach ($statusArray as $key => $value) {
        $selected = ($key == $defaultSelected) ? 'selected="selected"' : '';
        $str .= '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
    }
    return $str;
}
function generateBlogCategoryShowInHeaderDropDown($defaultSelected = 0, $empty = true){
    $str = ($empty) ? '<option value="2">Select...</option>' : '';
    $statusArray = [1 => 'Yes', 0 => 'No'];
    foreach ($statusArray as $key => $value) {
        $selected = ($key == $defaultSelected) ? 'selected="selected"' : '';
        $str .= '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
    }
    return $str;
}
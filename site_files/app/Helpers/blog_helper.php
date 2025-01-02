<?php

function generateBlogPostIsFeaturedDropDown($defaultSelected = 0, $empty = true){
    $str = ($empty) ? '<option value="2">Select...</option>' : '';
    $statusArray = [1 => 'Featured', 0 => 'Not Featured'];
    foreach ($statusArray as $key => $value) {
        $selected = ($key == $defaultSelected) ? 'selected="selected"' : '';
        $str .= '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
    }
    return $str;
}
function generateBlogPostStatusDropDown($defaultSelected = 0, $empty = true)
{
    $str = ($empty) ? '<option value="2">Select...</option>' : '';
    $statusArray = [1 => 'Active', 0 => 'Inactive'];
    foreach ($statusArray as $key => $value) {
        $selected = ($key == $defaultSelected) ? 'selected="selected"' : '';
        $str .= '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
    }
    return $str;
}

function generateCommentIsReviewedDropDown($defaultSelected = 0, $empty = true)
{
    $str = ($empty) ? '<option value="">Select...</option>' : '';
    $statusArray = ['reviewed' => 'Reviewed', 'unreviewed' => 'Unreviewed'];
    foreach ($statusArray as $key => $value) {
        $selected = ($key == $defaultSelected) ? 'selected="selected"' : '';
        $str .= '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
    }

    return $str;
}

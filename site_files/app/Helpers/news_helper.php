<?php

function generateNewsStatusDropDown($defaultSelected = 0, $empty = true)
{
    return generateStatusDropDown($defaultSelected, $empty);
}

function generateNewsHasRegistrationLinkDropDown($defaultSelected = 2, $empty = true)
{
    $str = ($empty) ? '<option value="">Select...</option>' : '';
    $statusArray = ['1' => 'Yes', '0' => 'No'];
    foreach ($statusArray as $key => $value) {
        $selected = ($key == $defaultSelected) ? 'selected="selected"' : '';
        $str .= '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
    }

    return $str;
}

function generateNewsIsThirdPartyLinkDropDown($defaultSelected = 2, $empty = true)
{
    $str = ($empty) ? '<option value="">Select...</option>' : '';
    $statusArray = ['1' => 'Yes', '0' => 'No'];
    foreach ($statusArray as $key => $value) {
        $selected = ($key == $defaultSelected) ? 'selected="selected"' : '';
        $str .= '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
    }

    return $str;
}

function generateNewsIsFeaturedDropDown($defaultSelected = 2, $empty = true)
{
    $str = ($empty) ? '<option value="">Select...</option>' : '';
    $statusArray = ['1' => 'Yes', '0' => 'No'];
    foreach ($statusArray as $key => $value) {
        $selected = ($key == $defaultSelected) ? 'selected="selected"' : '';
        $str .= '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
    }

    return $str;
}
function generateIsHideEventAfterDateDropDown($defaultSelected = 2, $empty = true)
{
    $str = ($empty) ? '<option value="">Select...</option>' : '';
    $statusArray = ['1' => 'Yes', '0' => 'No'];
    foreach ($statusArray as $key => $value) {
        $selected = ($key == $defaultSelected) ? 'selected="selected"' : '';
        $str .= '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
    }

    return $str;
}
<?php

use App\Models\Back\GeneralEmailTemplate;

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

function generateStatusDropDown($defaultSelected = 2, $empty = true)
{
    $str = ($empty) ? '<option value="">Select...</option>' : '';
    $genderArray = [1 => 'Active', 0 => 'Inactive'];
    foreach ($genderArray as $key => $value) {
        $selected = ($key == $defaultSelected) ? 'selected="selected"' : '';
        $str .= '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
    }

    return $str;
}
function generateCareerStatusDropDown($defaultSelected = 2, $empty = true)
{
    return generateStatusDropDown($defaultSelected, $empty);
}
function generateMailTemplatesDropDown($defaultSelected = 0, $empty = true)
{
    $generalEmailTemplates = GeneralEmailTemplate::where('is_temporary', 0)->orderBy('template_name')->get();
    $str = ($empty) ? '<option value="">Select...</option>' : '';
    foreach ($generalEmailTemplates as $generalEmailTemplateObj) {
        $selected = ($generalEmailTemplateObj->id == $defaultSelected) ? 'selected="selected"' : '';
        $str .= '<option value="' . $generalEmailTemplateObj->id . '" ' . $selected . '>' . $generalEmailTemplateObj->template_name . '</option>';
    }
    return $str;
}

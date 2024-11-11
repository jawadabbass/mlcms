<?php

use App\Models\Back\City;
use App\Models\Back\State;
use App\Models\Back\County;
use App\Models\Back\Country;

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
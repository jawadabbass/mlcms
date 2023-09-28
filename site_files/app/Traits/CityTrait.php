<?php

namespace App\Traits;

use App\Models\Back\City;

trait CityTrait
{

    private function setCityStatus($request, $cityObj)
    {
        $cityObj->status = $request->input('status');        
        return $cityObj;
    }
    
    private function setCityValues($request, $cityObj)
    {
        $cityObj = $this->setCityStatus($request, $cityObj);
        $cityObj->state_id = $request->input('state_id');      
        $cityObj->county_id = $request->input('county_id');      
        $cityObj->city_name = $request->input('city_name');
        return $cityObj;
    }

}

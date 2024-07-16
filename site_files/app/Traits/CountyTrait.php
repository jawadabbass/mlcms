<?php

namespace App\Traits;

use App\Models\Back\County;

trait CountyTrait
{

    private function setCountyStatus($request, $countyObj)
    {
        $countyObj->status = $request->input('status');        
        return $countyObj;
    }
    
    private function setCountyValues($request, $countyObj)
    {
        $countyObj = $this->setCountyStatus($request, $countyObj);
        $countyObj->state_id = $request->input('state_id');      
        $countyObj->county_name = $request->input('county_name');
        return $countyObj;
    }

}

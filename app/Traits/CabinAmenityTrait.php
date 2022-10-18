<?php

namespace App\Traits;

trait CabinAmenityTrait
{

    private function setCabinAmenityValues($request, $cabinAmenityObj)
    {
        $cabinAmenityObj->title = $request->input('title');
        $cabinAmenityObj = $this->setCabinAmenityStatus($request, $cabinAmenityObj);

        return $cabinAmenityObj;
    }

    private function setCabinAmenityStatus($request, $cabinAmenityObj)
    {
        $cabinAmenityObj->status = $request->input('status');
        return $cabinAmenityObj;
    }
}

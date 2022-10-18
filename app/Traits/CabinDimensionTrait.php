<?php

namespace App\Traits;

trait CabinDimensionTrait
{

    private function setCabinDimensionValues($request, $cabinDimensionObj)
    {
        $cabinDimensionObj->title = $request->input('title');
        $cabinDimensionObj = $this->setCabinDimensionStatus($request, $cabinDimensionObj);

        return $cabinDimensionObj;
    }

    private function setCabinDimensionStatus($request, $cabinDimensionObj)
    {
        $cabinDimensionObj->status = $request->input('status');
        return $cabinDimensionObj;
    }
}

<?php

namespace App\Traits;

trait BaggageCapacityTrait
{

    private function setBaggageCapacityValues($request, $baggageCapacityObj)
    {
        $baggageCapacityObj->title = $request->input('title');
        $baggageCapacityObj = $this->setBaggageCapacityStatus($request, $baggageCapacityObj);

        return $baggageCapacityObj;
    }

    private function setBaggageCapacityStatus($request, $baggageCapacityObj)
    {
        $baggageCapacityObj->status = $request->input('status');
        return $baggageCapacityObj;
    }
}

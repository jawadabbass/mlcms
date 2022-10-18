<?php

namespace App\Traits;

trait PassengerCapacityTrait
{

    private function setPassengerCapacityValues($request, $passengerCapacityObj)
    {
        $passengerCapacityObj->title = $request->input('title');
        $passengerCapacityObj = $this->setPassengerCapacityStatus($request, $passengerCapacityObj);

        return $passengerCapacityObj;
    }

    private function setPassengerCapacityStatus($request, $passengerCapacityObj)
    {
        $passengerCapacityObj->status = $request->input('status');
        return $passengerCapacityObj;
    }
}

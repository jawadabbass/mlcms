<?php

namespace App\Traits;

trait SafetyTrait
{

    private function setSafetyValues($request, $safetyObj)
    {
        $safetyObj->title = $request->input('title');
        $safetyObj = $this->setSafetyStatus($request, $safetyObj);

        return $safetyObj;
    }

    private function setSafetyStatus($request, $safetyObj)
    {
        $safetyObj->status = $request->input('status');
        return $safetyObj;
    }
}

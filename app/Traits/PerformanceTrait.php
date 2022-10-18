<?php

namespace App\Traits;

trait PerformanceTrait
{

    private function setPerformanceValues($request, $performanceObj)
    {
        $performanceObj->title = $request->input('title');
        $performanceObj = $this->setPerformanceStatus($request, $performanceObj);

        return $performanceObj;
    }

    private function setPerformanceStatus($request, $performanceObj)
    {
        $performanceObj->status = $request->input('status');
        return $performanceObj;
    }
}

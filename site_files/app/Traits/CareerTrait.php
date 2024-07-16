<?php

namespace App\Traits;

use App\Helpers\ImageUploader;

trait CareerTrait
{
    private function setCareerValues($request, $careerObj)
    {
        $careerObj->title = $request->input('title');
        $careerObj->description = $request->input('description');
        $careerObj->apply_by_date_time = $request->input('apply_by_date_time');
        $careerObj->location = $request->input('location');
        $careerObj->type = $request->input('type');
        $careerObj = $this->setCareerStatus($request, $careerObj);

        return $careerObj;
    }

    private function setCareerStatus($request, $careerObj)
    {
        $careerObj->status = $request->input('status');

        return $careerObj;
    }
}

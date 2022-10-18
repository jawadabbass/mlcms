<?php

namespace App\Traits;

use App\Helpers\ImageUploader;
use App\Models\Back\FleetCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

trait FleetCategoryTrait
{
    private function setFleetCategoryImage($request, $fleetCategoryObj)
    {
        if ($request->hasFile('image')) {
            ImageUploader::deleteImage('fleet_categories', $fleetCategoryObj->image, true);
            $image = $request->file('image');

            $newImageName = $request->input('title');

            $fileName = ImageUploader::UploadImage('fleet_categories', $image, $newImageName, 800, 800, true);
            $fleetCategoryObj->image = $fileName;
        }

        return $fleetCategoryObj;
    }

    private function setFleetCategoryValues($request, $fleetCategoryObj)
    {
        $fleetCategoryObj = $this->setFleetCategoryImage($request, $fleetCategoryObj);
        $fleetCategoryObj->title = $request->input('title');
        $fleetCategoryObj->description = $request->input('description');
        $fleetCategoryObj = $this->setFleetCategoryStatus($request, $fleetCategoryObj);

        return $fleetCategoryObj;
    }

    private function setFleetCategoryStatus($request, $fleetCategoryObj)
    {
        $fleetCategoryObj->status = $request->input('status');
        return $fleetCategoryObj;
    }
}

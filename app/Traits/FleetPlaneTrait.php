<?php

namespace App\Traits;

use App\Models\Back\Safety;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Helpers\ImageUploader;
use App\Models\Back\FleetPlane;
use App\Models\Back\PlaneImage;
use App\Models\Back\Performance;
use App\Models\Back\CabinAmenity;
use App\Models\Back\CabinDimension;
use App\Models\Back\BaggageCapacity;
use App\Models\Back\FleetPlaneSafety;
use App\Models\Back\PassengerCapacity;
use App\Models\Back\FleetPlanePerformance;
use App\Models\Back\FleetPlaneCabinAmenity;
use App\Models\Back\FleetPlaneCabinDimension;
use App\Models\Back\FleetPlaneBaggageCapacity;
use App\Models\Back\FleetPlanePassengerCapacity;

trait FleetPlaneTrait
{
    private function setFleetPlaneImage($request, $fleetPlaneObj)
    {
        if ($request->hasFile('image')) {
            ImageUploader::deleteImage('fleet_planes', $fleetPlaneObj->image, true);
            $image = $request->file('image');

            $newImageName = $request->input('plane_name');

            $fileName = ImageUploader::UploadImage('fleet_planes', $image, $newImageName, 800, 800, true);
            $fleetPlaneObj->image = $fileName;
        }

        return $fleetPlaneObj;
    }

    private function setFleetPlaneLayoutImage($request, $fleetPlaneObj)
    {
        if ($request->hasFile('layout_image')) {
            ImageUploader::deleteImage('fleet_planes', $fleetPlaneObj->layout_image, true);
            $image = $request->file('layout_image');

            $newImageName = 'layout ' . $request->input('plane_name');

            $fileName = ImageUploader::UploadImage('fleet_planes', $image, $newImageName, 800, 800, true);
            $fleetPlaneObj->layout_image = $fileName;
        }

        return $fleetPlaneObj;
    }

    private function setFleetPlaneSpecSheet($request, $fleetPlaneObj)
    {
        if ($request->hasFile('spec_sheet')) {
            ImageUploader::deleteImage('fleet_planes', $fleetPlaneObj->image, true);
            $image = $request->file('spec_sheet');

            $newImageName = 'spec sheet ' . $request->input('plane_name');
            $fileName = ImageUploader::UploadDoc('fleet_planes', $image, $newImageName);
            $fleetPlaneObj->spec_sheet = $fileName;
        }

        return $fleetPlaneObj;
    }

    private function uploadFleetPlaneImages($request, $fleetPlaneObj)
    {
        if ($request->hasFile('plane_images')) {
            $plane_images = $request->file('plane_images');
            foreach ($plane_images as $image) {
                $fileName = ImageUploader::UploadImage('fleet_planes', $image, '', 800, 800, true);

                $businessImageObj = new PlaneImage();
                $businessImageObj->fleet_plane_id = $fleetPlaneObj->id;
                $businessImageObj->image = $fileName;
                $businessImageObj->save();
            }
        }
    }

    private function setFleetPlaneValues($request, $fleetPlaneObj)
    {
        $fleetPlaneObj = $this->setFleetPlaneImage($request, $fleetPlaneObj);
        $fleetPlaneObj = $this->setFleetPlaneLayoutImage($request, $fleetPlaneObj);
        $fleetPlaneObj = $this->setFleetPlaneSpecSheet($request, $fleetPlaneObj);
        $fleetPlaneObj->fleet_category_id = $request->input('fleet_category_id');
        $fleetPlaneObj->plane_name = $request->input('plane_name');
        $fleetPlaneObj->description = $request->input('description');
        $fleetPlaneObj = $this->setFleetPlaneStatus($request, $fleetPlaneObj);

        return $fleetPlaneObj;
    }

    private function setFleetPlaneStatus($request, $fleetPlaneObj)
    {
        $fleetPlaneObj->status = $request->input('status');

        return $fleetPlaneObj;
    }

    private function deletePlaneImages($fleetPlaneObj)
    {
        if ($fleetPlaneObj->planeImages->count() > 0) {
            foreach ($fleetPlaneObj->planeImages as $planeImageObj) {
                ImageUploader::deleteImage('fleet_planes', $planeImageObj->image, true);
                $planeImageObj->delete();
            }
        }
    }

    public function deletePlaneImageAjax(Request $request)
    {
        ImageUploader::deleteImage('fleet_planes', $request->image, true);
        PlaneImage::where('id', $request->id)->delete();
        echo 'ok';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(FleetPlane $fleetPlaneObj)
    {
        $this->deletePlaneImages($fleetPlaneObj);
        ImageUploader::deleteImage('fleet_planes', $fleetPlaneObj->image, true);
        ImageUploader::deleteImage('fleet_planes', $fleetPlaneObj->layout_image, true);
        ImageUploader::deleteImage('fleet_planes', $fleetPlaneObj->spec_sheet, false);

        $this->deletePlanePassengerCapacity($fleetPlaneObj);
        $this->deletePlaneCabinDimensions($fleetPlaneObj);
        $this->deletePlaneBaggageCapacity($fleetPlaneObj);
        $this->deletePlanePerformance($fleetPlaneObj);
        $this->deletePlaneCabinAmenities($fleetPlaneObj);
        $this->deletePlaneSafety($fleetPlaneObj);

        $fleetPlaneObj->delete();
        echo 'ok';
    }

    public function deletePlanePassengerCapacity($fleetPlaneObj)
    {
        FleetPlanePassengerCapacity::where('fleet_plane_id', $fleetPlaneObj->id)->delete();
    }

    public function deletePlaneCabinDimensions($fleetPlaneObj)
    {
        FleetPlaneCabinDimension::where('fleet_plane_id', $fleetPlaneObj->id)->delete();
    }

    public function deletePlaneBaggageCapacity($fleetPlaneObj)
    {
        FleetPlaneBaggageCapacity::where('fleet_plane_id', $fleetPlaneObj->id)->delete();
    }

    public function deletePlanePerformance($fleetPlaneObj)
    {
        FleetPlanePerformance::where('fleet_plane_id', $fleetPlaneObj->id)->delete();
    }

    public function deletePlaneCabinAmenities($fleetPlaneObj)
    {
        FleetPlaneCabinAmenity::where('fleet_plane_id', $fleetPlaneObj->id)->delete();
    }

    public function deletePlaneSafety($fleetPlaneObj)
    {
        FleetPlaneSafety::where('fleet_plane_id', $fleetPlaneObj->id)->delete();
    }

    public function setPlanePassengerCapacity($fleetPlaneObj, $request)
    {
        $this->deletePlanePassengerCapacity($fleetPlaneObj);
        $passengerCapacities = PassengerCapacity::active()->sorted()->get();
        foreach ($passengerCapacities as $passengerCapacityObj) {
            $valueField = 'passenger_capacity_value_' . $passengerCapacityObj->id;
            $hintField = 'passenger_capacity_hint_' . $passengerCapacityObj->id;
            $fleetPlanePassengerCapacity = new FleetPlanePassengerCapacity();
            $fleetPlanePassengerCapacity->fleet_plane_id = $fleetPlaneObj->id;
            $fleetPlanePassengerCapacity->passenger_capacity_id = $passengerCapacityObj->id;
            $fleetPlanePassengerCapacity->value = $request->$valueField;
            $fleetPlanePassengerCapacity->hint = $request->$hintField;
            $fleetPlanePassengerCapacity->save();
        }
    }

    public function setPlaneCabinDimensions($fleetPlaneObj, $request)
    {
        $this->deletePlaneCabinDimensions($fleetPlaneObj);
        $cabinDimensions = CabinDimension::active()->sorted()->get();
        foreach ($cabinDimensions as $cabinDimensionObj) {
            $valueField = 'cabin_dimension_value_' . $cabinDimensionObj->id;
            $hintField = 'cabin_dimension_hint_' . $cabinDimensionObj->id;
            $fleetPlaneCabinDimension = new FleetPlaneCabinDimension();
            $fleetPlaneCabinDimension->fleet_plane_id = $fleetPlaneObj->id;
            $fleetPlaneCabinDimension->cabin_dimension_id = $cabinDimensionObj->id;
            $fleetPlaneCabinDimension->value = $request->$valueField;
            $fleetPlaneCabinDimension->hint = $request->$hintField;
            $fleetPlaneCabinDimension->save();
        }
    }

    public function setPlaneBaggageCapacity($fleetPlaneObj, $request)
    {
        $this->deletePlaneBaggageCapacity($fleetPlaneObj);
        $baggageCapacities = BaggageCapacity::active()->sorted()->get();
        foreach ($baggageCapacities as $baggageCapacityObj) {
            $valueField = 'baggage_capacity_value_' . $baggageCapacityObj->id;
            $hintField = 'baggage_capacity_hint_' . $baggageCapacityObj->id;
            $fleetPlaneBaggageCapacity = new FleetPlaneBaggageCapacity();
            $fleetPlaneBaggageCapacity->fleet_plane_id = $fleetPlaneObj->id;
            $fleetPlaneBaggageCapacity->baggage_capacity_id = $baggageCapacityObj->id;
            $fleetPlaneBaggageCapacity->value = $request->$valueField;
            $fleetPlaneBaggageCapacity->hint = $request->$hintField;
            $fleetPlaneBaggageCapacity->save();
        }
    }

    public function setPlanePerformance($fleetPlaneObj, $request)
    {
        $this->deletePlanePerformance($fleetPlaneObj);
        $performances = Performance::active()->sorted()->get();
        foreach ($performances as $performanceObj) {
            $valueField = 'performance_value_' . $performanceObj->id;
            $hintField = 'performance_hint_' . $performanceObj->id;
            $fleetPlanePerformance = new FleetPlanePerformance();
            $fleetPlanePerformance->fleet_plane_id = $fleetPlaneObj->id;
            $fleetPlanePerformance->performance_id = $performanceObj->id;
            $fleetPlanePerformance->value = $request->$valueField;
            $fleetPlanePerformance->hint = $request->$hintField;
            $fleetPlanePerformance->save();
        }
    }

    public function setPlaneCabinAmenities($fleetPlaneObj, $request)
    {
        $this->deletePlaneCabinAmenities($fleetPlaneObj);
        $cabinAmenities = CabinAmenity::active()->sorted()->get();
        foreach ($cabinAmenities as $cabinAmenityObj) {
            $valueField = 'cabin_amenity_value_' . $cabinAmenityObj->id;
            $hintField = 'cabin_amenity_hint_' . $cabinAmenityObj->id;
            $fleetPlaneCabinAmenity = new FleetPlaneCabinAmenity();
            $fleetPlaneCabinAmenity->fleet_plane_id = $fleetPlaneObj->id;
            $fleetPlaneCabinAmenity->cabin_amenity_id = $cabinAmenityObj->id;
            $fleetPlaneCabinAmenity->value = $request->$valueField;
            $fleetPlaneCabinAmenity->hint = $request->$hintField;
            $fleetPlaneCabinAmenity->save();
        }
    }

    public function setPlaneSafety($fleetPlaneObj, $request)
    {
        $this->deletePlaneSafety($fleetPlaneObj);
        $safties = Safety::active()->sorted()->get();
        foreach ($safties as $safetyObj) {
            $valueField = 'safety_value_' . $safetyObj->id;
            $hintField = 'safety_hint_' . $safetyObj->id;
            $fleetPlaneSafety = new FleetPlaneSafety();
            $fleetPlaneSafety->fleet_plane_id = $fleetPlaneObj->id;
            $fleetPlaneSafety->safety_id = $safetyObj->id;
            $fleetPlaneSafety->value = $request->$valueField;
            $fleetPlaneSafety->hint = $request->$hintField;
            $fleetPlaneSafety->save();
        }
    }
}

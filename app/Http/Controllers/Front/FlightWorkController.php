<?php

namespace App\Http\Controllers\Front;

use App\Models\Back\Safety;
use Illuminate\Support\Str;
use App\Models\Back\FleetPlane;
use App\Models\Back\Performance;
use App\Models\Back\CabinAmenity;
use App\Models\Back\CmsModuleData;
use App\Models\Back\FleetCategory;
use App\Models\Back\CabinDimension;
use App\Http\Controllers\Controller;
use App\Models\Back\BaggageCapacity;
use App\Models\Back\PassengerCapacity;

class FlightWorkController extends Controller
{


    public function index($fleetCategoryId = 0, $fleetPlaneId = 0, $fleetPlaneNameSlug = '')
    {
        if ($fleetCategoryId == 0) {
            $firstFleetCategoryObj = FleetCategory::active()->sorted()->first();
            $fleetCategoryId = $firstFleetCategoryObj->id;
        }

        if ($fleetPlaneId == 0) {
            $firstFleetPlaneObj = FleetPlane::where('fleet_category_id', $fleetCategoryId)->active()->sorted()->first();
            $fleetPlaneId = $firstFleetPlaneObj->id;
            $fleetPlaneNameSlug = Str::slug($firstFleetPlaneObj->plane_name);
        }

        $data = CmsModuleData::where('post_slug', 'like', 'flight-works')->first();
        $seoArr = getSeoArrayModule($data->id);
        $fleetCategories = FleetCategory::active()->sorted()->get();
        $fleetPlaneObj = FleetPlane::find($fleetPlaneId);

        $passengerCapacities = PassengerCapacity::active()->sorted()->get();
        $cabinDimensions = CabinDimension::active()->sorted()->get();
        $baggageCapacities = BaggageCapacity::active()->sorted()->get();
        $performances = Performance::active()->sorted()->get();
        $cabinAmenities = CabinAmenity::active()->sorted()->get();
        $safeties = Safety::active()->sorted()->get();

        return view('front.flight_works.index')
            ->with('seoArr', $seoArr)
            ->with('fleetCategoryId', $fleetCategoryId)
            ->with('fleetPlaneId', $fleetPlaneId)
            ->with('fleetPlaneNameSlug', $fleetPlaneNameSlug)
            ->with('fleetCategories', $fleetCategories)
            ->with('fleetPlaneObj', $fleetPlaneObj)
            ->with('passengerCapacities', $passengerCapacities)
            ->with('cabinDimensions', $cabinDimensions)
            ->with('baggageCapacities', $baggageCapacities)
            ->with('performances', $performances)
            ->with('cabinAmenities', $cabinAmenities)
            ->with('safeties', $safeties);
    }
}

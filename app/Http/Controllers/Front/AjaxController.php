<?php

namespace App\Http\Controllers\Front;

use App\Models\Back\City;
use App\Models\Back\State;
use App\Models\Back\County;
use App\Models\Back\ZipCode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class AjaxController extends Controller
{

    public function filterCitiesAjax(Request $request)
    {
        $firstEmpty = ($request->input('firstEmpty', true) == 'true') ? true : false;
        echo generateCitiesDropDown(0, $request->state_id, $firstEmpty);
    }

    public function searchZipCodeAjax(Request $request)
    {
        $firstEmpty = ($request->input('firstEmpty', true) == 'true') ? true : false;
        $stateDD = $cityDD = '';
        $stateId = $cityId = 0;

        $zipCodeObj = ZipCode::where('zipcode', 'like', $request->zipcode)->first();

        if (null !== $zipCodeObj) {
            $stateObj = State::select('id')->where('state_code', 'like', $zipCodeObj->state_code)->first();
            if (null !== $stateObj) {
                $stateId = $stateObj->id;
                $stateDD = generateStatesDropDown($stateId, $firstEmpty);
            }

            $cityObj = City::select('id')->where('city_name', 'like', $zipCodeObj->city_name)->first();
            if (null !== $cityObj) {
                $cityId = $cityObj->id;
                $cityDD = generateCitiesDropDown($cityId, $stateId, $firstEmpty);
            }
        }

        $returnArray = [
            'stateDD' => $stateDD,
            'cityDD' => $cityDD,
        ];
        echo json_encode($returnArray);
    }
}

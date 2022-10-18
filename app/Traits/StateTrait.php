<?php

namespace App\Traits;

use App\Models\Back\State;

trait StateTrait
{

    private function setStateStatus($request, $stateObj)
    {
        $stateObj->status = $request->input('status');        
        return $stateObj;
    }
    
    private function setStateValues($request, $stateObj)
    {
        $stateObj = $this->setStateStatus($request, $stateObj);
        $stateObj->state_code = $request->input('state_code');      
        $stateObj->state_name = $request->input('state_name');
        return $stateObj;
    }

}

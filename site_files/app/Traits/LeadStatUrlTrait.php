<?php

namespace App\Traits;

trait LeadStatUrlTrait
{
    private function setLeadStatUrlValues($request, $leadStatUrlObj)
    {
        if (!empty($request->input('referrer', ''))) {
            $leadStatUrlObj->referrer = $request->input('referrer');
        }
        $leadStatUrlObj->url = $request->input('url');
        $leadStatUrlObj->final_destination = $request->input('final_destination', url('/'));
        $leadStatUrlObj->url_internal_external = $request->input('url_internal_external', 'internal');
        return $leadStatUrlObj;
    }
}

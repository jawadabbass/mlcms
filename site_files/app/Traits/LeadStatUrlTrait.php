<?php

namespace App\Traits;

trait LeadStatUrlTrait
{
    private function setLeadStatUrlValues($request, $leadStatUrlObj)
    {
        $leadStatUrlObj->referrer = $request->input('referrer');
        $leadStatUrlObj->url = $request->input('url');
        $leadStatUrlObj->url_internal_external = $request->input('url_internal_external', 'internal');
        return $leadStatUrlObj;
    }
}

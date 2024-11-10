<?php

namespace App\Traits;

trait SiteMapTrait
{
    private function setSiteMapStatus($request, $siteMapObj)
    {
        $siteMapObj->status = $request->input('status', 0);
        return $siteMapObj;
    }

    private function setSiteMapValues($request, $siteMapObj)
    {
        $siteMapObj = $this->setSiteMapStatus($request, $siteMapObj);
        $siteMapObj->parent_id = $request->input('parent_id', 0);
        $siteMapObj->title = $request->input('title', '');
        $siteMapObj->link = $request->input('link', '');
        $siteMapObj->is_link_internal = $request->input('is_link_internal', 1);
        $siteMapObj = $this->setSiteMapStatus($request, $siteMapObj);
        return $siteMapObj;
    }
}

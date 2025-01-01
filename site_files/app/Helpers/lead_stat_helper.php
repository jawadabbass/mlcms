<?php

use App\Models\Back\LeadStat;
use App\Models\Back\ReferrerImpressionLead;
function generateLeadStatUrlInternalExternalDropDown($defaultSelected = '', $empty = true)
{
    $str = ($empty) ? '<option value="">Select...</option>' : '';
    $statusArray = ['internal' => 'Internal', 'external' => 'External'];
    foreach ($statusArray as $key => $value) {
        $selected = ($key == $defaultSelected) ? 'selected="selected"' : '';
        $str .= '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
    }
    return $str;
}
function insertLeadStatImpression()
{
    $impression_contact = session()->get('impression_contact', 0);
    if (false === (bool)$impression_contact) {
        $referrer = session()->get('referrer', '');
        if (!empty($referrer)) {
            $leadStatObj = new LeadStat();
            $leadStatObj->referrer = $referrer;
            $leadStatObj->save();
            session()->put('impression_contact', 1);
        }
    }
}
function incrementImpressions()
{
    $impression_incremented = session()->get('impression_incremented', 0);
    if (false === (bool)$impression_incremented) {
        $referrerImpressionLeadObj = ReferrerImpressionLead::find(1);
        $referrerImpressionLeadObj->impressions = $referrerImpressionLeadObj->impressions + 1;
        $referrerImpressionLeadObj->save();
        session()->put('impression_incremented', 1);
    }
}
function incrementLeads()
{
    $referrerImpressionLeadObj = ReferrerImpressionLead::find(1);
    $referrerImpressionLeadObj->leads = $referrerImpressionLeadObj->leads + 1;
    $referrerImpressionLeadObj->save();
}
function getImpressions()
{
    $referrerImpressionLeadObj = ReferrerImpressionLead::find(1);
    return $referrerImpressionLeadObj->impressions;
}
function getLeads()
{
    $referrerImpressionLeadObj = ReferrerImpressionLead::find(1);
    return $referrerImpressionLeadObj->leads;
}
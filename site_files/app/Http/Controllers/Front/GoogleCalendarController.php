<?php

namespace App\Http\Controllers\Front;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Back\Metadata;
use Spatie\GoogleCalendar\Event;
use App\Models\Back\CmsModuleData;
use App\Http\Controllers\Controller;

class GoogleCalendarController extends Controller
{
    public function index(Request $request)
    {
        if (isIpBlocked($request->ip())) {
            return redirect('/block');
        }
        $seoArr = getSeoArrayModule(261);
        $editPageID = 261;
        $data = CmsModuleData::find(261);
        return view('front.google_calendar.index', compact('seoArr', 'data', 'editPageID'));
    }
    public function show(Request $request)
    {
        if (isIpBlocked($request->ip())) {
            return redirect('/block');
        }
        $seoArr = getSeoArrayModule(261);
        $editPageID = 261;
        $data = CmsModuleData::find(261);
        return view('front.google_calendar.show', compact('seoArr', 'data', 'editPageID'));
    }
    public function save(Request $request)
    {
        $validationRules = [
            'name' => ['required'],
            'startDate' => ['required'],
            'startTime' => ['required'],
            
            'endDate' => ['required'],
            'endTime' => ['required'],
            'eventColor' => ['required'],
            //'g-recaptcha-response' => 'required|recaptcha',
        ];
        $validationMessages = [
            'name.required' => 'First Name is required',
            'startDate.required' => 'Start Date required',
            'startTime.required' => 'Start Time required',
            'endDate.required' => 'End Date required',
            'endTime.required' => 'End Time required',
            'eventColor.required' => 'Event Color is required',
            'g-recaptcha-response.required' => 'Please prove you are not robot',
            'g-recaptcha-response.recaptcha' => 'Failed to prove you are not robot',
        ];
        $validatedData = $request->validate($validationRules, $validationMessages);
        $negativeKeywordsMetaData = Metadata::where('data_key', 'negative_keywords')->first();
        $negativeKeywords = explode(',', $negativeKeywordsMetaData->val1);
        $sentenceToCheck = $request->name . ' ' . $request->startDate . ' ' . $request->startTime . ' ' . $request->endDate . ' ' . $request->endTime . ' ' . $request->eventColor;

        $hasNegativeKeyword = false;
        if (count($negativeKeywords) > 0) {
            foreach ($negativeKeywords as $negativeKeyword) {
                if (strpos($sentenceToCheck, $negativeKeyword) !== false) {
                    $hasNegativeKeyword = true;
                }
            }
        }
        if ($hasNegativeKeyword === false) {
            $event = new Event();
            $event->name = $request->name;
            $event->startDateTime = Carbon::createFromFormat('Y-m-d H:i',$request->startDate.' '. $request->startTime, "America/New_York");
            $event->endDateTime = Carbon::createFromFormat('Y-m-d H:i',$request->endDate.' '. $request->endTime, "America/New_York");
            $event->setColorId($request->eventColor);
            $event->save();
            echo json_encode(['status' => true, 'error' => 'Thank you, your event has been saved']);
            return;
        } else {
            echo json_encode(['status' => true, 'error' => 'Thank you, your event has been saved!']);
            return;
        }
    }
}

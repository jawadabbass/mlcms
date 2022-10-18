<?php

namespace App\Traits;

use App\Helpers\ImageUploader;
use App\Models\Back\News;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

trait NewsTrait
{
    private function setNewsImage($request, $newsObj)
    {
        if ($request->hasFile('image')) {
            ImageUploader::deleteImage('news', $newsObj->image, true);
            $image = $request->file('image');

            $newsImageName = $request->input('title');

            $fileName = ImageUploader::UploadImage('news', $image, $newsImageName, 800, 800, true);
            $newsObj->image = $fileName;
        }

        return $newsObj;
    }

    private function setNewsValues($request, $newsObj)
    {
        $newsObj->title = $request->input('title');
        $newsObj->description = $request->input('description');
        $newsObj->news_date_time = $request->input('news_date_time');
        $newsObj->has_registration_link = $request->input('has_registration_link');
        $newsObj->registration_link = $request->input('registration_link');
        $newsObj->is_hide_event_after_date = $request->input('is_hide_event_after_date');
        $newsObj->location = $request->input('location');
        $newsObj->is_featured = $request->input('is_featured');
        $newsObj->is_third_party_link = $request->input('is_third_party_link');
        $newsObj->news_link = $request->input('news_link');
        $newsObj = $this->setNewsImage($request, $newsObj);
        $newsObj->image_title = $request->input('image_title');
        $newsObj->image_alt = $request->input('image_alt');
        $newsObj = $this->setNewsStatus($request, $newsObj);

        return $newsObj;
    }

    private function setNewsStatus($request, $newsObj)
    {
        $newsObj->status = $request->input('status');
        return $newsObj;
    }
}

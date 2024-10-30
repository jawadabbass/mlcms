<?php

namespace App\Traits;

use Illuminate\Support\Str;
use App\Helpers\ImageUploader;

trait ServiceTrait
{
    private function setFeaturedImage($request, $serviceObj)
    {
        if ($request->hasFile('featured_image')) {
            ImageUploader::deleteImage('services', $serviceObj->featured_image, true);
            $serviceObj->featured_image = ImageUploader::UploadImage('services', $request->featured_image, $request->title, 1500, 1500, true);
        }
        return $serviceObj;
    }

    private function setServiceStatus($request, $serviceObj)
    {
        $serviceObj->status = $request->input('status', 'Inactive');
        return $serviceObj;
    }

    private function setServiceIsFeatured($request, $serviceObj)
    {
        $serviceObj->is_featured = $request->input('is_featured', 0);
        return $serviceObj;
    }

    private function setServiceValues($request, $serviceObj)
    {
        $serviceObj = $this->setServiceStatus($request, $serviceObj);
        $serviceObj->parent_id = $request->input('parent_id', 0);
        $serviceObj->title = $request->input('title', '');
        $serviceObj->slug = $request->input('slug', Str::slug($request->input('title', '')));
        $serviceObj->description = $request->input('description', '');
        $serviceObj->featured_image_title = $request->input('featured_image_title', '');
        $serviceObj->featured_image_alt = $request->input('featured_image_alt', '');
        $serviceObj->meta_title = $request->input('meta_title', '');
        $serviceObj->meta_keywords = $request->input('meta_keywords', '');
        $serviceObj->meta_description = $request->input('meta_description', '');
        $serviceObj->show_follow = $request->input('show_follow', '');
        $serviceObj->show_index = $request->input('show_index', '');
        $serviceObj->canonical_url = $request->input('canonical_url', '');
        $serviceObj = $this->setFeaturedImage($request, $serviceObj);
        $serviceObj = $this->setServiceStatus($request, $serviceObj);
        $serviceObj = $this->setServiceIsFeatured($request, $serviceObj);

        return $serviceObj;
    }
}

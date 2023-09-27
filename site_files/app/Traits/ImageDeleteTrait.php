<?php

namespace App\Traits;

use App\Helpers\ImageUploader;
use Illuminate\Support\Facades\File;

trait ImageDeleteTrait
{
    private function delImage($path = '', $image = '', $haveSubFolders = true)
    {
        if (!empty($path) && !empty($image) && !is_null($image)) {
            if ($haveSubFolders) {
                File::delete(ImageUploader::storage_path_to_uploads().$path.'/'.'thumb/'.$image);
            }
            File::delete(ImageUploader::storage_path_to_uploads().$path.'/'.$image);
        }
    }
}

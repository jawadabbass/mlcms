<?php

use App\Helpers\ImageUploader;

function getUserImage($user)
{
    $profileImage = $user->profile_image;

    return ImageUploader::print_image_src($profileImage, 'profile_images', 'front/images/no-image.jpg');
}

function getImage($folder, $image, $defaultSize = 'main')
{
    if ($defaultSize == 'main') {
        $defaultSize = '';
    } else {
        $defaultSize = '/' . $defaultSize;
    }
    return ImageUploader::print_image_src($image, $folder . $defaultSize, 'front/images/no-image-available.png');
}

function storage_uploads($path)
{
    return ImageUploader::storage_uploads() . $path;
}

function storage_public($path)
{
    return ImageUploader::storage_public() . $path;
}

function asset_uploads($path)
{
    return ImageUploader::asset_uploads() . $path;
}

function asset_storage($path)
{
    return ImageUploader::asset_storage() . $path;
}

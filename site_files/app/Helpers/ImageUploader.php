<?php

namespace App\Helpers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\WebpEncoder;

class ImageUploader
{
    private static $mainImgWidth = 1200;
    private static $mainImgHeight = 1200;
    private static $thumbImgWidth = 600;
    private static $thumbImgHeight = 600;
    private static $tinyMCEImgWidth = 500;
    private static $tinyMCEImgHeight = 500;
    private static $thumbFolder = '/thumb';

    public static function UploadImage($originalDestinationPath, $field, $newName = '', $width = 0, $height = 0, $makeOtherSizesImages = true)
    {
        if ($width > 0 && $height > 0) {
            self::$mainImgWidth = $width;
            self::$mainImgHeight = $height;
        }
        $originalDestinationPath = str_replace(['//'], ['/'], $originalDestinationPath);
        $destinationPath = ImageUploader::storage_uploads() . $originalDestinationPath;
        $thumbImagePath = $destinationPath . self::$thumbFolder;
        $fileName = self::getNewFileName($destinationPath, $field, $newName);
        $webpFileName = self::getFileNameWebp($fileName);
        $field->storeAs('/public/uploads/' . $originalDestinationPath, $fileName);
        /*         * **** Resizing Images ******** */

        $imageManager = new ImageManager(new Driver());
        $imageToResize = $imageManager->read($destinationPath . '/' . $fileName);
        $imageToResize->scaleDown(self::$mainImgWidth, self::$mainImgHeight)
            ->encode(new WebpEncoder(quality: 100))
            ->save($destinationPath . '/' . $webpFileName);
        /**************************** */
        /**************************** */
        if ($destinationPath . '/' . $webpFileName !== $destinationPath . '/' . $fileName) {
            File::delete($destinationPath . '/' . $fileName);
        }
        /**************************** */
        /**************************** */
        if ($makeOtherSizesImages === true) {
            self::createDirectory($thumbImagePath);
            $imageToResize->scaleDown(self::$thumbImgWidth, self::$thumbImgHeight)->save($thumbImagePath . '/' . $webpFileName);
            /*             * **** End Resizing Images ******** */
        }
        return $webpFileName;
    }
    public static function UploadImageBeforAfter($destinationPath, $field, $newName = '', $width = 0, $height = 0, $makeOtherSizesImages = true)
    {
        $fileName = self::UploadImage($destinationPath, $field, $newName, $width, $height, $makeOtherSizesImages);
        $fileName = self::MarkImageBeforAfter($destinationPath, $fileName, $makeOtherSizesImages);
        return $fileName;
    }
    public static function MarkImageBeforAfter($destinationPath, $fileName, $makeOtherSizesImages = true)
    {
        $destinationPath = ImageUploader::storage_uploads() . $destinationPath;
        $thumbImagePath = $destinationPath . self::$thumbFolder;
        /*         * **** Resizing Images ******** */
        $imageManager = new ImageManager(new Driver());
        $imageToResize = $imageManager->read($destinationPath . '/' . $fileName);
        $imageToResize->text('Before', 0, $imageToResize->height(), function ($font) {
            $font->file(self::font_path());
            $font->size(70);
            $font->color('#ffffff');
            $font->align('left');
            $font->valign('bottom');
            $font->angle(0);
        })->save($destinationPath . '/' . $fileName);
        $imageToResize->text('After', $imageToResize->width(), $imageToResize->height(), function ($font) {
            $font->file(self::font_path());
            $font->size(70);
            $font->color('#ffffff');
            $font->align('right');
            $font->valign('bottom');
            $font->angle(0);
        })->save($destinationPath . '/' . $fileName);
        if ($makeOtherSizesImages === true) {
            $imageManager = new ImageManager(new Driver());
            $imageToResize = $imageManager->read($thumbImagePath . '/' . $fileName);
            $imageToResize->text('Before', 0, $imageToResize->height(), function ($font) {
                $font->file(self::font_path());
                $font->size(10);
                $font->color('#ffffff');
                $font->align('left');
                $font->valign('bottom');
                $font->angle(0);
            })->save($thumbImagePath . '/' . $fileName);
            $imageToResize->text('After', $imageToResize->width(), $imageToResize->height(), function ($font) {
                $font->file(self::font_path());
                $font->size(10);
                $font->color('#ffffff');
                $font->align('right');
                $font->valign('bottom');
                $font->angle(0);
            })->save($thumbImagePath . '/' . $fileName);
        }
        return $fileName;
    }
    public static function CropImageAndMakeThumb($imagePath, $fileName, $width = 0, $height = 0, $x = 0, $y = 0)
    {
        $imagePath = ImageUploader::storage_uploads() . $imagePath;
        $thumbImagePath = $imagePath . self::$thumbFolder;
        $imageManager = new ImageManager(new Driver());
        $imageToCrop = $imageManager->read($imagePath . '/' . $fileName);
        self::createDirectory($thumbImagePath);
        $imageToCrop->crop($width, $height, $x, $y)->save($thumbImagePath . '/' . $fileName);
        /*             * **** End Resizing Images ******** */
        return $fileName;
    }
    public static function UploadDoc($originalDestinationPath, $field, $newName = '')
    {
        $originalDestinationPath = str_replace(['//'], ['/'], $originalDestinationPath);
        $destinationPath = ImageUploader::storage_uploads() . $originalDestinationPath;
        $fileName = self::getNewFileName($destinationPath, $field, $newName);
        $field->storeAs('/public/uploads/' . $originalDestinationPath, $fileName);
        return $fileName;
    }
    public static function getNewFileName($destinationPath, $field, $newName)
    {
        $extension = $field->getClientOriginalExtension();
        $name = str_ireplace(' ', '-', $field->getClientOriginalName());
        $name = Str::replaceLast('.' . $extension, '', $name);
        $newName = ($newName != '') ? $newName : $name;
        $newName = self::getFileName($newName);
        $fileName = Str::slug($newName, '-') . '.' . $extension;
        $fileNameWebp = Str::slug($newName, '-') . '.webp';
        if (file_exists($destinationPath . '/' . $fileName) || file_exists($destinationPath . '/' . $fileNameWebp)) {
            $fileName = time() . '-' . $fileName;
        }
        return $fileName;
    }
    public static function getNewFileNameByName($destinationPath, $newName, $extension)
    {
        $destinationPath = ImageUploader::storage_uploads().$destinationPath;
        $fileName = Str::slug($newName, '-').'.'.$extension;
        if (file_exists($destinationPath.'/'.$fileName)) {
            $fileName = time().'-'.$fileName;
        }
        return $fileName;
    }
    public static function getFileNameWebp($fileName)
    {
        $fileNameArr = explode('.', $fileName);
        $extension = end($fileNameArr);
        $fileName = str_ireplace('.' . $extension, '.webp', $fileName);
        return $fileName;
    }
    public static function getFileName($fileName)
    {
        $fileName = Str::slug($fileName, '-');
        $fileName = (strlen($fileName) > 85) ? substr($fileName, 0, 85) : $fileName;
        return $fileName;
    }
    public static function MoveImage($fileName, $newFileName, $tempPath, $newPath)
    {
        $newFileName = self::getFileName($newFileName);
        $ret = false;
        $tempPath = ImageUploader::storage_uploads() . $tempPath;
        $newPath = ImageUploader::storage_uploads() . $newPath;
        $tempThumbImagePath = $tempPath . self::$thumbFolder;
        $newThumbImagePath = $newPath . self::$thumbFolder;
        if (file_exists($tempPath . '/' . $fileName)) {
            $ext = pathinfo($tempPath . '/' . $fileName, PATHINFO_EXTENSION);
            $newFileName = $newFileName . '.' . $ext;
            rename($tempPath . '/' . $fileName, $newPath . '/' . $newFileName);
            rename($tempThumbImagePath . '/' . $fileName, $newThumbImagePath . '/' . $newFileName);
            $ret = $newFileName;
        }
        return $ret;
    }
    public static function MoveDoc($fileName, $newFileName, $tempPath, $newPath)
    {
        $newFileName = self::getFileName($newFileName);
        $ret = false;
        $tempPath = ImageUploader::storage_uploads() . $tempPath;
        $newPath = ImageUploader::storage_uploads() . $newPath;
        if (file_exists($tempPath . '/' . $fileName)) {
            $ext = pathinfo($tempPath . '/' . $fileName, PATHINFO_EXTENSION);
            $newFileName = $newFileName . '.' . $ext;
            rename($tempPath . '/' . $fileName, $newPath . '/' . $newFileName);
            $ret = $newFileName;
        }
        return $ret;
    }
    public static function UploadImageTinyMce($originalDestinationPath, $field, $newName = '')
    {
        $originalDestinationPath = str_replace(['//'], ['/'], $originalDestinationPath);
        $destinationPath = ImageUploader::storage_uploads() . $originalDestinationPath;
        $fileName = self::getNewFileName($destinationPath, $field, $newName);
        $webpFileName = self::getFileNameWebp($fileName);
        $field->storeAs('/public/uploads/' . $originalDestinationPath, $fileName);
        /*         * **** Resizing Images ******** */
        $imageManager = new ImageManager(new Driver());
        $imageToResize = $imageManager->read($destinationPath . '/' . $fileName);
        $imageToResize->scaleDown(self::$tinyMCEImgWidth, self::$tinyMCEImgHeight)
            ->encode(new WebpEncoder(quality: 100))
            ->save($destinationPath . '/' . $webpFileName);
        /*         * **** End Resizing Images ******** */
        /**************************** */
        /**************************** */
        File::delete($destinationPath . '/' . $fileName);
        /**************************** */
        /**************************** */
        return $webpFileName;
    }
    public static function print_image($image_name, $image_path, $width = 0, $height = 0, $alt_title_txt = '', $default_image = 'mlstorage/images/no-image-available.png')
    {
        echo self::get_image($image_name, $image_path, $width, $height, $alt_title_txt, $default_image);
    }
    public static function print_doc($doc_path, $doc_title, $alt_title_txt = '')
    {
        echo self::get_doc($doc_path, $doc_title, $alt_title_txt);
    }
    public static function get_image($image_name, $image_path, $width = 0, $height = 0, $alt_title_txt = '', $default_image = 'mlstorage/images/no-image-available.png')
    {
        $dimensions = '';
        if ($width > 0 && $height > 0) {
            $dimensions = 'style="max-width=' . $width . 'px; max-height:' . $height . 'px;"';
        } elseif ($width > 0 && $height == 0) {
            $dimensions = 'style="max-width=' . $width . 'px;"';
        } elseif ($width == 0 && $height > 0) {
            $dimensions = 'style="max-height:' . $height . 'px;"';
        }
        $image_src = self::print_image_src($image_name, $image_path, $default_image);
        return '<img src="' . $image_src . '" ' . $dimensions . ' alt="' . $alt_title_txt . '" title="' . $alt_title_txt . '">';
    }
    public static function print_image_src($image_name='fake_image.png', $image_path='fake/image/path', $default_image = 'images/no-image-available.png')
    {
        if (!empty($image_name) && !empty($image_path) && file_exists(ImageUploader::storage_uploads() . $image_path . '/' . $image_name)) {
            return ImageUploader::asset_uploads() . $image_path . '/' . $image_name;
        } else {
            return self::asset_storage().$default_image;
        }
    }
    public static function get_doc($doc_path, $doc_title, $alt_title_txt = '')
    {
        if (!empty($doc_path) && file_exists(ImageUploader::storage_uploads() . $doc_path)) {
            return '<a href="' . self::get_doc_url($doc_path) . '" ' . ' alt="' . $alt_title_txt . '" title="' . $alt_title_txt . '">' . $doc_title . '</a>';
        } else {
            return 'No Doc Available';
        }
    }
    public static function get_doc_url($doc_path)
    {
        if (!empty($doc_path) && file_exists(ImageUploader::storage_uploads() . $doc_path)) {
            return ImageUploader::asset_uploads() . $doc_path;
        } else {
            return '#';
        }
    }
    public static function print_image_relative($image_name, $image_path, $width = 0, $height = 0, $alt_title_txt = '', $default_image = 'images/no-image-available.png')
    {
        $dimensions = '';
        if ($width > 0 && $height > 0) {
            $dimensions = 'style="max-width=' . $width . 'px; max-height:' . $height . 'px;"';
        } elseif ($width > 0 && $height == 0) {
            $dimensions = 'style="max-width=' . $width . 'px;"';
        } elseif ($width == 0 && $height > 0) {
            $dimensions = 'style="max-height:' . $height . 'px;"';
        }
        if (!empty($image_name)) {
            echo '<img src="' . $image_path . '/' . $image_name . '" ' . $dimensions . ' alt="' . $alt_title_txt . '" title="' . $alt_title_txt . '">';
        } else {
            echo '<img src="' . self::asset_storage($default_image) . '" ' . $dimensions . ' alt="' . $alt_title_txt . '" title="' . $alt_title_txt . '">';
        }
    }
    public static function deleteImage($path = '', $image = '', $haveSubFolders = true)
    {
        if (!empty($path) && !empty($image) && !is_null($image)) {
            if ($haveSubFolders) {
                if (file_exists(self::storage_uploads() . $path . '/' . 'thumb/' . $image)) {
                    File::delete(ImageUploader::storage_uploads() . $path . '/' . 'thumb/' . $image);
                }
            }
            if (file_exists(self::storage_uploads() . $path . '/' . $image)) {
                File::delete(ImageUploader::storage_uploads() . $path . '/' . $image);
            }
        }
    }
    public static function deleteFile($path = '', $file = '')
    {
        if (!empty($path) && !empty($file) && !is_null($file)) {
            if (file_exists(self::storage_uploads() . $path . '/' . $file)) {
                File::delete(ImageUploader::storage_uploads() . $path . '/' . $file);
            }
        }
    }
    public static function createDirectory($directoryPath)
    {
        if (!file_exists($directoryPath)) {
            mkdir($directoryPath, 0775, true);
        }
    }
    public static function asset_uploads()
    {
        return self::asset_storage() . 'uploads' . '/';
    }
    public static function asset_storage()
    {
        return asset('mlstorage') . '/';
    }
    public static function storage_uploads()
    {
        return self::storage_public() . 'uploads' . '/';
    }
    public static function storage_public()
    {
        return storage_path('app' . '/' . 'public' . '/');
    }
    public static function font_path()
    {
        return self::storage_public() . 'font' . '/' . 'sabandija' . '/' . 'Sabandija.ttf';
    }
}

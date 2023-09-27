<?php

namespace App\Helpers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ImageUploader
{
    private static $mainImgWidth = 1200;
    private static $mainImgHeight = 1200;
    private static $thumbImgWidth = 400;
    private static $thumbImgHeight = 400;
    private static $tinyMCEImgWidth = 500;
    private static $tinyMCEImgHeight = 500;
    private static $thumbFolder = '/thumb';

    public static function UploadImage($destinationPath, $field, $newName = '', $width = 0, $height = 0, $makeOtherSizesImages = true)
    {
        if ($width > 0 && $height > 0) {
            self::$mainImgWidth = $width;
            self::$mainImgHeight = $height;
        }
        $destinationPath = ImageUploader::real_public_path().$destinationPath;
        $thumbImagePath = $destinationPath.self::$thumbFolder;
        $fileName = self::getNewFileName($destinationPath, $field, $newName);
        $field->move($destinationPath, $fileName);
        /*         * **** Resizing Images ******** */
        $imageToResize = Image::make($destinationPath.'/'.$fileName);
        $imageToResize->resize(self::$mainImgWidth, self::$mainImgHeight, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        })->save($destinationPath.'/'.$fileName);
        if ($makeOtherSizesImages === true) {
            self::createDirectory($thumbImagePath);

            $imageToResize->resize(self::$thumbImgWidth, self::$thumbImgHeight, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save($thumbImagePath.'/'.$fileName);
            /*             * **** End Resizing Images ******** */
        }

        return $fileName;
    }

    public static function UploadImageBeforAfter($destinationPath, $field, $newName = '', $width = 0, $height = 0, $makeOtherSizesImages = true)
    {
        $fileName = self::UploadImage($destinationPath, $field, $newName, $width, $height, $makeOtherSizesImages);
        $fileName = self::MarkImageBeforAfter($destinationPath, $fileName, $makeOtherSizesImages);

        return $fileName;
    }

    public static function MarkImageBeforAfter($destinationPath, $fileName, $makeOtherSizesImages = true)
    {
        $destinationPath = ImageUploader::real_public_path().$destinationPath;
        $thumbImagePath = $destinationPath.self::$thumbFolder;
        /*         * **** Resizing Images ******** */
        $imageToResize = Image::make($destinationPath.'/'.$fileName);
        $imageToResize->text('Before', 0, $imageToResize->height(), function ($font) {
            $font->file(self::font_path());
            $font->size(70);
            $font->color('#ffffff');
            $font->align('left');
            $font->valign('bottom');
            $font->angle(0);
        })->save($destinationPath.'/'.$fileName);
        $imageToResize->text('After', $imageToResize->width(), $imageToResize->height(), function ($font) {
            $font->file(self::font_path());
            $font->size(70);
            $font->color('#ffffff');
            $font->align('right');
            $font->valign('bottom');
            $font->angle(0);
        })->save($destinationPath.'/'.$fileName);
        if ($makeOtherSizesImages === true) {
            $imageToResize = Image::make($thumbImagePath.'/'.$fileName);
            $imageToResize->text('Before', 0, $imageToResize->height(), function ($font) {
                $font->file(self::font_path());
                $font->size(10);
                $font->color('#ffffff');
                $font->align('left');
                $font->valign('bottom');
                $font->angle(0);
            })->save($thumbImagePath.'/'.$fileName);
            $imageToResize->text('After', $imageToResize->width(), $imageToResize->height(), function ($font) {
                $font->file(self::font_path());
                $font->size(10);
                $font->color('#ffffff');
                $font->align('right');
                $font->valign('bottom');
                $font->angle(0);
            })->save($thumbImagePath.'/'.$fileName);
        }

        return $fileName;
    }

    public static function CropImageAndMakeThumb($imagePath, $fileName, $width = 0, $height = 0, $x = 0, $y = 0)
    {
        $imagePath = ImageUploader::real_public_path().$imagePath;
        $thumbImagePath = $imagePath.self::$thumbFolder;
        $imageToCrop = Image::make($imagePath.'/'.$fileName);
        self::createDirectory($thumbImagePath);

        $imageToCrop->crop($width, $height, $x, $y)->save($thumbImagePath.'/'.$fileName);
        /*             * **** End Resizing Images ******** */

        return $fileName;
    }

    public static function UploadDoc($destinationPath, $field, $newName = '')
    {
        $destinationPath = ImageUploader::real_public_path().$destinationPath;
        $fileName = self::getNewFileName($destinationPath, $field, $newName);
        $field->move($destinationPath, $fileName);

        return $fileName;
    }

    public static function getNewFileName($destinationPath, $field, $newName)
    {
        $extension = $field->getClientOriginalExtension();
        $name = $field->getClientOriginalName();
        $name = Str::replaceLast('.'.$extension, '', $name);
        $newName = ($newName != '') ? $newName : $name;
        $newName = self::getFileName($newName);
        $fileName = Str::slug($newName, '-').'.'.$extension;
        if (file_exists($destinationPath.'/'.$fileName)) {
            $fileName = time().'-'.$fileName;
        }

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
        $tempPath = ImageUploader::real_public_path().$tempPath;
        $newPath = ImageUploader::real_public_path().$newPath;
        $tempThumbImagePath = $tempPath.self::$thumbFolder;
        $newThumbImagePath = $newPath.self::$thumbFolder;
        if (file_exists($tempPath.'/'.$fileName)) {
            $ext = pathinfo($tempPath.'/'.$fileName, PATHINFO_EXTENSION);
            $newFileName = $newFileName.'.'.$ext;
            rename($tempPath.'/'.$fileName, $newPath.'/'.$newFileName);
            rename($tempThumbImagePath.'/'.$fileName, $newThumbImagePath.'/'.$newFileName);
            $ret = $newFileName;
        }

        return $ret;
    }

    public static function MoveDoc($fileName, $newFileName, $tempPath, $newPath)
    {
        $newFileName = self::getFileName($newFileName);
        $ret = false;
        $tempPath = ImageUploader::real_public_path().$tempPath;
        $newPath = ImageUploader::real_public_path().$newPath;
        if (file_exists($tempPath.'/'.$fileName)) {
            $ext = pathinfo($tempPath.'/'.$fileName, PATHINFO_EXTENSION);
            $newFileName = $newFileName.'.'.$ext;
            rename($tempPath.'/'.$fileName, $newPath.'/'.$newFileName);
            $ret = $newFileName;
        }

        return $ret;
    }

    public static function UploadImageTinyMce($destinationPath, $field, $newName = '')
    {
        $destinationPath = ImageUploader::real_public_path().$destinationPath;
        $fileName = self::getNewFileName($destinationPath, $field, $newName);
        $field->move($destinationPath, $fileName);
        /*         * **** Resizing Images ******** */
        $imageToResize = Image::make($destinationPath.'/'.$fileName);
        $imageToResize->resize(self::$tinyMCEImgWidth, self::$tinyMCEImgHeight, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        })->save($destinationPath.'/'.$fileName);
        /*         * **** End Resizing Images ******** */
        return $fileName;
    }

    public static function print_image($image_name, $image_path, $width = 0, $height = 0, $alt_title_txt = '', $default_image = 'storage/images/no-image-available.png')
    {
        echo self::get_image($image_name, $image_path, $width, $height, $alt_title_txt, $default_image);
    }

    public static function print_doc($doc_path, $doc_title, $alt_title_txt = '')
    {
        echo self::get_doc($doc_path, $doc_title, $alt_title_txt);
    }

    public static function get_image($image_name, $image_path, $width = 0, $height = 0, $alt_title_txt = '', $default_image = 'storage/images/no-image-available.png')
    {
        $dimensions = '';
        if ($width > 0 && $height > 0) {
            $dimensions = 'style="max-width='.$width.'px; max-height:'.$height.'px;"';
        } elseif ($width > 0 && $height == 0) {
            $dimensions = 'style="max-width='.$width.'px;"';
        } elseif ($width == 0 && $height > 0) {
            $dimensions = 'style="max-height:'.$height.'px;"';
        }
        $image_src = self::print_image_src($image_name, $image_path, $default_image);

        return '<img src="'.$image_src.'" '.$dimensions.' alt="'.$alt_title_txt.'" title="'.$alt_title_txt.'">';
    }

    public static function print_image_src($image_name, $image_path, $default_image = 'images/no-image-available.png')
    {
        if (!empty($image_name) && !empty($image_path) && file_exists(ImageUploader::real_public_path().$image_path.'/'.$image_name)) {
            return ImageUploader::public_path().$image_path.'/'.$image_name;
        } else {
            return self::public_path_to_storage($default_image);
        }
    }

    public static function get_doc($doc_path, $doc_title, $alt_title_txt = '')
    {
        if (!empty($doc_path) && file_exists(ImageUploader::real_public_path().$doc_path)) {
            return '<a href="'.ImageUploader::public_path().$doc_path.'" '.' alt="'.$alt_title_txt.'" title="'.$alt_title_txt.'">'.$doc_title.'</a>';
        } else {
            return 'No Doc Available';
        }
    }

    public static function print_image_relative($image_name, $image_path, $width = 0, $height = 0, $alt_title_txt = '', $default_image = 'images/no-image-available.png')
    {
        $dimensions = '';
        if ($width > 0 && $height > 0) {
            $dimensions = 'style="max-width='.$width.'px; max-height:'.$height.'px;"';
        } elseif ($width > 0 && $height == 0) {
            $dimensions = 'style="max-width='.$width.'px;"';
        } elseif ($width == 0 && $height > 0) {
            $dimensions = 'style="max-height:'.$height.'px;"';
        }
        if (!empty($image_name)) {
            echo '<img src="'.$image_path.'/'.$image_name.'" '.$dimensions.' alt="'.$alt_title_txt.'" title="'.$alt_title_txt.'">';
        } else {
            echo '<img src="'. self::public_path_to_storage($default_image).'" '.$dimensions.' alt="'.$alt_title_txt.'" title="'.$alt_title_txt.'">';
        }
    }

    public static function deleteImage($path = '', $image = '', $haveSubFolders = true)
    {
        if (!empty($path) && !empty($image) && !is_null($image)) {
            if ($haveSubFolders) {
                File::delete(ImageUploader::real_public_path().$path.'/'.'thumb/'.$image);
            }
            File::delete(ImageUploader::real_public_path().$path.'/'.$image);
        }
    }

    public static function createDirectory($directoryPath)
    {
        if (!file_exists($directoryPath)) {
            mkdir($directoryPath, 0775, true);
        }
    }

    public static function public_path()
    {
        return self::public_path_to_storage().'uploads'.DIRECTORY_SEPARATOR;
    }

    public static function public_path_to_storage()
    {
        return url('/').DIRECTORY_SEPARATOR.'storage'.DIRECTORY_SEPARATOR;
    }

    public static function real_public_path()
    {
        return self::storage_path_to_public().'uploads'.DIRECTORY_SEPARATOR;
    }

    public static function storage_path_to_public()
    {
        return storage_path(DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR);
    }

    public static function font_path()
    {
        return self::storage_path_to_public().'font'.DIRECTORY_SEPARATOR.'sabandija'.DIRECTORY_SEPARATOR.'Sabandija.ttf';
    }
}

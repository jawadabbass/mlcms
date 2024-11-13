<?php

namespace App\Http\Controllers\Back;

use App\Helpers\ImageUploader;
use App\Http\Controllers\Controller;
use App\Models\Back\Album;
use App\Models\Back\AlbumImage;
use App\Models\Back\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /* To display all galleries */
    public function index()
    {
        $title = FindInsettingArr('business_name') . ': Album Management';
        $msg = '';
        $albumsObj = [];
        $allAlbums = Album::orderBy('order_by', 'asc')->paginate(10);
        return view('back.gallery.index', compact('title', 'msg', 'albumsObj', 'allAlbums'));
    }
    public function imagesOrder()
    {
        $list_order = request()->list_order;
        $list = explode(',', $list_order);
        $i = 1;
        print_r($list);
        foreach ($list as $id) {
            $image = AlbumImage::find($id);
            $image->orderBy = $i;
            $image->save();
            ++$i;
            echo $i . ' ' . $id;
        }
    }
    public function imageStatus()
    {
        $album = AlbumImage::where(['id' => request('id')])->first();
        if ($album->status == 1) {
            $album->update([
                'status' => 0,
            ]);
            return response([
                'status' => true,
                'message' => 'inactive',
            ]);
        } else {
            $album->update([
                'status' => 1,
            ]);
            return response([
                'status' => true,
                'message' => 'active',
            ]);
        }
    }
    public function imageIsFeatured()
    {
        $album = AlbumImage::where(['id' => request('id')])->first();
        if ($album->isFeatured == 1) {
            $album->update([
                'isFeatured' => 0,
            ]);
            return response([
                'status' => true,
                'message' => 'disabled',
            ]);
        } else {
            $album->update([
                'isFeatured' => 1,
            ]);
            return response([
                'status' => true,
                'message' => 'enabled',
            ]);
        }
    }
    public function order(Request $request)
    {
        $list_order = $request->list_order;
        $list = explode(',', $list_order);
        $i = 1;
        print_r($list);
        foreach ($list as $id) {
            $album = Album::find($id);
            $album->order_by = $i;
            $album->save();
            ++$i;
            echo $i . ' ' . $id;
        }
    }
    public function activate()
    {
        $album = Album::where('id', request('id'))->first();
        if ($album->status == 1) {
            $album->update([
                'status' => 0,
            ]);
            if ($album->isFeatured == 1) {
                $album->update([
                    'isFeatured' => 0,
                ]);
            }
            return response([
                'message' => 'blocked',
            ]);
        } else {
            $album->update([
                'status' => 1,
            ]);
            return response([
                'message' => 'active',
            ]);
        }
    }
    public function isFeatured()
    {
        $album = Album::where(['id' => request('id'), 'status' => 1])->first();
        if (!$album) {
            return response([
                'status' => false,
                'message' => 'Sorry! Can not featured this image',
            ]);
        }
        if ($album->isFeatured == 1) {
            $album->update([
                'isFeatured' => 0,
            ]);
            return response([
                'status' => true,
                'message' => 'disabled',
            ]);
        } else {
            $count = Album::where('isFeatured', 1)->count();
            if ($count >= 3) {
                return response([
                    'status' => false,
                    'message' => 'Maximum three images can be featured',
                ]);
            }
            $album->update([
                'isFeatured' => 1,
            ]);
            return response([
                'status' => true,
                'message' => 'enabled',
            ]);
        }
    }
    public function add_album(Request $request)
    {
        $validatord = Validator::make(
            $request->all(),
            [
                'f_mg' => 'required|image|mimes:jpeg,png,jpg,JPG,gif|max:2048',
                'title' => 'required',
            ],
            ['f_mg.image' => 'ERROR: Please select valid image.']
        );
        if ($validatord->fails()) {
            echo json_encode($validatord->errors());
            exit;
        }
        $imageUploaded = false;
        if (isset($_FILES['f_mg']['name'])) {
            $imageUploaded = true;
        }
        $title = $request->input('title');
        if ($imageUploaded) {
            $photoName = ImageUploader::UploadImage('gallery', $request->f_mg, $title, 2500, 2500, true);
        }
        $idd = $request->input('idd');
        $title = $request->input('title');
        $album_id = $request->input('album_id');
        $dataClient = new Album();
        $dataClient->title = $title;
        $dataClient->cat_id = $album_id;
        if ($imageUploaded) {
            $dataClient->f_img = $photoName;
        } else {
            $dataClient->f_img = '';
        }
        $dataClient->save();
        echo json_encode(['done' => 'ok']);
    }
    public function update_album(Request $request)
    {
        $validationArr = [];
        $maxImageSize = getMaxUploadSize() * 1024;
        $imageUploaded = false;
        if (isset($_FILES['f_mg']['name']) && $_FILES['f_mg']['name'] != '') {
            $imageUploaded = true;
            $validationArr['f_mg'] = 'required|image|mimes:jpeg,png,jpg,gif,webp|max:' . $maxImageSize;
        }
        $validatord = Validator::make(
            $request->all(),
            $validationArr
        );
        if ($validatord->fails()) {
            echo json_encode($validatord->errors());
            exit;
        }
        $title = $request->input('title');
        if ($imageUploaded) {
            $photoName = ImageUploader::UploadImage('gallery/', $request->f_mg, $title, 2500, 2500, true);
        }
        $idd = $request->input('idd');
        $dataClient = Album::find($idd);
        $dataClient->title = $title;
        if ($imageUploaded) {
            $dataClient->f_img = $photoName;
        }
        $dataClient->save();
        echo json_encode(['done' => 'ok']);
    }
    public function upload_album_images(Request $request)
    {
        $maxImageSize = getMaxUploadSize() * 1024;
        $isBeforeAfter = (int) $request->input('isBeforeAfter', 0);
        $isBeforeAfterHaveTwoImages = (int) $request->input('isBeforeAfterHaveTwoImages', 0);
        if ($isBeforeAfter == 1) {
            if ($isBeforeAfterHaveTwoImages == 1) {
                $request->validate(
                    [
                        'before_image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:' . $maxImageSize,
                        'after_image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:' . $maxImageSize,
                        'album' => 'required',
                    ],
                    [
                        'before_image.required' => 'Please select before image.',
                        'after_image.required' => 'Please select after image.',
                        'album.required' => 'Please select album.',
                    ]
                );
                $imageName = ImageUploader::UploadImage('gallery/' . $request->input('album') . '/', $request->file('before_image'), '', 2500, 2500, true);
                $imageName2 = ImageUploader::UploadImage('gallery/' . $request->input('album') . '/', $request->file('after_image'), '', 2500, 2500, true);
                $imageObj = new Image();
                $imageObj->imageUrl = $imageName;
                $imageObj->imageUrl2 = $imageName2;
                $imageObj->album_id = $request->input('album');
                $imageObj->isBeforeAfter = $isBeforeAfter;
                $imageObj->isBeforeAfterHaveTwoImages = $isBeforeAfterHaveTwoImages;
                $imageObj->save();
            } else {
                $request->validate(
                    [
                        'uploadFile' => 'required',
                        'uploadFile.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:' . $maxImageSize,
                        'album' => 'required',
                    ],
                    [
                        'uploadFile.required' => 'Please select image(s).',
                        'album.required' => 'Please select album.',
                    ]
                );
                foreach ($request->file('uploadFile') as $key => $value) {
                    $imageName = ImageUploader::UploadImageBeforAfter('gallery/' . $request->input('album') . '/', $value, '', 2500, 2500, true);
                    $imageObj = new Image();
                    $imageObj->imageUrl = $imageName;
                    $imageObj->album_id = $request->input('album');
                    $imageObj->isBeforeAfter = $isBeforeAfter;
                    $imageObj->save();
                }
            }
        } else {
            $request->validate(
                [
                    'uploadFile' => 'required',
                    'uploadFile.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:' . $maxImageSize,
                    'album' => 'required',
                ],
                [
                    'uploadFile.required' => 'Please select image(s).',
                    'album.required' => 'Please select album.',
                ]
            );
            foreach ($request->file('uploadFile') as $key => $value) {
                $imageName = ImageUploader::UploadImage('gallery/' . $request->input('album') . '/', $value, '', 2500, 2500, true);
                $imageObj = new Image();
                $imageObj->imageUrl = $imageName;
                $imageObj->album_id = $request->input('album');
                $imageObj->isBeforeAfter = $isBeforeAfter;
                $imageObj->save();
            }
        }
        return back()->with('success', 'Images Uploaded Successfully.');
    }
    /**
     * Remove the specified images from album.
     */
    public function destroy($id, Request $request)
    {
        $galleryItem = Image::find($id);
        if (!empty($galleryItem->imageUrl)) {
            ImageUploader::deleteImage('gallery/' . $request->album_id . '/', $galleryItem->imageUrl);
        }
        if (!empty($galleryItem->imageUrl2)) {
            ImageUploader::deleteImage('gallery/' . $request->album_id . '/', $galleryItem->imageUrl2);
        }
        $galleryItem->delete();
        return json_encode(['status' => true]);
    }
    /**
     * Remove the album.
     */
    public function deleteImage()
    {
        $image = AlbumImage::where('id', request('id'))->first();
        if (!empty($image->imageUrl)) {
            ImageUploader::deleteImage('gallery/' . $image->album_id . '/', $image->imageUrl);
        }
        if (!empty($image->imageUrl2)) {
            ImageUploader::deleteImage('gallery/' . $image->album_id . '/', $image->imageUrl2);
        }
        $image->delete();
        return response([
            'status' => true,
            'message' => 'deleted',
        ]);
    }
    public function delete_album($id)
    {
        $allImage = DB::table('images')->where('album_id', $id)->get();
        foreach ($allImage as $key => $value) {
            $galleryItem = Image::find($value->id);
            if (!empty($galleryItem->imageUrl)) {
                ImageUploader::deleteImage('gallery/' . $galleryItem->album_id . '/', $galleryItem->imageUrl);
            }
            if (!empty($galleryItem->imageUrl2)) {
                ImageUploader::deleteImage('gallery/' . $galleryItem->album_id . '/', $galleryItem->imageUrl2);
            }
            $galleryItem->delete();
        }
        $albumItem = Album::find($id);
        $albumItem->delete();
        session(['message' => 'Deleted Successfully', 'type' => 'success']);
        echo json_encode(['status' => true]);
        exit;
    }
    public function create()
    {
        $album_id = request()->route('id');
        $images = AlbumImage::where(['album_id' => $album_id])->orderBy('orderBy', 'asc')->get();
        $title = FindInsettingArr('business_name') . ': Gallery Management';
        $album_name = Album::where(['id' => $album_id])->first();
        $data = ['title' => $title, 'images' => $images, 'album_name' => $album_name->title];
        return view('back.gallery.show', $data);
    }
    public function markBeforeAfter()
    {
        $image = AlbumImage::where(['id' => request('id')])->first();
        ImageUploader::MarkImageBeforAfter('gallery/' . $image->album_id . '/', $image->imageUrl, true);
        $image->update([
            'isBeforeAfter' => 1,
        ]);
        return response([
            'status' => true,
            'message' => 'marked',
            'src' => asset_uploads('gallery/' . $image->album_id . '/thumb/' . $image->imageUrl . '?' . time()),
        ]);
    }
    public function ajax_crop_gallery_img(Request $request)
    {
        $album_id = $request->album_id;
        $crop_x = (int) $request->crop_x;
        $crop_y = (int) $request->crop_y;
        $crop_height = (int) $request->crop_height;
        $crop_width = (int) $request->crop_width;
        $fileName = $request->source_image;
        ImageUploader::CropImageAndMakeThumb('gallery/' . $album_id . '/', $fileName, $crop_width, $crop_height, $crop_x, $crop_y);
        $data['cropped_image'] = $fileName;
        echo json_encode($data);
        exit;
    }
    public function getGalleryImageAltTitle(Request $request)
    {
        $imageObj = AlbumImage::where(['id' => $request->image_id])->first();
        return response([
            'image_alt' => $imageObj->image_alt,
            'image_title' => $imageObj->image_title,
        ]);
    }
    public function saveGalleryImageAltTitle(Request $request)
    {
        $imageObj = AlbumImage::where(['id' => $request->image_id])->first();
        $imageObj->image_alt = $request->image_alt;
        $imageObj->image_title = $request->image_title;
        $imageObj->update();
        return response([
            'image_alt' => $imageObj->image_alt,
            'image_title' => $imageObj->image_title,
        ]);
    }
}

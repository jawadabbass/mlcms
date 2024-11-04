<?php

namespace App\Http\Controllers\Back;

use App\Models\Back\Service;
use App\Traits\ServiceTrait;
use Illuminate\Http\Request;
use App\Helpers\ImageUploader;
use App\Http\Controllers\Controller;
use App\Models\Back\ServiceExtraImage;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Back\ServiceBackFormRequest;

class ServiceController extends Controller
{
    use ServiceTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = config('Constants.SITE_NAME') . ': Services Management';
        $msg = '';
        return view('back.services.index', compact('title', 'msg'));
    }

    public function fetchServicesAjax(Request $request)
    {
        $services = Service::select('*');
        return DataTables::of($services)
            ->filter(function ($query) use ($request) {
                if ($request->has('title') && !empty($request->title)) {
                    $query->where('services.title', 'like', "%{$request->get('title')}%");
                }
                if ($request->has('parent_id') && !empty($request->parent_id)) {
                    $query->where('services.parent_id', $request->get('parent_id'));
                }
                if ($request->has('is_featured') && $request->is_featured != '') {
                    $query->where('services.is_featured', $request->get('is_featured'));
                }
                if ($request->has('status') && $request->status != '') {
                    $query->where('services.status', $request->get('status'));
                }
            })
            ->addColumn('parent_id', function ($services) {
                if ($services->parent_id > 0) {
                    $html = $services->parentService->title;
                    getParentServicesList($html, $services->parentService->parent_id);
                    return $html;
                } else {
                    return '';
                }
            })
            ->addColumn('is_featured', function ($services) {

                $checked = ($services->is_featured) == 1 ? ' checked' : '';

                $str = '<input type="checkbox" data-toggle="toggle_is_featured" data-onlabel="Featured"
                data-offlabel="Not Featured" data-onstyle="success"
                data-offstyle="danger"
                data-id="' . $services->id . '"
                name="is_featured_' . $services->id . '"
                id="is_featured_' . $services->id . '" ' . $checked . '
                value="' . $services->is_featured . '">';
                return $str;
            })
            ->addColumn('status', function ($services) {
                $checked = ($services->status) == 1 ? ' checked' : '';

                $str = '<input type="checkbox" data-toggle="toggle_status" data-onlabel="Active"
                data-offlabel="Not Active" data-onstyle="success"
                data-offstyle="danger"
                data-id="' . $services->id . '"
                name="status_' . $services->id . '"
                id="status_' . $services->id . '" ' . $checked . '
                value="' . $services->status . '">';
                return $str;
            })
            ->addColumn('action', function ($services) {
                return '
                <a href="' . route('services.edit', ['serviceObj' => $services->id]) . '" class="btn btn-info"><i class="fa-solid fa-pencil" aria-hidden="true"></i></a>
				<a href="javascript:void(0);" onclick="deleteService(' . $services->id . ');" class="btn btn-danger"><i class="fa-solid fa-trash" aria-hidden="true"></i></a>				
                ';
            })
            ->rawColumns(['parent_id', 'action', 'is_featured', 'status'])
            ->orderColumns(['sort_order', 'title', 'parent_id', 'is_featured', 'status'], ':column $1')
            ->setRowId(function ($services) {
                return 'servicesDtRow' . $services->id;
            })
            ->make(true);
        //$query = $dataTable->getQuery()->get();
        //return $query;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = config('Constants.SITE_NAME') . ': Services Management';
        $msg = '';
        $serviceObj = new Service();
        $serviceObj->id = 0;
        $serviceObj->show_follow = 1;
        $serviceObj->show_index = 1;
        $serviceObj->status = 1;

        $serviceExtraImages = ServiceExtraImage::where('service_id', $serviceObj->id)->sorted()->get();
        return view('back.services.create')
            ->with('serviceObj', $serviceObj)
            ->with('serviceExtraImages', $serviceExtraImages)
            ->with('title', $title)
            ->with('msg', $msg);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ServiceBackFormRequest $request)
    {
        //dd($request);
        $parent_id = $request->input('parent_id', 0);
        $lastServiceObj = Service::where('parent_id', $parent_id)->orderBy('sort_order', 'desc')->first();
        $parentServiceObj = Service::where('id', $parent_id)->first();
        $sort_order = '1';
        if (null !== $lastServiceObj && $parent_id > 0) {
            $lastSortOrderArray = explode('-', $lastServiceObj->sort_order);
            $lastSortOrder = end($lastSortOrderArray);
            $parentSortOrder = str_replace('-' . $lastSortOrder, '', $lastServiceObj->sort_order);
            $sort_order = $parentSortOrder . '-' . (int)$lastSortOrder + 1;
        } elseif (null !== $lastServiceObj && $parent_id == 0) {
            $sort_order = (int)$lastServiceObj->sort_order + 1;
        } else if (null !== $parentServiceObj) {
            $sort_order = $parentServiceObj->sort_order . '-' . 1;
        }

        /********************* */
        $serviceObj = new Service();
        $serviceObj = $this->setServiceValues($request, $serviceObj);
        $serviceObj->sort_order = $sort_order;
        $serviceObj->save();

        /**************************************** */
        $this->updateServiceExtraImagesServiceIds($request, $serviceObj->id);
        /**************************************** */


        flash('Service has been added!', 'success');
        return Redirect::route('services.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $serviceObj)
    {
        $title = config('Constants.SITE_NAME') . ': Services Management';
        $msg = '';
        $serviceExtraImages = ServiceExtraImage::where('service_id', $serviceObj->id)->sorted()->get();
        return view('back.services.edit')
            ->with('serviceObj', $serviceObj)
            ->with('serviceExtraImages', $serviceExtraImages)
            ->with('title', $title)
            ->with('msg', $msg);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ServiceBackFormRequest $request, Service $serviceObj)
    {
        $serviceObj = $this->setServiceValues($request, $serviceObj);
        $serviceObj->save();

        /*         * ************************************ */

        flash('Service has been updated!', 'success');
        return Redirect::route('services.index');
    }


    public function updateServiceIsFeatured(Request $request)
    {
        $serviceObj = Service::find($request->id);
        $serviceObj = $this->setServiceIsFeatured($request, $serviceObj);
        $serviceObj->update();
        echo 'Done Successfully!';
        exit;
    }

    public function updateServiceStatus(Request $request)
    {
        $serviceObj = Service::find($request->id);
        $serviceObj = $this->setServiceStatus($request, $serviceObj);
        $serviceObj->update();
        echo 'Done Successfully!';
        exit;
    }

    public function destroy(Service $serviceObj)
    {
        deleteService($serviceObj->id);
        echo 'ok';
    }

    public function sortServices()
    {
        $title = config('Constants.SITE_NAME') . ': Services Management';
        $msg = '';
        return view('back.services.sort')->with('title', $title)
            ->with('msg', $msg);
    }

    public function servicesSortData(Request $request)
    {
        $html = '<ul id="sortable">';
        getServiceliForSort($html, $request->input('parent_id', 0));
        echo $html . '</ul>';
    }

    public function servicesSortUpdate(Request $request)
    {
        $servicesOrder = $request->input('servicesOrder');
        $servicesOrderArray = explode(',', $servicesOrder);
        $count = 1;
        foreach ($servicesOrderArray as $serviceId) {
            $serviceObj = Service::find($serviceId);
            $parentServiceObj = Service::where('id', $serviceObj->parent_id)->first();
            if (null !== $parentServiceObj) {
                $serviceObj->sort_order = $parentServiceObj->sort_order . '-' . $count;
            } else {
                $serviceObj->sort_order = $count;
            }
            $serviceObj->update();
            $count++;
        }
    }

    public function sortServicesByTitle(Request $request)
    {
        $parent_id = $request->input('parent_id', 0);
        $services = Service::where('parent_id', $parent_id)->orderBy('title', 'ASC')->get();
        $count = 1;
        foreach ($services as $serviceObj) {
            $parentServiceObj = Service::where('id', $parent_id)->first();
            if (null !== $parentServiceObj) {
                $serviceObj->sort_order = $parentServiceObj->sort_order . '-' . $count;
            } else {
                $serviceObj->sort_order = $count;
            }
            $serviceObj->update();
            $count++;
        }
    }

    public function uploadServiceExtraImages(Request $request)
    {
        $maxImageSize = getMaxUploadSize() * 1024;
        $folder = $request->folder;
        $html = '';
        $isBeforeAfter = (int) $request->input('isBeforeAfter', 0);
        $isBeforeAfterHaveTwoImages = (int) $request->input('isBeforeAfterHaveTwoImages', 0);
        if ($isBeforeAfter == 1) {
            if ($isBeforeAfterHaveTwoImages == 1) {
                $request->validate(
                    [
                        'image_name' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:' . $maxImageSize,
                        'image_name2' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:' . $maxImageSize,
                        'service_id' => 'required',
                        'folder' => 'required',
                    ],
                    [
                        'image_name.required' => 'Please select before image.',
                        'image_name.image' => 'Before image must be an image.',
                        'image_name.mimes' => 'Before image must be of type jpeg,png,jpg,gif,webp.',
                        'image_name2.required' => 'Please select after image.',
                        'image_name2.image' => 'After image must be an image.',
                        'image_name2.mimes' => 'After image must be of type jpeg,png,jpg,gif,webp.',
                    ]
                );
                $imageName = ImageUploader::UploadImage($folder, $request->file('image_name'), '', 2500, 2500, true);
                $imageName2 = ImageUploader::UploadImage($folder, $request->file('image_name2'), '', 2500, 2500, true);

                $image = new ServiceExtraImage();
                $image->image_name = $imageName;
                $image->image_name2 = $imageName2;
                $image->service_id = $request->input('service_id');
                $image->session_id = ($request->input('service_id', 0) == 0) ? $request->input('session_id') : NULL;
                $image->image_alt = $request->input('image_alt');
                $image->image_title = $request->input('image_title');
                $image->isBeforeAfter = $isBeforeAfter;
                $image->isBeforeAfterHaveTwoImages = $isBeforeAfterHaveTwoImages;
                $image->save();
                $html .= view('back.services.services_extra_images.services_extra_images_html_sub', compact('folder', 'image'));
            } else {
                $request->validate(
                    [
                        'uploadFile' => 'required',
                        'uploadFile.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:' . $maxImageSize,
                        'service_id' => 'required',
                        'folder' => 'required',
                    ],
                    [
                        'uploadFile.required' => 'Please select image(s).',
                        'uploadFile.*.image' => 'Image must be an image.',
                        'uploadFile.*.mimes' => 'Image must be of type jpeg,png,jpg,gif,webp.',
                    ]
                );
                foreach ($request->file('uploadFile') as $key => $value) {
                    $imageName = ImageUploader::UploadImageBeforAfter($folder, $value, '', 2500, 2500, true);
                    $image = new ServiceExtraImage();
                    $image->image_name = $imageName;
                    $image->service_id = $request->input('service_id');
                    $image->session_id = ($request->input('service_id', 0) == 0) ? $request->input('session_id') : NULL;
                    $image->image_alt = $request->input('image_alt');
                    $image->image_title = $request->input('image_title');
                    $image->isBeforeAfter = $isBeforeAfter;
                    $image->isBeforeAfterHaveTwoImages = $isBeforeAfterHaveTwoImages;
                    $image->save();
                    $html .= view('back.services.services_extra_images.services_extra_images_html_sub', compact('folder', 'image'));
                }
            }
        } else {
            $request->validate(
                [
                    'uploadFile' => 'required',
                    'uploadFile.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:' . $maxImageSize,
                    'service_id' => 'required',
                    'folder' => 'required',
                ],
                [
                    'uploadFile.required' => 'Please select image(s).',
                    'uploadFile.*.image' => 'Image must be an image.',
                    'uploadFile.*.mimes' => 'Image must be of type jpeg,png,jpg,gif,webp.',
                ]
            );
            foreach ($request->file('uploadFile') as $key => $value) {
                $imageName = ImageUploader::UploadImage($folder, $value, '', 2500, 2500, true);
                $image = new ServiceExtraImage();
                $image->image_name = $imageName;
                $image->service_id = $request->input('service_id');
                $image->session_id = ($request->input('service_id', 0) == 0) ? $request->input('session_id') : NULL;
                $image->image_alt = $request->input('image_alt');
                $image->image_title = $request->input('image_title');
                $image->isBeforeAfter = $isBeforeAfter;
                $image->isBeforeAfterHaveTwoImages = $isBeforeAfterHaveTwoImages;
                $image->save();
                $html .= view('back.services.services_extra_images.services_extra_images_html_sub', compact('folder', 'image'));
            }
        }
        $this->removeServiceExtraUnusedImages();
        echo json_encode(['html' => $html]);
    }

    public function removeServiceExtraImage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file_name' => 'required',
            'folder' => 'required'
        ]);
        if ($validator->passes()) {
            $service_extra_image_id = $request->input('service_extra_image_id', 0);
            if ($service_extra_image_id > 0) {
                $imageObj = ServiceExtraImage::find($service_extra_image_id);
                ImageUploader::deleteImage($request->folder, $imageObj->image_name, true);
                ImageUploader::deleteImage($request->folder, $imageObj->image_name2, true);
                $imageObj->delete();
            }
            echo "done";
        } else {
            echo "error";
        }
    }

    public function removeServiceExtraUnusedImages()
    {
        $date = date_create(date('Y-m-d'));
        date_sub($date, date_interval_create_from_date_string("10 days"));
        $ServiceExtraImages = ServiceExtraImage::whereNotNull('session_id')->where('service_id', 0)->whereDate('created_at', '<', $date)->get();

        foreach ($ServiceExtraImages as $image) {
            ImageUploader::deleteImage('services', $image->image_name, true);
            $image->delete();
        }
    }

    public function saveServiceExtraImagesSortOrder()
    {
        $list_order = request()->list_order;
        $list = explode(',', $list_order);
        $i = 1;
        foreach ($list as $id) {
            $id = str_replace('service_extra_image_', '', $id);
            $image = ServiceExtraImage::find($id);
            $image->sort_order = $i;
            $image->update();
            ++$i;
        }
    }

    public function saveServiceExtraImageCropImage(Request $request)
    {
        $crop_x = (int) $request->crop_x;
        $crop_y = (int) $request->crop_y;
        $crop_height = (int) $request->crop_height;
        $crop_width = (int) $request->crop_width;
        $fileName = $request->source_image;
        $folder = 'services';
        ImageUploader::CropImageAndMakeThumb($folder . '/', $fileName, $crop_width, $crop_height, $crop_x, $crop_y);
        $data['cropped_image'] = $fileName . '?t=' . time();
        echo json_encode($data);
        exit;
    }
    public function getServiceExtraImageAltTitle(Request $request)
    {
        $imageObj = ServiceExtraImage::find($request->image_id);
        return response([
            'image_alt' => $imageObj->image_alt,
            'image_title' => $imageObj->image_title,
        ]);
    }
    public function saveServiceExtraImageAltTitle(Request $request)
    {
        $imageObj = ServiceExtraImage::find($request->image_id);
        $imageObj->image_alt = $request->image_alt;
        $imageObj->image_title = $request->image_title;
        $imageObj->update();
        return response([
            'image_alt' => $imageObj->image_alt,
            'image_title' => $imageObj->image_title,
        ]);
    }
    public function saveServiceExtraImagesMarkBeforeAfter(Request $request)
    {
        $image = ServiceExtraImage::find($request->id);
        $folder = 'services';
        ImageUploader::MarkImageBeforAfter($folder . '/', $image->image_name, true);
        $image->update([
            'isBeforeAfter' => 1,
        ]);
        return response([
            'status' => true,
            'message' => 'marked',
            'src' => asset_uploads($folder . '/thumb/', $image->image_name . '?' . time()),
        ]);
    }

    private function updateServiceExtraImagesServiceIds($request, $serviceObjId)
    {
        ServiceExtraImage::where('session_id', 'like', $request->session_id)->update(['service_id' => $serviceObjId, 'session_id' => NULL]);
    }
}

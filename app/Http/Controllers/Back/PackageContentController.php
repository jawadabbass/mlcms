<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Back\CmsModuleData;
use App\Models\Back\PackageContent;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class PackageContentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {

        $title = config('Constants.SITE_NAME') . 'Manage Package Content';
        $main_package =  CmsModuleData::where('sts', 'active')
            ->where('cms_module_id', 37)
            ->where('id', $id)
            ->first();
        $images = PackageContent::where('package_id', $id)->whereNotNull('image')->get();

        $videos = PackageContent::where('package_id', $id)->whereNotNull('video')->get();

        $documents = PackageContent::where('package_id', $id)->whereNotNull('document')->get();

        $contents = PackageContent::where('package_id', $id)->whereNotNull('content')->get();
        return view('back.packageContent.index', compact('title', 'main_package', 'images', 'videos', 'documents', 'contents'));
    }


    public function store(Request $request)
    {

        $type = $request->type;
        $package_content = new PackageContent();
        $package_content->type_content = $type;
        $package_content->package_id = $request->package_id;

        if ($type == 'video') {

            if ($request->hasFile('video')) {
                $size_bits = $request->file('video')->getSize();
                $video_size_mb = number_format($size_bits / 1048576, 2);

                if ($video_size_mb > 1024) {
                    return response()->json(['status' => 'danger', 'message' => '   Sorry Video Size Can Not Exceed More Than 1 GB']);
                } else {
                    $imageName = $request->video->getClientOriginalName();
                    $newFileName = substr($imageName, 0, (strrpos($imageName, ".")));
                    $request->video->move('uploads/package_content/videos', $imageName);
                    $package_content->video = $imageName;
                }
            }
        } elseif ($type == 'image') {

            if ($request->hasFile('image')) {
                $size_bits = $request->file('image')->getSize();
                $video_size_mb = number_format($size_bits / 1048576, 2);

                if ($video_size_mb > 10) {
                    return response()->json(['status' => 'danger', 'message' => '   Sorry Image Size Can Not Exceed More Than 10 MB']);
                } else {
                    $imageName = $request->image->getClientOriginalName();
                    $newFileName = substr($imageName, 0, (strrpos($imageName, ".")));
                    $request->image->move('uploads/package_content/images', $imageName);
                    $package_content->image = $imageName;
                }
            }
        } elseif ($type == 'document') {

            if ($request->hasFile('document')) {
                $size_bits = $request->file('document')->getSize();
                $video_size_mb = number_format($size_bits / 1048576, 2);

                if ($video_size_mb > 15) {
                    return response()->json(['status' => 'danger', 'message' => '   Sorry Document Size Can Not Exceed More Than 15 MB']);
                } else {
                    $imageName = $request->document->getClientOriginalName();
                    $newFileName = substr($imageName, 0, (strrpos($imageName, ".")));
                    $request->document->move('uploads/package_content/documents', $imageName);
                    $package_content->document = $imageName;
                }
            }
        } else {
            $package_content->content = $request->ck_editor;
        }

        $package_content->save();

        return response()->json(['status' => 'success', 'message' => 'Content Added Successfully In Package']);
    }


    public function delete($id)
    {

        $package = PackageContent::find($id);


        if (!$package->type == 'content') {

            if ($package->type == 'video') {

                unlink('uploads/package_content/videos/' . $package->video);
            } elseif ($package->type == 'image') {

                unlink('uploads/package_content/images' . $package->image);
            } elseif ($package->type == 'document') {

                unlink('uploads/package_content/documents/' . $package->document);
            }
        }

        $package->delete();
        return response()->json(['status' => 'success', 'message' => 'Record deleted successfully']);
    }


    function editStoreContent(Request $request)
    {


        $package = PackageContent::find($request->edit_item);
        $package->content = $request->edit_ck_editor;

        $package->save();

        return response()->json(['status' => 'success', 'message' => 'Record updated  successfully']);
    }
}

<?php

namespace App\Http\Controllers\Back;

use Illuminate\Http\Request;
use App\Traits\BlogCategoryTrait;
use App\Helpers\ImageUploader;
use App\Models\Back\BlogCategory;
use App\Models\Back\BlogComment;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Back\BlogCategoryBackFormRequest;
use App\Http\Requests\Back\BlogCategoryFeaturedImageBackFormRequest;

class BlogCategoryController extends Controller
{
    use BlogCategoryTrait;
    public function index()
    {
        $title = config('Constants.SITE_NAME') . ': Blog Category Management';
        $msg = '';
        return view('back.blog_categories.index', compact('title', 'msg'));
    }
    public function fetchBlogCategoriesAjax(Request $request)
    {
        $blogCategoryObj = BlogCategory::select('*');
        return DataTables::of($blogCategoryObj)
            ->filter(function ($query) use ($request) {
                if ($request->has('search') && !empty($request->search)) {
                    $query->where(function ($q) use ($request) {
                        $q->orWhere('blog_categories.cate_title', 'like', $request->get('search'));
                        $q->orWhere('blog_categories.cate_slug', 'like', $request->get('search'));
                        $q->orWhere('blog_categories.cate_description', 'like', "%{$request->get('search')}%");
                    });
                }
                if ($request->has('is_featured') && $request->is_featured != 2) {
                    $query->where('blog_categories.is_featured', $request->get('is_featured'));
                }
                if ($request->has('show_in_header') && $request->show_in_header != 2) {
                    $query->where('blog_categories.show_in_header', $request->get('show_in_header'));
                }
                if ($request->has('sts') && $request->sts != 2) {
                    $query->where('blog_categories.sts', $request->get('sts'));
                }
            })
            ->addColumn('featured_img', function ($blogCategoryObj) {
                return '<img src="' . ImageUploader::print_image_src($blogCategoryObj->featured_img, 'blog_categories/thumb') . '?t='.time().'" style="max-width:150px !important; max-height:150px !important;"/>';
            })
            ->addColumn('preview', function ($blogCategoryObj) {
                return '<a href="' . base_url() . 'blog/category/' . $blogCategoryObj->cate_slug . '" target="_bank">Preview</a>';
            })
            ->addColumn('sts', function ($blogCategoryObj) {
                $checked = ($blogCategoryObj->sts) == 1 ? ' checked' : '';

                $str = '<input type="checkbox" data-toggle="toggle_sts" data-onlabel="Active"
                data-offlabel="Not Active" data-onstyle="success"
                data-offstyle="danger"
                data-id="' . $blogCategoryObj->id . '"
                name="sts_' . $blogCategoryObj->id . '"
                id="sts_' . $blogCategoryObj->id . '" ' . $checked . '
                value="' . $blogCategoryObj->sts . '">';
                return $str;
            })
            ->addColumn('is_featured', function ($blogCategoryObj) {

                $checked = ($blogCategoryObj->is_featured) == 1 ? ' checked' : '';

                $str = '<input type="checkbox" data-toggle="toggle_is_featured" data-onlabel="Featured"
                data-offlabel="Not Featured" data-onstyle="success"
                data-offstyle="danger"
                data-id="' . $blogCategoryObj->id . '"
                name="is_featured_' . $blogCategoryObj->id . '"
                id="is_featured_' . $blogCategoryObj->id . '" ' . $checked . '
                value="' . $blogCategoryObj->is_featured . '">';
                return $str;
            })
            ->addColumn('show_in_header', function ($blogCategoryObj) {

                $checked = ($blogCategoryObj->show_in_header) == 1 ? ' checked' : '';

                $str = '<input type="checkbox" data-toggle="toggle_show_in_header" data-onlabel="Yes"
                data-offlabel="No" data-onstyle="success"
                data-offstyle="danger"
                data-id="' . $blogCategoryObj->id . '"
                name="show_in_header_' . $blogCategoryObj->id . '"
                id="show_in_header_' . $blogCategoryObj->id . '" ' . $checked . '
                value="' . $blogCategoryObj->show_in_header . '">';
                return $str;
            })
            ->addColumn('action', function ($blogCategoryObj) {
                return '
                		<a href="' . route('blog.category.edit', ['blogCategoryObj' => $blogCategoryObj->id]) . '" class="m-2 btn btn-warning"><i class="fa fa-pencil" aria-hidden="true"></i></a>
						<a href="javascript:void(0);" onclick="deleteBlogCategory(' . $blogCategoryObj->id . ');"  class="m-2 btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>';
            })
            ->rawColumns(['featured_img', 'preview', 'sts', 'is_featured', 'show_in_header', 'action'])
            ->orderColumns(['cate_title'], ':column $1')
            ->setRowId(function ($blogCategoryObj) {
                return 'blogCategoryDtRow' . $blogCategoryObj->id;
            })
            ->make(true);
    }

    public function create()
    {
        $title = FindInsettingArr('business_name') . ': Blog Category Management';
        $msg = '';
        $blogCategoryObj = new BlogCategory();
        $blogCategoryObj->id = 0;
        $blogCategoryObj->sts = 1;
        $blogCategoryObj->is_featured = 0;
        $blogCategoryObj->show_in_header = 0;

        return view('back.blog_categories.create')
            ->with('blogCategoryObj', $blogCategoryObj)
            ->with('title', $title)
            ->with('msg', $msg);
    }

    public function store(BlogCategoryBackFormRequest $request)
    {
        $blogCategoryObj = new BlogCategory();
        $blogCategoryObj = $this->setBlogCategoryValues($request, $blogCategoryObj);
        $blogCategoryObj->save();

        /******************************* */
        /******************************* */
        $recordUpdateHistoryData = [
            'record_id' => $blogCategoryObj->id,
            'record_title' => $blogCategoryObj->cate_title,
            'record_link' => url('adminmedia/blog-category/' . $blogCategoryObj->id . '/edit'),
            'model_or_table' => 'BlogCategory',
            'admin_id' => auth()->user()->id,
            'ip' => request()->ip(),
            'draft' => json_encode($blogCategoryObj->toArray()),
        ];
        recordUpdateHistory($recordUpdateHistoryData);
        /******************************* */
        /******************************* */

        session(['message' => 'Blog Category has been added!', 'type' => 'success']);

        return Redirect::route('blog.categories.index');
    }
    public function edit(BlogCategory $blogCategoryObj)
    {
        $title = FindInsettingArr('business_name') . ': Blog Category Management';
        $msg = '';

        return view('back.blog_categories.edit')
            ->with('blogCategoryObj', $blogCategoryObj)
            ->with('title', $title)
            ->with('msg', $msg);
    }
    public function update(BlogCategoryBackFormRequest $request, BlogCategory $blogCategoryObj)
    {
        $blogCategoryObj = $this->setBlogCategoryValues($request, $blogCategoryObj);
        $blogCategoryObj->save();
        /******************************* */
        /******************************* */
        $recordUpdateHistoryData = [
            'record_id' => $blogCategoryObj->id,
            'record_title' => $blogCategoryObj->cate_title,
            'record_link' => url('adminmedia/blog-category/' . $blogCategoryObj->id . '/edit'),
            'model_or_table' => 'BlogCategory',
            'admin_id' => auth()->user()->id,
            'ip' => request()->ip(),
            'draft' => json_encode($blogCategoryObj->toArray()),
        ];
        recordUpdateHistory($recordUpdateHistoryData);
        /******************************* */
        /******************************* */
        session(['message' => 'Blog Category has been updated!', 'type' => 'success']);
        return Redirect::route('blog.categories.index');
    }
    public function updateBlogCategoryIsFeatured(Request $request)
    {
        $blogCategoryObj = BlogCategory::find($request->id);
        $blogCategoryObj = $this->setBlogCategoryIsFeatured($request, $blogCategoryObj);
        $blogCategoryObj->update();
        /******************************* */
        /******************************* */
        $recordUpdateHistoryData = [
            'record_id' => $blogCategoryObj->id,
            'record_title' => $blogCategoryObj->cate_title,
            'record_link' => url('adminmedia/blog-category/' . $blogCategoryObj->id . '/edit'),
            'model_or_table' => 'BlogCategory',
            'admin_id' => auth()->user()->id,
            'ip' => request()->ip(),
            'draft' => json_encode($blogCategoryObj->toArray()),
        ];
        recordUpdateHistory($recordUpdateHistoryData);
        /******************************* */
        /******************************* */
        echo 'Done Successfully!';
        exit;
    }
    public function updateBlogCategoryStatus(Request $request)
    {
        $blogCategoryObj = BlogCategory::find($request->id);
        $blogCategoryObj = $this->setBlogCategoryStatus($request, $blogCategoryObj);
        $blogCategoryObj->save();
        /******************************* */
        /******************************* */
        $recordUpdateHistoryData = [
            'record_id' => $blogCategoryObj->id,
            'record_title' => $blogCategoryObj->cate_title,
            'record_link' => url('adminmedia/blog-category/' . $blogCategoryObj->id . '/edit'),
            'model_or_table' => 'BlogCategory',
            'admin_id' => auth()->user()->id,
            'ip' => request()->ip(),
            'draft' => json_encode($blogCategoryObj->toArray()),
        ];
        recordUpdateHistory($recordUpdateHistoryData);
        /******************************* */
        /******************************* */
        echo 'Done Successfully!';
        exit;
    }
    public function updateBlogCategoryShowInHeader(Request $request)
    {
        $blogCategoryObj = BlogCategory::find($request->id);
        $blogCategoryObj = $this->setBlogCategoryShowInHeader($request, $blogCategoryObj);
        $blogCategoryObj->update();
        /******************************* */
        /******************************* */
        $recordUpdateHistoryData = [
            'record_id' => $blogCategoryObj->id,
            'record_title' => $blogCategoryObj->cate_title,
            'record_link' => url('adminmedia/blog-category/' . $blogCategoryObj->id . '/edit'),
            'model_or_table' => 'BlogCategory',
            'admin_id' => auth()->user()->id,
            'ip' => request()->ip(),
            'draft' => json_encode($blogCategoryObj->toArray()),
        ];
        recordUpdateHistory($recordUpdateHistoryData);
        /******************************* */
        /******************************* */
        echo 'Done Successfully!';
        exit;
    }
    public function destroy(BlogCategory $blogCategoryObj)
    {
        ImageUploader::deleteImage('blog', $blogCategoryObj->featured_img, true);
        $blogCategoryObj->delete();
        echo 'ok';
    }
    public function uploadFeaturedImage(BlogCategoryFeaturedImageBackFormRequest $request)
    {
        if ($request->hasFile('blog_category_featured_img_file')) {
            $newName = $request->input('newName', '');
            $oldName = $request->input('oldName', '');
            if (!empty($oldName)) {
                ImageUploader::deleteImage('blog_categories', $oldName, true);
            }
            $image = $request->file('blog_category_featured_img_file');
            $fileName = ImageUploader::UploadImage('blog_categories', $image, $newName, 1600, 1600, true);
            
            $returnArr = ['fileName' => $fileName, 'image' => '<img src="' . getImage('blog_categories', $fileName, 'thumb') . '?t='.time().'" height="150">'];
            echo json_encode($returnArr);
        }
    }
}

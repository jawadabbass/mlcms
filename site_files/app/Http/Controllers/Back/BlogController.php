<?php

namespace App\Http\Controllers\Back;

use Illuminate\Http\Request;
use App\Models\Back\BlogPost;
use App\Traits\BlogPostTrait;
use App\Helpers\ImageUploader;
use App\Models\Back\BlogComment;
use App\Models\Back\BlogCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Back\BlogPostBackFormRequest;
use App\Http\Requests\Back\BlogPostFeaturedImageBackFormRequest;

class BlogController extends Controller
{
    use BlogPostTrait;
    public function index()
    {
        $title = config('Constants.SITE_NAME') . ': Blog Management';
        $msg = '';
        return view('back.blog.index', compact('title', 'msg'));
    }
    public function fetchBlogPostsAjax(Request $request)
    {
        $blogPostObj = Blogpost::select('*');
        return DataTables::of($blogPostObj)
            ->filter(function ($query) use ($request) {
                if ($request->has('search') && !empty($request->search)) {
                    $query->where(function ($q) use ($request) {
                        $q->orWhere('blog_posts.title', 'like', $request->get('search'));
                        $q->orWhere('blog_posts.post_slug', 'like', $request->get('search'));
                        $q->orWhere('blog_posts.description', 'like', "%{$request->get('search')}%");
                        $q->orWhere('blog_posts.meta_title', 'like', "%{$request->get('search')}%");
                        $q->orWhere('blog_posts.meta_keywords', 'like', "%{$request->get('search')}%");
                        $q->orWhere('blog_posts.meta_description', 'like', "%{$request->get('search')}%");
                    });
                }
                if ($request->has('sts') && $request->sts != 2) {
                    $query->where('blog_posts.sts', $request->get('sts'));
                }
            })
            ->addColumn('dated', function ($blogPostObj) {
                return date('m-d-Y', strtotime($blogPostObj->dated));
            })
            ->addColumn('total_unrevised_comments', function ($blogPostObj) {
                $numUnreviewedComments = BlogComment::select('id')->where('post_id', $blogPostObj->id)->where('reviewed_status', 'like', 'unreviewed')->count();
                $unreviewed = ($numUnreviewedComments > 0) ? 'Unreviewed ' . $numUnreviewedComments : '';
                return '<a href="' . admin_url() . 'blog_comments?id=' . $blogPostObj->id . '">View All<br>' . $unreviewed . '</a>';
            })
            ->addColumn('featured_img', function ($blogPostObj) {
                return '<img src="' . ImageUploader::print_image_src($blogPostObj->featured_img, 'blog/thumb') . '" style="max-width:165px !important; max-height:165px !important;"/>';
            })
            ->addColumn('preview', function ($blogPostObj) {
                return '<a href="' . base_url() . 'blog/' . $blogPostObj->post_slug . '" target="_bank">Preview</a>';
            })
            ->addColumn('sts', function ($blogPostObj) {
                $checked = ($blogPostObj->sts) == 1 ? ' checked' : '';

                $str = '<input type="checkbox" data-toggle="toggle_sts" data-onlabel="Active"
                data-offlabel="Not Active" data-onstyle="success"
                data-offstyle="danger"
                data-id="' . $blogPostObj->id . '"
                name="sts_' . $blogPostObj->id . '"
                id="sts_' . $blogPostObj->id . '" ' . $checked . '
                value="' . $blogPostObj->sts . '">';
                return $str;
            })
            ->addColumn('is_featured', function ($blogPostObj) {

                $checked = ($blogPostObj->is_featured) == 1 ? ' checked' : '';

                $str = '<input type="checkbox" data-toggle="toggle_is_featured" data-onlabel="Featured"
                data-offlabel="Not Featured" data-onstyle="success"
                data-offstyle="danger"
                data-id="' . $blogPostObj->id . '"
                name="is_featured_' . $blogPostObj->id . '"
                id="is_featured_' . $blogPostObj->id . '" ' . $checked . '
                value="' . $blogPostObj->is_featured . '">';
                return $str;
            })
            ->addColumn('action', function ($blogPostObj) {
                return '
                		<a href="' . route('blog.post.edit', ['blogPostObj' => $blogPostObj->id]) . '" class="m-2 btn btn-warning"><i class="fa fa-pencil" aria-hidden="true"></i></a>
						<a href="javascript:void(0);" onclick="deleteBlogPost(' . $blogPostObj->id . ');"  class="m-2 btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>';
            })
            ->rawColumns(['dated', 'featured_img', 'preview', 'sts', 'is_featured', 'total_unrevised_comments', 'action'])
            ->orderColumns(['dated', 'title'], ':column $1')
            ->setRowId(function ($blogPostObj) {
                return 'blogPostDtRow' . $blogPostObj->id;
            })
            ->make(true);
    }

    public function create()
    {
        $title = FindInsettingArr('business_name') . ': Blog Management';
        $msg = '';
        $blogPostObj = new BlogPost();
        $blogPostObj->author_id = Auth::user()->id;
        $blogPostObj->author_name = Auth::user()->name;
        $blogPostObj->id = 0;
        $blogPostObj->show_follow = 1;
        $blogPostObj->show_index = 1;
        $blogPostObj->sts = 1;

        $blogCategories = BlogCategory::where('sts', 1)->get();

        return view('back.blog.create')
            ->with('blogPostObj', $blogPostObj)
            ->with('blogCategories', $blogCategories)
            ->with('title', $title)
            ->with('msg', $msg);
    }

    public function store(BlogPostBackFormRequest $request)
    {
        $blogPostObj = new BlogPost();
        $blogPostObj = $this->setBlogPostValues($request, $blogPostObj);
        $blogPostObj->save();

        /******************************* */
        /******************************* */
        $recordUpdateHistoryData = [
            'record_id' => $blogPostObj->id,
            'record_title' => $blogPostObj->title,
            'record_link' => url('adminmedia/blog/' . $blogPostObj->id . '/edit'),
            'model_or_table' => 'BlogPost',
            'admin_id' => auth()->user()->id,
            'ip' => request()->ip(),
            'draft' => json_encode($blogPostObj->toArray()),
        ];
        recordUpdateHistory($recordUpdateHistoryData);
        /******************************* */
        /******************************* */

        session(['message' => 'Blog Post has been added!', 'type' => 'success']);

        return Redirect::route('blog.posts.index');
    }
    public function edit(BlogPost $blogPostObj)
    {
        $title = FindInsettingArr('business_name') . ': Blog Management';
        $msg = '';

        $blogCategories = BlogCategory::where('sts', 1)->get();
        return view('back.blog.edit')
            ->with('blogPostObj', $blogPostObj)
            ->with('blogCategories', $blogCategories)
            ->with('title', $title)
            ->with('msg', $msg);
    }
    public function update(BlogPostBackFormRequest $request, BlogPost $blogPostObj)
    {
        $blogPostObj = $this->setBlogPostValues($request, $blogPostObj);
        $blogPostObj->save();
        /******************************* */
        /******************************* */
        $recordUpdateHistoryData = [
            'record_id' => $blogPostObj->id,
            'record_title' => $blogPostObj->title,
            'record_link' => url('adminmedia/blog/' . $blogPostObj->id . '/edit'),
            'model_or_table' => 'BlogPost',
            'admin_id' => auth()->user()->id,
            'ip' => request()->ip(),
            'draft' => json_encode($blogPostObj->toArray()),
        ];
        recordUpdateHistory($recordUpdateHistoryData);
        /******************************* */
        /******************************* */
        session(['message' => 'Blog Post has been updated!', 'type' => 'success']);
        return Redirect::route('blog.posts.index');
    }
    public function updateBlogPostIsFeatured(Request $request)
    {
        $blogPostObj = BlogPost::find($request->id);
        $blogPostObj = $this->setBlogPostIsFeatured($request, $blogPostObj);
        $blogPostObj->update();
        /******************************* */
        /******************************* */
        $recordUpdateHistoryData = [
            'record_id' => $blogPostObj->id,
            'record_title' => $blogPostObj->title,
            'record_link' => url('adminmedia/blog-post/' . $blogPostObj->id . '/edit'),
            'model_or_table' => 'BlogPost',
            'admin_id' => auth()->user()->id,
            'ip' => request()->ip(),
            'draft' => json_encode($blogPostObj->toArray()),
        ];
        recordUpdateHistory($recordUpdateHistoryData);
        /******************************* */
        /******************************* */
        echo 'Done Successfully!';
        exit;
    }
    public function updateBlogPostStatus(Request $request)
    {
        $blogPostObj = BlogPost::find($request->id);
        $blogPostObj = $this->setBlogPostStatus($request, $blogPostObj);
        $blogPostObj->save();
        /******************************* */
        /******************************* */
        $recordUpdateHistoryData = [
            'record_id' => $blogPostObj->id,
            'record_title' => $blogPostObj->title,
            'record_link' => url('adminmedia/blog/' . $blogPostObj->id . '/edit'),
            'model_or_table' => 'BlogPost',
            'admin_id' => auth()->user()->id,
            'ip' => request()->ip(),
            'draft' => json_encode($blogPostObj->toArray()),
        ];
        recordUpdateHistory($recordUpdateHistoryData);
        /******************************* */
        /******************************* */
        echo 'Done Successfully!';
        exit;
    }

    public function destroy(BlogPost $blogPostObj)
    {
        ImageUploader::deleteImage('blog', $blogPostObj->featured_img, true);
        BlogComment::where('post_id', $blogPostObj->id)->delete();
        $blogPostObj->delete();
        echo 'ok';
    }
    public function uploadFeaturedImage(BlogPostFeaturedImageBackFormRequest $request)
    {
        if ($request->hasFile('blog_post_featured_img_file')) {
            $newName = $request->input('newName', '');
            $oldName = $request->input('oldName', '');
            if (!empty($oldName)) {
                ImageUploader::deleteImage('blog', $oldName, true);
            }
            $image = $request->file('blog_post_featured_img_file');
            $fileName = ImageUploader::UploadImage('blog', $image, $newName, 1600, 1600, true);
            
            $returnArr = ['fileName' => $fileName, 'image' => '<img src="' . getImage('blog', $fileName, 'thumb') . '" height="150">'];
            echo json_encode($returnArr);
        }
    }

    public function updateCommentStatus(Request $request)
    {
        $id = $request->id;
        if ($id == '') {
            echo 'error';
            return;
        }
        $status = $request->status;
        if ($status == '') {
            echo 'invalid current status provided.';
            return;
        }
        if ($status == 'reviewed') {
            $new_status = 'unreviewed';
        } else {
            $new_status = 'reviewed';
        }
        $blogComment = BlogComment::find($id);
        $blogComment->reviewed_status = $new_status;
        $blogComment->save();
        echo $new_status;
        return;
    }
    public function comments(Request $request)
    {
        $blogComments = BlogComment::where('post_id', $request->id)->get();
        return view('back.blog.comments', compact('blogComments'));
    }
    public function deleteComment(Request $request)
    {
        if (isset($request->id)) {
            BlogComment::destroy($request->id);
        }
        echo 'done';
        return;
    }
}

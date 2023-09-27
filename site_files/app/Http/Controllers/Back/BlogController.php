<?php
namespace App\Http\Controllers\Back;
use App\Http\Controllers\Controller;
use App\Models\Back\BlogCategory;
use App\Models\Back\BlogComment;
use App\Models\Back\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = FindInsettingArr('business_name') . ': Blog Posts Management';
        $msg = '';
        $all_categories = BlogCategory::all();
        $result = DB::select(' select *, (select count(comm.ID) from blog_comments as comm where comm.post_id = blog.ID AND comm.reviewed_status= "unreviewed") as total_unrevised_comments  from blog_posts as blog Order By dated DESC');
        return view('back.blog.index', compact('title', 'msg', 'all_categories', 'result'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
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
    /**
     * Show all comments.
     *
     * @return \Illuminate\Http\Response
     */
    public function comments(Request $request)
    {
        $blogComments = BlogComment::where('post_id', $request->id)->get();
        return view('back.blog.comments', compact('blogComments'));
    }
    /**
     * Show all comments.
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteComment(Request $request)
    {
        if (isset($request->id)) {
            BlogComment::destroy($request->id);
        }
        echo 'done';
        return;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'heading' => 'required',
            'post_slug' => 'required',
            'editor1' => 'required',
        ]);
        $page_slug = $request->post_slug;
        $slugs = $page_slug;
        if ($request->blog_cat != '') {
            $category_Ids = implode(',', $request->blog_cat);
        } else {
            $category_Ids = '';
        }
        $blog = new BlogPost();
        $blog->title = $request->heading;
        $blog->author_id = Auth::user()->id;
        $blog->cate_ids = $category_Ids;
        $blog->post_slug = $slugs;
        $blog->description = myform_admin_cms_filter($request->editor1);
        if (!empty($request->featured_img)) {
            $blog->featured_img = $request->featured_img;
        }
        $blog->featured_img_title = $request->featured_img_title;
        $blog->featured_img_alt = $request->featured_img_alt;
        $blog->meta_title = ($request->meta_title == '') ? $request->heading : $request->meta_title;
        $blog->meta_keywords = $request->meta_keywords;
        $blog->meta_description = $request->meta_description;
        $blog->canonical_url = $request->canonical_url;
        $blog->dated = $request->input('datepicker', date('Y-m-d H:i:s'));
        $blog->save();
        return response()->json(['success' => 'New Blog Created Successfully.' . $request->module_id]);
    }
    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $blogPost = BlogPost::find($id);
        $blogPost->dated = date('Y-m-d', strtotime($blogPost->dated));
        return json_encode($blogPost);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        if ($id == '') {
            echo 'error';
            return;
        }
        $blogCattegory = BlogPost::find($id);
        $status = $blogCattegory->sts;
        if ($status == '') {
            echo 'invalid current status provided.';
            return;
        }
        if ($status == 'active') {
            $new_status = 'blocked';
        } else {
            $new_status = 'active';
        }
        $blogCattegory->sts = $new_status;
        $blogCattegory->update();
        echo $new_status;
        return;
    }
    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'cms_id' => 'required',
            'heading' => 'required',
            'post_slug' => 'required',
            'editor1' => 'required',
        ]);
        $blog = BlogPost::find($request->cms_id);
        $page_slug = $request->post_slug;
        $slugs = $page_slug;
        if ($request->blog_cat != '') {
            $category_Ids = implode(',', $request->blog_cat);
        } else {
            $category_Ids = '';
        }
        $blog->title = $request->heading;
        $blog->author_id = Auth::user()->id;
        $blog->cate_ids = $category_Ids;
        $blog->post_slug = $slugs;
        $blog->description = myform_admin_cms_filter($request->editor1);
        $blog->meta_title = $request->meta_title;
        $blog->meta_keywords = $request->meta_keywords;
        if (!empty($request->featured_img)) {
            $blog->featured_img = $request->featured_img;
        }
        $blog->featured_img_title = $request->featured_img_title;
        $blog->featured_img_alt = $request->featured_img_alt;
        $blog->dated = $request->input('datepicker', date('Y-m-d H:i:s'));
        $blog->meta_description = $request->meta_description;
        $blog->canonical_url = $request->canonical_url;
        $blog->save();
        return response()->json(['success' => 'Blog Post Successfully updated.' . $request->module_id]);
    }
    public function removeFeaturedImage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'folder' => 'required',
        ]);
        if ($validator->passes()) {
            $blog = BlogPost::find($request->id);
            if (!empty($blog->featured_img)) {
                unlink(storage_path_to_uploads($request->folder . '/' . $blog->featured_img));
            }
            $blog->featured_img = '';
            $blog->save();
            echo 'done';
        } else {
            echo 'error';
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        BlogComment::where('post_id', $id)->delete();
        BlogPost::destroy($id);
        echo 'done';
        return;
    }
}

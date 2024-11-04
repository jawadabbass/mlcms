<?php
namespace App\Http\Controllers\Back;
use App\Models\Back\BlogCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
class BlogCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = FindInsettingArr('business_name') . ': Blog Categories Management';
        $msg = '';
        $result = BlogCategory::all();
        return view('back.blog.categories', compact('title', 'msg', 'result'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' =>  'required',
            'cate_slug' => 'required',
            'editor1' => 'required'
        ]);
        $cate_slug = $request->cate_slug;
        $blogCategory = new BlogCategory();
        $blogCategory->cate_title = $request->title;
        $blogCategory->cate_slug = $cate_slug;
        $blogCategory->cate_description = myform_admin_cms_filter($request->editor1);
        $blogCategory->dated = date("Y-m-d H:i:s");
        $blogCategory->save();
        session(['message' => 'Added Successfully', 'type' => 'success']);
        return redirect(route('blog_categories.index'));
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        if ($id == '') {
            echo 'error';
        }
        $blogCattegory = BlogCategory::find($id);
        $status = $blogCattegory->sts;
        if ($status == '') {
            echo 'invalid current status provided.';
        }
        if ($status == 1) {
            $new_status = 0;
        } else {
            $new_status = 1;
        }
        $blogCattegory->sts = $new_status;
        $blogCattegory->update();
        echo $new_status;
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $blogCategory = BlogCategory::find($id);
        return json_encode($blogCategory);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' =>  'required',
            'cate_slug' => 'required',
            'editor1' => 'required'
        ]);
        $cate_slug = $request->cate_slug;
        $blogCategory = BlogCategory::find($request->category_id);
        $blogCategory->cate_title = $request->title;
        $blogCategory->cate_slug = $cate_slug;
        $blogCategory->cate_description = myform_admin_cms_filter($request->editor1);
        $blogCategory->save();
        //	    echo "Saved";
        session(['message' => 'Updated Successfully', 'type' => 'success']);
        return redirect(route('blog_categories.index'));
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        BlogCategory::destroy($id);
        return json_encode(array("status" => true));
    }
}

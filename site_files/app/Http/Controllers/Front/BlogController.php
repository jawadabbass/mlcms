<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Back\BlogCategory;
use App\Models\Back\BlogPost;
use App\Models\Back\CmsModuleData;
use Illuminate\Http\Request;

class BlogController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$postData = CmsModuleData::where('sts', 1)->where('post_slug', 'blog')->first();
		$seoArr = array('title' => 'Blog | ' . FindInsettingArr('business_name'));
		if (!empty($postData)) {
			$seoArr = getSeoArrayModule($postData->id);
		}
		$blogData = BlogPost::where('sts', 1)->orderBy('dated', 'DESC')->paginate(10);
		$blog_categories = BlogCategory::all();
		return view('front.blog.index', compact('seoArr', 'blogData', 'blog_categories'));
	}
	public function search()
	{
		$postData = CmsModuleData::where('sts', 1)->where('post_slug', 'blog')->first();
		$search = trim($_GET['s']) ?? '';
		if (isset($_GET['s'])) {
			$search = $_GET['s'];
		}

		if ($search == '') {
			return redirect('blog');
		}
		$seoArr = array();
		if (!empty($postData)) {
			$seoArr = getSeoArrayModule($postData->id);
		}
		$blogData = BlogPost::where(function ($query) use ($search) {
			$query->where('title', 'like', '%' . $search . '%')
				->orWhere('description', 'like', '%' . $search . '%');
		})
			->where('sts', 1)->paginate(10);
		$blog_categories = BlogCategory::all();
		return view('front.blog.index', compact('seoArr', 'blogData', 'blog_categories'));
	}
	public function category($category)
	{
		$blogCategory = BlogCategory::where('cate_slug', $category)
			->where('sts', 1)
			->first();
		if (!$blogCategory) {
			return redirect('blog');
		}
		$postData = CmsModuleData::where('sts', 1)->where('post_slug', 'blog')->first();

		$seoArr = array('title' => $blogCategory->cate_title . ' Category | ' . FindInsettingArr('business_name'));

		$blogData = BlogPost::where('sts', 1)
			->whereRaw("FIND_IN_SET(" . $blogCategory->id . ",cate_ids)")
			->paginate(10);
		$blog_categories = BlogCategory::all();
		return view('front.blog.index', compact('seoArr', 'blogData', 'blog_categories'));
	}
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public
	function create()
	{
		//
	}
	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public
	function store(Request $request)
	{
		//
	}
	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public
	function show($id)
	{
		$slug = $id;
		$obj_result = BlogPost::with('author', 'comments')->where('post_slug', $slug)->first();
		if (isset($obj_result->title)) {
			$seoArr = getSeoArrayBlog($obj_result->id);
			$blog_post_details = $obj_result;
			$blog_comments = $obj_result->comments;
			$blog_categories = BlogCategory::all();
			return view('front.blog.show', compact('seoArr', 'blog_post_details', 'blog_comments', 'blog_categories'));
		} else {
		}
	}
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public
	function edit($id)
	{
		//
	}
	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public
	function update(Request $request, $id)
	{
		//
	}
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public
	function destroy($id)
	{
		//
	}
}

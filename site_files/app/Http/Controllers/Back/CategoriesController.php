<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Back\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CategoriesController extends Controller
{
	public $settingArr = array(
		'mainTitle' => 'Status',
		'mainPageTitle' => 'Categories',
		'contr_name' => 'categories_reg',
		'view_add' => 'add_ajax',
		'view_edit' => 'edit_ajax',
		'view_main' => 'index_view',
		'dbName' => 'categories',
		'dbId' => 'id',
	);
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		$catId = $request->cat;
		if ($catId == '0' || $catId == '') {
			$catId = 0;
		}
		$catName = '';
		$title = FindInsettingArr('business_name') . ': Categories Management';
		$parentCategory = Category::find($catId);
		$allParentCategory = Category::orderBy('orderr', 'ASC')->get()->toArray();
		$result = Category::where('cat', $catId)->orderBy('orderr', 'ASC')->get();
		$settingArr = $this->settingArr;
		return view('back.categories.index', compact('catName', 'title', 'result', 'catId', 'settingArr', 'allParentCategory'));
	}
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return string
	 */
	public function create(Request $request)
	{
		$action = $request->action;
		$updateRecordsArray = $request->recordsArray;
		if ($action == "updateRecordsListings") {
			$listingCounter = 1;
			foreach ($updateRecordsArray as $recordIDValue) {
				$category = Category::find($recordIDValue);
				$category->orderr = $listingCounter;
				$category->save();
				$listingCounter = $listingCounter + 1;
				echo $listingCounter;
			}
		}
	}
	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$category = new Category();
		$category->title = $request->title;
		$category->orderr = 0;
		$category->cat = $request->catId;
		$category->slug = $request->slug;
		$category->save();
		session(['message' => 'Added Successfully', 'type' => 'success']);
		return json_encode(['msg' => 'done']);
	}
	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		//
	}
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$category = Category::find($id);
		return json_encode($category);
	}
	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		$this->validate($request, [
			// 'cimg' => 'required|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
		]);
		$category = Category::find($request->edit_id);
		if ($request->hasFile('cimg')) {
			$image = $request->file('cimg');
			$name = time() . '.' . $image->getClientOriginalExtension();
			$destinationPath = storage_uploads('categories');
			$image->move($destinationPath, $name);
			$category->img = $name;
		}
		$category->title = $request->edit_title;
		$category->save();
		session(['message' => 'Updated Successfully', 'type' => 'success']);
		return back();
		// return json_encode(['success' => 'done']);
	}
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		Category::destroy($id);
		return json_encode(array("status" => true));
	}
}

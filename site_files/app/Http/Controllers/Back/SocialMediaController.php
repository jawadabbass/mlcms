<?php

namespace App\Http\Controllers\Back;

use App\Models\Back\SocialMedia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class SocialMediaController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		hasPermission('Can Manage Social Media');
		$title = FindInsettingArr('business_name') . ': Social Media Management';
		$msg = '';
		$result = SocialMedia::orderBy('item_order', 'ASC')->get();
		return view('back.social_media.index', compact('title', 'msg', 'result'));
	}
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create(Request $request)
	{
		hasPermission('Can Add Social Media');
		$list_order = $request->list_order;
		$list = explode(',', $list_order);
		$i = 1;
		print_r($list);
		foreach ($list as $id => $value) {
			$idd = str_replace("row_", "", $value);
			$product = SocialMedia::find($idd);
			$product->item_order = $i;
			$product->save();
			$i++;
			echo $i . ' ' . $id;
		}
	}
	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		hasPermission('Can Add Social Media');
		$request->validate([
			'name' => 'required',
			'alt_tag' => 'required',
			'i_class' => 'required'
		]);
		$socialMedia = new SocialMedia();
		$socialMedia->name = $request->name;
		$socialMedia->alt_tag = $request->alt_tag;
		$socialMedia->link = addHttpLink($request->link);
		$socialMedia->i_class = $request->i_class;
		$socialMedia->dated = date("Y-m-d H:i:s");
		$socialMedia->sts = 'active';

		if (isset($_POST['open_in_new_tab'])) {
			$socialMedia->open_in_new_tab = 'Yes';
		} else {
			$socialMedia->open_in_new_tab = 'No';
		}
		$socialMedia->save();
		Session::flash('added_action', 'Created');
		return redirect(route('social_media.index'));
	}
	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		hasPermission('Can Manage Social Media');
		$widget = SocialMedia::find($id);
		return json_encode($widget);
	}
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id, Request $request)
	{
		hasPermission('Can Edit Social Media');
		if ($id == '') {
			echo 'error';
			return;
		}
		$status = $request->status;
		if ($status == '') {
			echo 'invalid current status provided.';
			return;
		}
		if ($status == 'active')
			$new_status = 'blocked';
		else
			$new_status = 'active';
		$widget = SocialMedia::find($id);
		$widget->sts = $new_status;
		$widget->save();
		echo $new_status;
		return;
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
		hasPermission('Can Edit Social Media');
		$request->validate([
			'edit_name' => 'required',
			'edit_alt_tag' => 'required',
			'edit_i_class' => 'required',
		]);
		$socialMedia = SocialMedia::find($request->socail_media_id);
		$socialMedia->name = $request->edit_name;
		$socialMedia->alt_tag = $request->edit_alt_tag;
		$socialMedia->link = $request->edit_link;
		$socialMedia->i_class = $request->edit_i_class;
		$socialMedia->sts = 'active';
		if (isset($_POST['edit_open_in_new_tab'])) {
			$socialMedia->open_in_new_tab = 'Yes';
		} else {
			$socialMedia->open_in_new_tab = 'No';
		}
		$socialMedia->save();
		Session::flash('update_action', 'Created');
		return redirect(route('social_media.index'));
	}
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		hasPermission('Can Delete Social Media');
		SocialMedia::destroy($id);
		return json_encode(array("status" => true));
	}
}

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
		$socialMedia->sts = 1;

		if (isset($_POST['open_in_new_tab'])) {
			$socialMedia->open_in_new_tab = 'Yes';
		} else {
			$socialMedia->open_in_new_tab = 'No';
		}
		$socialMedia->save();
		/******************************* */
		/******************************* */
		$recordUpdateHistoryData = [
			'record_id' => $socialMedia->ID,
			'record_title' => $socialMedia->name,
			'record_link' => url('adminmedia/social_media/'.$socialMedia->ID.'/edit'),
			'model_or_table' => 'SocialMedia',
			'admin_id' => auth()->user()->id,
			'ip' => request()->ip(),
			'draft' => json_encode($socialMedia->toArray()),
		];
		recordUpdateHistory($recordUpdateHistoryData);
		/******************************* */
		/******************************* */
		session(['message' => 'Added Successfully', 'type' => 'success']);
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
		$new_status = 0;
		if ((int)$id > 0) {
			$socialMedia = SocialMedia::find((int)$id);
			$status = (int)$socialMedia->sts;
			if ($status == 1) {
				$new_status = 0;
			} else {
				$new_status = 1;
			}
			$socialMedia->sts = $new_status;
			$socialMedia->save();

			/******************************* */
			/******************************* */
			$recordUpdateHistoryData = [
				'record_id' => $socialMedia->ID,
				'record_title' => $socialMedia->name,
				'record_link' => url('adminmedia/social_media/'.$socialMedia->ID.'/edit'),
				'model_or_table' => 'SocialMedia',
				'admin_id' => auth()->user()->id,
				'ip' => request()->ip(),
				'draft' => json_encode($socialMedia->toArray()),
			];
			recordUpdateHistory($recordUpdateHistoryData);
			/******************************* */
			/******************************* */
		}
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
		$socialMedia->sts = 1;
		if (isset($_POST['edit_open_in_new_tab'])) {
			$socialMedia->open_in_new_tab = 'Yes';
		} else {
			$socialMedia->open_in_new_tab = 'No';
		}
		$socialMedia->save();
		/******************************* */
        /******************************* */
        $recordUpdateHistoryData = [
            'record_id' => $socialMedia->ID,
            'record_title' => $socialMedia->name,
            'record_link' => url('adminmedia/social_media/'.$socialMedia->ID.'/edit'),
			'model_or_table' => 'SocialMedia',
            'admin_id' => auth()->user()->id,
            'ip' => request()->ip(),
            'draft' => json_encode($socialMedia->toArray()),
        ];
        recordUpdateHistory($recordUpdateHistoryData);
        /******************************* */
        /******************************* */
		session(['message' => 'Updated Successfully', 'type' => 'success']);
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
		SocialMedia::destroy($id);
		return json_encode(array("status" => true));
	}
}

<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Back\Menu;
use App\Models\Back\MenuType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class MenuController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		$menu_types = MenuType::all();
		$position = $request->position;
		if ($position == '') {
			$position = 'top';
		}
		$menuTypes = MenuType::where('menu_type', $position)->first();
		$type = MenuType::where('menu_type', $position)->first();
		$title = config('Constants.SITE_NAME') . ': Menu\'s Management';
		$parent_pages = Menu::where('status', 'Y')
			->where('parent_id', 0)
			->where('menu_types', $menuTypes->id)
			->orderBy('menu_sort_order', 'ASC')
			->get();
		$data['msg'] = '';
		return view('back.menu.index', compact('menu_types', 'type', 'title', 'parent_pages', 'position'));
	}
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
	}
	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'menu_label' => 'required',
			'menu_url' => 'required',
			'menu_type' => 'required'
		]);
		if ($validator->passes()) {
			$menu_url = $request->menu_url;
			$menu_types = $request->menu_type;
			if (isset($menu_types) && !empty($menu_types)) {
				foreach ($menu_types as $menu_type_id) {
					$max_orders = DB::table('menus')->where('menu_types', $menu_type_id)->max('menu_sort_order');
					$max_order = $max_orders + 1;
					$menu = new Menu();
					$menu->menu_id = 0;
					$menu->menu_label = $request->menu_label;
					$menu->menu_url = $menu_url;
					$menu->menu_types = $menu_type_id;
					$menu->menu_sort_order = $max_order;
					$menu->open_in_new_window = $request->open_in_new_window;
					$menu->show_no_follow = $request->show_no_follow;
					$menu->is_external_link = ($request->is_external_link == 'Y') ? 'Y' : 'N';
					$menu->save();
				}
			}
		} else {
			echo json_encode(array("status" => FALSE, 'errors' => $validator->errors()));
			return;
		}
		echo json_encode(array("status" => TRUE));
	}
	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id, Request $request)
	{
		$order_menu = 1;
		$items = $request->item;
		foreach ($items as $key => $item) {
			$menu = Menu::find($key);
			$menu->menu_sort_order = $order_menu;
			$menu->parent_id = (($item != 'no-parent') ? $item : 0);
			//			$array_data = array('parent_id' => ($item!='no-paren')?$item:0);
			//			$array_marge = array_merge($array_data, $menu);
			//			$this->Menu_model->update_menu_orders($key, $array_marge);
			$menu->save();
			$order_menu++;
		}
		echo 'done';
		exit;
	}
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$menu = Menu::find($id);
		return json_encode($menu);
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
		$validator = Validator::make($request->all(), [
			'menu_label' => 'required',
			'menu_url' => 'required',
		]);
		if ($validator->passes()) {
			$menu = Menu::find($id);
			$menu->menu_id = 0;
			$menu->menu_label = $request->menu_label;
			$menu->menu_url = $request->menu_url;
			$menu->open_in_new_window = $request->open_in_new_window;
			$menu->show_no_follow = $request->show_no_follow;
			$menu->is_external_link = ($request->is_external_link == 'Y') ? 'Y' : 'N';
			$menu->save();
		} else {
			echo json_encode(array("status" => FALSE, 'errors' => $validator->errors()));
			return;
		}
		echo json_encode(array("status" => TRUE));
	}
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		Menu::destroy($id);
		return json_encode(array("status" => TRUE));
	}
}

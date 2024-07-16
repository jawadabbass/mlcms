<?php

namespace App\Http\Controllers\Back;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class FrontUserController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$title = FindInsettingArr('business_name') . ': Website Users Management';
		$msg = '';
		$result = User::where('type', 'user')->orderBy('id', 'DESC')->paginate(20);
		return view('back.users.front.index', compact('title', 'msg', 'result'));
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
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
	}
	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
	}
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$title = FindInsettingArr('business_name') . ': Admin Users Management | Edit';
		$user = User::find($id);
		return view('back.users.front.edit', compact('user', 'title'));
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
		$user = User::find($id);
		$user->name = $request->admin_name;
		$user->email = $request->admin_email;
		if ($request->password == '');
		else
			$user->password = Hash::make($request->password);
		$user->save();
		session(['message' => 'Added Successfully', 'type' => 'success']);
		return redirect(route('front.index'));
	}
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		User::destroy($id);
		return json_encode(array("status" => true));
	}
}

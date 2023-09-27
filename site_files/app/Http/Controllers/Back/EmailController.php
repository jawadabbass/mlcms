<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Back\EmailTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class EmailController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		checkAccess(Auth::user(), 1);
		$title = FindInsettingArr('business_name') . ': Email Templates';
		$msg = '';
		$result = EmailTemplate::all();
		return view('back.email_template.index', compact('title', 'msg', 'result'));
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
	 * @param  \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		checkAccess(Auth::user(), 1);
		$request->validate([
			'Title' => 'required',
			'Subject' => 'required',
			'Sender' => 'required',
			'SenderName' => 'required',
			'Body' => 'required'
		]);
		$video = new EmailTemplate();
		$video->Title = $request->Title;
		$video->Subject = $request->Subject;
		$video->Sender = $request->Sender;
		$video->SenderName = $request->SenderName;
		$video->Body = $request->Body;
		$video->save();
		Session::flash('added_action', 'Template Created Successfully');
		return redirect(route('email_templates.index'));
	}
	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		checkAccess(Auth::user(), 1);
		$email = EmailTemplate::find($id);
		echo $email->Body;
		return;
	}
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		checkAccess(Auth::user(), 1);
		$emailTemplate = EmailTemplate::find($id);
		return json_encode($emailTemplate);
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
		checkAccess(Auth::user(), 1);
		$request->validate([
			'Title' => 'required',
			'Subject' => 'required',
			'Sender' => 'required',
			'SenderName' => 'required',
			'Body' => 'required'
		]);
		$video = EmailTemplate::find($id);
		$video->Title = $request->Title;
		$video->Subject = $request->Subject;
		$video->Sender = $request->Sender;
		$video->SenderName = $request->SenderName;
		$video->Body = $request->Body;
		$video->save();
		Session::flash('update_action', 'Template Created Successfully');
		return redirect(route('email_templates.index'));
	}
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		checkAccess(Auth::user(), 1);
		EmailTemplate::destroy($id);
		return json_encode(array("status" => true));
	}
}

<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Back\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ContactPagesController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$title = FindInsettingArr('business_name') . ': Contact Settings';
		$admin_user = User::all();
		$result = $admin_user;
		$setting_result = Setting::all();
		$contact_email_result = Setting::first();
		return view('back.contact_pages.index', compact('title', 'admin_user', 'result', 'contact_email_result', 'setting_result'));
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
		$validatedData = $request->validate([
			
		]);

		$setting = new Setting();
		$setting->telephone = $request->telephone;
		$setting->fax = $request->fax;
		$setting->mobile = $request->mobile;
		$setting->email = $request->email;
		$setting->address = $request->address;
		$setting->working_days = $request->working_days;
		$setting->working_hours = $request->working_hours;
		$setting->save();
		/******************************* */
        /******************************* */
        $recordUpdateHistoryData = [
            'record_id' => $setting->ID,
            'record_title' => '',
            'model_or_table' => 'Setting',
            'admin_id' => auth()->user()->id,
            'ip' => request()->ip(),
            'draft' => json_encode($setting->toArray()),
        ];
        recordUpdateHistory($recordUpdateHistoryData);
        /******************************* */
        /******************************* */
		session(['message' => 'Created Successfully', 'type' => 'success']);
		return redirect('adminmedia/manage_contact');
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
	public function edit($id, Request $request)
	{
		$setting = Setting::find($id);
		$setting->google_map_status = $request->google_map_status;
		$setting->save();
		/******************************* */
        /******************************* */
        $recordUpdateHistoryData = [
            'record_id' => $setting->ID,
            'record_title' => 'google_map_status',
            'model_or_table' => 'Setting',
            'admin_id' => auth()->user()->id,
            'ip' => request()->ip(),
            'draft' => json_encode($setting->toArray()),
        ];
        recordUpdateHistory($recordUpdateHistoryData);
        /******************************* */
        /******************************* */
		session(['message' => 'Updated Successfully', 'type' => 'success']);
		return redirect(route('manage_contact.index'));
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
		$validatedData = $request->validate([
			
		]);

		$setting = Setting::find($id);
		$setting->business_name = $request->business_name;
		$setting->telephone = $request->telephone;
		$setting->fax = $request->fax;
		$setting->mobile = $request->mobile;
		$setting->email = $request->email;
		$setting->address = $request->address;
		$setting->working_days = $request->working_days;
		$setting->working_hours = $request->working_hours;
		$setting->update();
		/******************************* */
        /******************************* */
        $recordUpdateHistoryData = [
            'record_id' => $setting->ID,
            'record_title' => '',
            'model_or_table' => 'Setting',
            'admin_id' => auth()->user()->id,
            'ip' => request()->ip(),
            'draft' => json_encode($setting->toArray()),
        ];
        recordUpdateHistory($recordUpdateHistoryData);
        /******************************* */
        /******************************* */
		session(['message' => 'Updated Successfully', 'type' => 'success']);
		return redirect('adminmedia/manage_contact');
	}

	/**
	 * Update Email addres with comma seperated list
	 * @param Request $request
	 *
	 */
	public function emailUpdate(Request $request)
	{
		$id = $request->id;
		$newEmail = $request->email;
		$type = $request->type;
		$setting = Setting::find($id);
		if ($type == 1)
			$email_data = $setting->to_email;
		elseif ($type == 2)
			$email_data = $setting->cc_email;
		else
			$email_data = $setting->bcc_email;
		$email_in_array = explode(',', $email_data);
		if (($array_kay = array_search($newEmail, $email_in_array)) !== FALSE) {
			echo "alread_avalibale";
			return;
		} else {
			if ($email_data === '')
				$newEmail .= $email_data;
			else
				$newEmail .= ',' . $email_data;
		}

		if ($type == 1)
			$setting->to_email = $newEmail;
		elseif ($type == 2)
			$setting->cc_email = $newEmail;
		else
			$setting->bcc_email = $newEmail;
		$setting->save();

		/******************************* */
        /******************************* */
        $recordUpdateHistoryData = [
            'record_id' => $setting->ID,
            'record_title' => '',
            'model_or_table' => 'Setting',
            'admin_id' => auth()->user()->id,
            'ip' => request()->ip(),
            'draft' => json_encode($setting->toArray()),
        ];
        recordUpdateHistory($recordUpdateHistoryData);
        /******************************* */
        /******************************* */
		echo "Done";
		return;
	}

	/**
	 * Delete Email addres from comma seperated list
	 * @param Request $request
	 *
	 */
	public function emailDelete(Request $request)
	{
		$id = $request->id;
		$newEmail = $request->email;
		$type = $request->type;
		$setting = Setting::find($id);
		if ($type == 1)
			$email_data = $setting->to_email;
		elseif ($type == 2)
			$email_data = $setting->cc_email;
		else
			$email_data = $setting->bcc_email;

		if ($email_data) {
			$email_in_array = explode(',', $email_data);
			if (($array_kay = array_search($newEmail, $email_in_array)) !== FALSE) {
				unset($email_in_array[$array_kay]);
				$email_in_arrays = implode(',', $email_in_array);
			} else {
				$email_in_arrays = $email_data;
			}
		} else
			return;

		if ($type == 1)
			$setting->to_email = $email_in_arrays;
		elseif ($type == 2)
			$setting->cc_email = $email_in_arrays;
		else
			$setting->bcc_email = $email_in_arrays;
		$setting->save();

		/******************************* */
        /******************************* */
        $recordUpdateHistoryData = [
            'record_id' => $setting->ID,
            'record_title' => '',
            'model_or_table' => 'Setting',
            'admin_id' => auth()->user()->id,
            'ip' => request()->ip(),
            'draft' => json_encode($setting->toArray()),
        ];
        recordUpdateHistory($recordUpdateHistoryData);
        /******************************* */
        /******************************* */
		echo "Done";
		return;
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		Setting::destroy($id);
		return json_encode(array("status" => true));
	}
}

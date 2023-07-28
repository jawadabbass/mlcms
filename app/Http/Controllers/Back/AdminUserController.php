<?php

namespace App\Http\Controllers\Back;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Back\AdminUserBackFormRequest;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = FindInsettingArr('business_name') . ': Admin Users Management';
        $msg = '';
        $result = User::where('type', '!=', 'user')->get();
        return view('back.users.admin.index', compact('title', 'msg', 'result'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user()->type != config('Constants.USER_TYPE_SUPER_ADMIN'))
            return redirect(route('admin.index'));
        $title = FindInsettingArr('business_name') . ': Admin Users Management | Add new';
        return view('back.users.admin.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminUserBackFormRequest $request)
    {
        $user = new User();
        $user->name = $request->admin_name;
        $user->email = $request->admin_email;
        $user->password = Hash::make($request->password);
        $user->type = $request->type;
        $user->save();
        Session::flash('added_action', 'Added Successfully');
        return redirect(route('admin.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Auth::user()->type != config('Constants.USER_TYPE_SUPER_ADMIN')) {
            return redirect(route('admin.index'));
        }

        $title = FindInsettingArr('business_name') . ': Admin Users Management | Info';
        $msg = '';
        $arrLinks = \App\Helpers\DashboardLinks::$arrLinks;
        $passArrSuperAdmin = array();
        foreach ($arrLinks as $key => $val) {
            if (in_array(config('Constants.USER_TYPE_SUPER_ADMIN'), $val['user_type'])) {
                $passArrSuperAdmin[$val[2]] = $val[0];
            }
        }

        $passArrSubAdmin = array();
        foreach ($arrLinks as $key => $val) {
            if (in_array(config('Constants.USER_TYPE_NORMAL_ADMIN'), $val['user_type'])) {
                $passArrSubAdmin[$val[2]] = $val[0];
            }
        }

        $passArrReps = array();
        foreach ($arrLinks as $key => $val) {
            if (in_array(config('Constants.USER_TYPE_REPS_ADMIN'), $val['user_type'])) {
                $passArrReps[$val[2]] = $val[0];
            }
        }
        return view('back.users.admin.admin_info', compact('title', 'msg', 'passArrSuperAdmin', 'passArrSubAdmin', 'passArrReps'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = FindInsettingArr('business_name') . ': Admin Users Management | Add new';
        $user = User::find($id);
        return view('back.users.admin.edit', compact('user', 'title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminUserBackFormRequest $request, $id)
    {
        $user = User::find($id);
        $user->name = $request->admin_name;
        $user->email = $request->admin_email;
        if ($request->password == '');
        else
            $user->password = Hash::make($request->password);
        $user->type = $request->type;
        $user->save();
        Session::flash('added_action', 'Added Successfully');
        return redirect(route('admin.index'));
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

<?php

namespace App\Http\Controllers\Back;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Back\UserFormRequest;
use App\Models\Back\RoleUser;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        hasPermission('Can Manage Admin Users');

        return view('back.admin_users.index');
    }

    public function fetchUsersAjax(Request $request)
    {
        hasPermission('Can Manage Admin Users');

        $users = User::select('*')->where('type', 'like', 'admin')->where('is_super_admin', 0)->withoutGlobalScopes();
        return Datatables::of($users)
            ->filter(function ($query) use ($request) {
                if ($request->has('name') && !empty($request->name)) {
                    $query->where('users.name', 'like', "%{$request->get('name')}%");
                }
                if ($request->has('email') && !empty($request->email)) {
                    $query->where('users.email', 'like', "%{$request->get('email')}%");
                }
            })
            ->addColumn('name', function ($users) {
                return Str::limit($users->name, 150, '...');
            })
            ->addColumn('email', function ($users) {
                return Str::limit($users->email, 250, '...');
            })
            ->addColumn('action', function ($users) {
                $editUser = $deleteUser = '';
                if(isAllowed('Edit Admin User')){
                    $editUser = '<a href="' . route('admin.user.edit', [$users->id]) . '" class="btn btn-warning mr-2" title="Edit details">
                    <i class="fa fa-edit"></i>
                </a>';
                }
                if(isAllowed('Delete Admin User')){
                    $deleteUser = '<a href="javascript:void(0);" onclick="deleteUser(\'' . $users->id . '\');" class="btn btn-danger" title="Delete">
                    <i class="fa fa-trash"></i>
                </a>';
                }
                return $editUser.$deleteUser;
            })
            ->rawColumns(['action','name','email'])
            ->orderColumns(['name','email'], ':column $1')
            ->setRowId(function ($users) {
                return 'usersDtRow' . $users->id;
            })
            ->make(true);
        //$query = $dataTable->getQuery()->get();
        //return $query;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        hasPermission('Add new Admin User');

        $user = new User();
        return view('back.admin_users.create')->with('user', $user);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserFormRequest $request)
    {
        hasPermission('Add new Admin User');

        $user = new User();
        $user = $this->setUserValues($request, $user);
        $user->save();

        $this->setUserRoles($request, $user);
        /*         * ************************************ */
        flash('Admin user has been added!', 'success');
        return Redirect::route('admin.users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        hasPermission('Edit Admin User');

        return view('back.admin_users.edit')
            ->with('user', $user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserFormRequest $request, User $user)
    {
        hasPermission('Edit Admin User');

        $user = $this->setUserValues($request, $user);
        $user->save();

        $this->setUserRoles($request, $user);
        /*         * ************************************ */
        flash('User has been updated!', 'success');
        return Redirect::route('admin.users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        hasPermission('Delete Admin User');
        $user->delete();
        echo 'ok';
    }

    private function setUserValues($request, $user){
        $user->type = 'admin';
        $user->name = $request->input('name');
        $user->email = $request->input('email');

        if(!empty($request->input('password', ''))){
            $user->password = Hash::make($request->input('password'));
        }

        return $user;
    }

    private function setUserRoles($request, $user){

        $roleIds = $request->role_ids;
        if(count($roleIds) > 0){
            RoleUser::where('user_id', 'like', $user->id)->delete();
            foreach($roleIds as $role_id){
                $userRole = new RoleUser();
                $userRole->id = Str::uuid();
                $userRole->user_id = $user->id;
                $userRole->role_id = $role_id;
                $userRole->save();
            }
        }
    }
}

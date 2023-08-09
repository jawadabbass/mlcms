<?php

namespace App\Http\Controllers\Back;

use App\Models\Back\Role;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Back\PermissionRole;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RoleFormRequest;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Back\RoleUser;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        hasPermission('View Roles');

        return view('back.role.index');
    }

    public function fetchRolesAjax(Request $request)
    {
        hasPermission('View Roles');

        $roles = Role::select('*')->onlyCompany()->withoutGlobalScopes();
        return Datatables::of($roles)
            ->filter(function ($query) use ($request) {
                if ($request->has('title') && !empty($request->title)) {
                    $query->where('roles.title', 'like', "%{$request->get('title')}%");
                }
            })
            ->addColumn('title', function ($roles) {
                return Str::limit($roles->title, 100, '...');
            })
            ->addColumn('action', function ($roles) {
                $editStr = $deleteStr = '';
                if(isAllowed('Edit Role')){
                    $editStr = '<a href="' . route('roles.edit', [$roles->id]) . '" class="btn btn-sm btn-clean btn-icon" title="Edit details">
                    <i class="la la-edit"></i>
                </a>';
                }
                if(isAllowed('Delete Role')){
                    $deleteStr = '<a href="javascript:void(0);" onclick="deleteRole(\'' . $roles->id . '\');" class="btn btn-sm btn-clean btn-icon" title="Delete">
                    <i class="la la-trash"></i>
                </a>';
                }
                return '
                <div class="dropdown dropdown-inline">
                    <a href="javascript:;" class="btn btn-sm btn-clean btn-icon" data-toggle="dropdown">
                        <i class="la la-cog"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                        <ul class="nav nav-hoverable flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <i class="nav-icon la la-edit"></i>
                                    <span class="nav-text">Edit Details</span>
                                </a>
                            </li>

                        </ul>
                    </div>
                </div>'.$editStr.$deleteStr;
            })
            ->rawColumns(['action', 'title'])
            ->orderColumns(['role', 'status'], ':column $1')
            ->setRowId(function ($roles) {
                return 'rolesDtRow' . $roles->id;
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
        hasPermission('Add new Role');

        $role = new Role();
        return view('back.role.create')->with('role', $role);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleFormRequest $request)
    {
        hasPermission('Add new Role');

        $role = new Role();
        $role->title = $request->input('title');
        $role->created_by_company_id = Auth::user()->company_id;
        $role->created_by_user_id = Auth::id();
        $role->save();
        /*         * ************************************ */

        $this->setRolePermissions($request, $role);

        flash('Role has been added!', 'success');
        return Redirect::route('roles.index');
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
    public function edit(Role $role)
    {
        hasPermission('Edit Role');

        return view('back.role.edit')
            ->with('role', $role);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoleFormRequest $request, Role $role)
    {
        hasPermission('Edit Role');

        $role->title = $request->input('title');
        $role->created_by_company_id = Auth::user()->company_id;
        $role->save();
        /*         * ************************************ */

        $this->setRolePermissions($request, $role);

        flash('Role has been updated!', 'success');
        return Redirect::route('roles.index');
    }

    private function setRolePermissions($request, $role){

        $permissionIds = $request->permission_ids;
        if(count($permissionIds) > 0){
            PermissionRole::where('role_id', 'like', $role->id)->delete();
            foreach($permissionIds as $permission_id){
                $rolePermission = new PermissionRole();
                $rolePermission->role_id = $role->id;
                $rolePermission->permission_id = $permission_id;
                $rolePermission->save();
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        hasPermission('Delete Role');

        PermissionRole::where('role_id', 'like', $role->id)->delete();
        RoleUser::where('role_id', 'like', $role->id)->delete();
        $role->delete();
        echo 'ok';
    }

    public function makeActiveRole(Request $request)
    {
        hasPermission('Edit Role');

        $id = $request->input('id');
        try {
            $role = Role::withoutGlobalScopes()->findOrFail($id);
            $role->status = 'active';
            $role->update();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

    public function makeNotActiveRole(Request $request)
    {
        hasPermission('Edit Role');

        $id = $request->input('id');
        try {
            $role = Role::withoutGlobalScopes()->findOrFail($id);
            $role->status = 'inactive';
            $role->update();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

    public function sortRoles()
    {
        hasPermission('Sort Roles');
        return view('back.role.sort');
    }

    public function rolesSortData(Request $request)
    {
        hasPermission('Sort Roles');

        $roles = Role::select('roles.id', 'roles.title', 'roles.sort_order')
        ->get();
        $str = '<ul id="sortable">';
        if ($roles != null) {
            foreach ($roles as $role) {
                $str .= '<li class="ui-state-default" id="' . $role->id . '"><i class="fa fa-sort"></i>' . $role->title . '</li>';
            }
        }
        echo $str . '</ul>';
    }

    public function rolesSortUpdate(Request $request)
    {
        hasPermission('Sort Roles');

        $rolesOrder = $request->input('rolesOrder');
        $rolesOrderArray = explode(',', $rolesOrder);
        $count = 1;
        foreach ($rolesOrderArray as $roleId) {
            $role = Role::withoutGlobalScopes()->find($roleId);
            $role->sort_order = $count;
            $role->update();
            $count++;
        }
    }
}

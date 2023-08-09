<?php

namespace App\Http\Controllers\Back;

use App\Models\Back\Permission;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Back\PermissionRole;
use App\Models\Back\PermissionGroup;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\PermissionFormRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        hasPermission('View Permissions');

        return view('back.permission.index');
    }

    public function fetchPermissionsAjax(Request $request)
    {
        hasPermission('View Permissions');

        $permissions = Permission::select('*')->withoutGlobalScopes();
        return Datatables::of($permissions)
            ->filter(function ($query) use ($request) {
                if ($request->has('title') && !empty($request->title)) {
                    $query->where('permissions.title', 'like', '%'.$request->get('title').'%');
                }
                if ($request->has('permission_group_id') && !empty($request->permission_group_id)) {
                    $query->where('permissions.permission_group_id', $request->get('permission_group_id'));
                }
            })
            ->addColumn('title', function ($permissions) {
                return Str::limit($permissions->title, 100, '...');
            })
            ->addColumn('permission_group_id', function ($permissions) {
                $str = '<select class="form-control" name="permission_group_id" id="permission_group_id_'.$permissions->id.'" onchange="updatePermissionGroupId(\''.$permissions->id.'\', \''.$permissions->permission_group_id.'\', this.value);">';
                $str .= generatePermissionGroupsDropDown($permissions->permission_group_id);
                $str .= '</select>';
                return $str;
            })
            ->addColumn('action', function ($permissions) {
                $editStr = $deleteStr = '';
                if(isAllowed('Edit Permission')){
                    $editStr = '<a href="' . route('permissions.edit', [$permissions->id]) . '" class="btn btn-sm btn-clean btn-icon" title="Edit details">
                    <i class="la la-edit"></i>
                </a>';
                }
                if(isAllowed('Delete Permission')){
                    $deleteStr = '<a href="javascript:void(0);" onclick="deletePermission(\'' . $permissions->id . '\');" class="btn btn-sm btn-clean btn-icon" title="Delete">
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
            ->rawColumns(['action', 'title', 'permission_group_id'])
            ->orderColumns(['title', 'status'], ':column $1')
            ->setRowId(function ($permissions) {
                return 'permissionDtRow' . $permissions->id;
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
        hasPermission('Add new Permission');

        $permission = new Permission();
        $permissionGroups = PermissionGroup::all();
        return view('back.permission.create')
        ->with('permission', $permission)
        ->with('permissionGroups', $permissionGroups);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PermissionFormRequest $request)
    {
        hasPermission('Add new Permission');

        $permission = new Permission();
        $permission->title = $request->input('title');
        $permission->permission_group_id = $request->input('permission_group_id');
        $permission->save();
        /*         * ************************************ */
        flash('Permission has been added!', 'success');
        return Redirect::route('permissions.index');
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
    public function edit(Permission $permission)
    {
        hasPermission('Edit Permission');

        $permissionGroups = PermissionGroup::all();
        return view('back.permission.edit')
            ->with('permission', $permission)
            ->with('permissionGroups', $permissionGroups);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PermissionFormRequest $request, Permission $permission)
    {
        hasPermission('Edit Permission');

        $permission->title = $request->input('title');
        $permission->permission_group_id = $request->input('permission_group_id');
        $permission->save();
        /*         * ************************************ */
        flash('Permission has been updated!', 'success');
        return Redirect::route('permissions.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        hasPermission('Delete Permission');

        PermissionRole::where('permission_id', 'like', $permission->id)->delete();
        $permission->delete();
        echo 'ok';
    }

    public function makeActivePermission(Request $request)
    {
        hasPermission('Edit Permission');

        $id = $request->input('id');
        try {
            $permission = Permission::withoutGlobalScopes()->findOrFail($id);
            $permission->status = 'active';
            $permission->update();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

    public function makeNotActivePermission(Request $request)
    {
        hasPermission('Edit Permission');

        $id = $request->input('id');
        try {
            $permission = Permission::withoutGlobalScopes()->findOrFail($id);
            $permission->status = 'inactive';
            $permission->update();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

    public function sortPermissions()
    {
        hasPermission('Sort Permissions');

        return view('back.permission.sort');
    }

    public function permissionSortData(Request $request)
    {
        hasPermission('Sort Permissions');

        $permissions = Permission::select('permissions.id', 'permissions.title', 'permissions.sort_order')
        ->where('permissions.permission_group_id', 'like', $request->permission_group_id)
        ->get();
        $str = '<ul id="sortable">';
        if ($permissions != null) {
            foreach ($permissions as $permission) {
                $str .= '<li class="ui-state-default" id="' . $permission->id . '"><i class="fa fa-sort"></i>' . $permission->title . '</li>';
            }
        }
        echo $str . '</ul>';
    }

    public function permissionSortUpdate(Request $request)
    {
        hasPermission('Sort Permissions');

        $permissionOrder = $request->input('permissionOrder');
        $permissionOrderArray = explode(',', $permissionOrder);
        $count = 1;
        foreach ($permissionOrderArray as $permissionId) {
            $permission = Permission::withoutGlobalScopes()->find($permissionId);
            $permission->sort_order = $count;
            $permission->update();
            $count++;
        }
    }

    public function updatePermissionGroupId(Request $request)
    {
        hasPermission('Edit Permission');

        $data = Permission::withoutGlobalScopes()->find($request->id);
        $data->permission_group_id = $request->permission_group_id;
        $data->save();
        return response()->json(['status' => 'success', 'message' => $data->permission_group_id]);
    }

}

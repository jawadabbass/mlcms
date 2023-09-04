<?php

namespace App\Http\Controllers\Back;

use App\Models\Back\PermissionGroup;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Back\PermissionGroupFormRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;
use App\Scopes\ActiveScope;

class PermissionGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        hasPermission('View Permission Groups');

        return view('back.permissionGroup.index');
    }

    public function fetchPermissionGroupsAjax(Request $request)
    {
        hasPermission('View Permission Groups');

        $permissionGroups = PermissionGroup::select('*')->where('module_id', 0)->withoutGlobalScopes();
        return Datatables::of($permissionGroups)
            ->filter(function ($query) use ($request) {
                if ($request->has('title') && !empty($request->title)) {
                    $query->where('permissions_group.title', 'like', "%{$request->get('title')}%");
                }
            })
            ->addColumn('title', function ($permissionGroups) {
                return Str::limit($permissionGroups->title, 100, '...');
            })
            ->addColumn('action', function ($permissionGroups) {
                $editStr = $deleteStr = '';
                if (isAllowed('Edit Permission Group')) {
                    $editStr = '<a href="' . route('permissionGroup.edit', [$permissionGroups->id]) . '" class="btn btn-warning mr-2" title="Edit details">
                    <i class="fas fa-edit"></i>
                </a>';
                }
                if (isAllowed('Delete Permission Group')) {
                    $deleteStr = '<a href="javascript:void(0);" onclick="deletePermissionGroup(\'' . $permissionGroups->id . '\');" class="btn btn-danger mr-2" title="Delete">
                    <i class="fas fa-trash"></i>
                </a>';
                }
                return $editStr . $deleteStr;
            })
            ->rawColumns(['action', 'title'])
            ->orderColumns(['title', 'status'], ':column $1')
            ->setRowId(function ($permissionGroups) {
                return 'permissionGroupDtRow' . $permissionGroups->id;
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
        hasPermission('Add new Permission Group');

        $permissionGroup = new PermissionGroup();
        return view('back.permissionGroup.create')->with('permissionGroup', $permissionGroup);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PermissionGroupFormRequest $request)
    {
        hasPermission('Add new Permission Group');

        $permissionGroup = new PermissionGroup();
        $permissionGroup->title = $request->input('title');
        $permissionGroup->save();
        /*         * ************************************ */
        setUserPermissionsInSession();

        flash('Permission Group has been added!', 'success');
        return Redirect::route('permissionGroup.index');
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
    public function edit($id)
    {
        hasPermission('Edit Permission Group');
        $permissionGroup = PermissionGroup::where('id', $id)->where('module_id', 0)
            ->withOutGlobalScopes()->first();
        return view('back.permissionGroup.edit')
            ->with('permissionGroup', $permissionGroup);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PermissionGroupFormRequest $request, $id)
    {
        hasPermission('Edit Permission Group');
        $permissionGroup = PermissionGroup::where('id', $id)->where('module_id', 0)
            ->withOutGlobalScopes()->first();

        $permissionGroup->title = $request->input('title');
        $permissionGroup->save();
        /*         * ************************************ */
        setUserPermissionsInSession();
        flash('Permission Group has been updated!', 'success');
        return Redirect::route('permissionGroup.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(PermissionGroup $permissionGroup)
    {
        hasPermission('Delete Permission Group');
        $permissionGroup->delete();
        setUserPermissionsInSession();
        echo 'ok';
    }

    public function sortPermissionGroups()
    {
        hasPermission('Sort Permission Groups');

        return view('back.permissionGroup.sort');
    }

    public function permissionGroupSortData(Request $request)
    {
        hasPermission('Sort Permission Groups');

        $permissionGroups = PermissionGroup::select('permissions_group.id', 'permissions_group.title', 'permissions_group.sort_order')
            ->where('module_id', 0)
            ->withOutGlobalScopes()
            ->get();
        $str = '<ul id="sortable">';
        if ($permissionGroups != null) {
            foreach ($permissionGroups as $permissionGroup) {
                $str .= '<li class="ui-state-default" id="' . $permissionGroup->id . '"><i class="fa fa-sort"></i>' . $permissionGroup->title . '</li>';
            }
        }
        echo $str . '</ul>';
    }

    public function permissionGroupSortUpdate(Request $request)
    {
        hasPermission('Sort Permission Groups');

        $permissionGroupOrder = $request->input('permissionGroupOrder');
        $permissionGroupOrderArray = explode(',', $permissionGroupOrder);
        $count = 1;
        foreach ($permissionGroupOrderArray as $permissionGroupId) {
            $permissionGroup = PermissionGroup::withoutGlobalScopes()->find($permissionGroupId);
            $permissionGroup->sort_order = $count;
            $permissionGroup->update();
            $count++;
        }
    }
}

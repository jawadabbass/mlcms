<?php

use App\Models\Back\Role;
use App\Models\User;
use App\Models\Back\Permission;
use App\Models\Back\PermissionRole;
use App\Models\Back\PermissionGroup;
use Illuminate\Support\Facades\Auth;

function setUserPermissionsInSession()
{
    session()->forget('permission_titles_array');
    $permissionTitlesArray = [];
    $user = User::find(Auth::id());
    $roleIdsArray = $user->getUserRoleIds();
    if (count($roleIdsArray) > 0) {
        $permissionIdsArray = PermissionRole::whereIn('role_id', $roleIdsArray)->pluck('permission_id')->toArray();
        if (count($permissionIdsArray) > 0) {
            $permissionTitlesArray = Permission::whereIn('id', $permissionIdsArray)->pluck('title')->toArray();
        }
    }

    $allPermissionTitlesArray = Permission::pluck('title')->toArray();

    session(
        [
            'permission_titles_array' => $permissionTitlesArray,
            'all_permission_titles_array' => $allPermissionTitlesArray,
        ]
    );
}
function hasPermission($permission)
{
    if (!isAllowed($permission)) {
        abort(403, 'Unauthorized action to ' . implode(', ', $permission));
    }
}
function isAllowed($permission)
{
    if (!session()->has('permission_titles_array')) {
        setUserPermissionsInSession();
    }
    
    if (isSuperAdmin()) {
        return true;
    }

    /********************************* */
    isPermissionValid($permission);
    /********************************* */

    $permission_titles_array = (array)session('permission_titles_array');

    if (str_contains($permission, '<|>')) {
        $permissions_array = explode('<|>', $permission);
        foreach ($permissions_array as $perm) {
            if (in_array($perm, $permission_titles_array)) {
                return true;
            }
        }
    } else {
        if (in_array($permission, $permission_titles_array)) {
            return true;
        }
    }
    return false;
}
function isSuperAdmin()
{
    if ((int)Auth::user()->is_super_admin === 1) {
        return true;
    }
    return false;
}

function isPermissionValid($permission)
{
    $all_permission_titles_array = (array)session('all_permission_titles_array');
    $is_valid_permission = false;
    if (str_contains($permission, '<|>')) {
        $permissions_array = explode('<|>', $permission);
        foreach ($permissions_array as $perm) {
            if (in_array($perm, $all_permission_titles_array)) {
                $is_valid_permission = true;
            }
        }
    } else {
        if (in_array($permission, $all_permission_titles_array)) {
            $is_valid_permission = true;
        }
    }
    if (!$is_valid_permission) {
        abort(403, 'Invalid Permission to check : ' . implode(', ', (array)$permission));
    }
}
function generateRolesCheckBoxes($user)
{
    $userRoleIdsArray = [];
    if ($user->id != '') {
        $userRoleIdsArray = $user->getUserRoleIds();
    }
    $str = '<div class="row">';
    $roles = Role::company()->get();
    foreach ($roles as $role) {
        $checked = (in_array($role->id, (array)$userRoleIdsArray)) ? 'checked="checked"' : '';
        $str .= '<div class="col-md-4 checkbox-padding"><label class="checkbox checkbox-lg">';
        $str .= '<input type="checkbox" value="' . $role->id . '" ' . $checked . ' name="role_ids[]">';
        $str .= '<span></span>&nbsp;&nbsp;&nbsp;' . $role->title . '</label></div>';
    }
    return $str . '</div>';
}
function generatePermissionsCheckBoxes($role)
{
    $rolePermissionIdsArray = $permissionIdsArray = [];
    if ((int)Auth::user()->is_super_admin === 1) {
        $permissionIdsArray = Permission::pluck('id')->toArray();
    } else {
        $user = User::find(Auth::id());
        $roleIdsArray = $user->getUserRoleIds();
        $permissionIdsArray = PermissionRole::whereIn('role_id', $roleIdsArray)->pluck('permission_id')->toArray();
    }
    if ($role->id != '') {
        $rolePermissionIdsArray = $role->getRolePermissionIds();
    }
    $permissionGroupIdsArray = Permission::whereIn('id', $permissionIdsArray)->pluck('permission_group_id')->toArray();
    $str = '<div class="row"><div class="col-md-12">&nbsp;</div>';
    $permissionGroups = PermissionGroup::whereIn('id', $permissionGroupIdsArray)->get();
    foreach ($permissionGroups as $permissionGroup) {
        $str .= '<div class="col-md-12"><strong class="text-primary">' . $permissionGroup->title . '</strong></div>';
        $permissions = $permissionGroup->permissions;
        foreach ($permissions as $permission) {
            if (isAllowed($permission->title)) {
                $checked = (in_array($permission->id, (array)$rolePermissionIdsArray)) ? 'checked="checked"' : '';
                $str .= '<div class="col-md-4"><label class="text-default">';
                $str .= '<input type="checkbox" class="permission_ids_checkbox" value="' . $permission->id . '" ' . $checked . ' name="permission_ids[]">';
                $str .= '<span></span>&nbsp;&nbsp;&nbsp;' . $permission->title . '</label></div>';
            }
        }
        $str .= '<div class="col-md-12">&nbsp;</div>';
    }
    return $str . '</div>';
}

<?php

namespace App\Models\Back;

use App\Scopes\SortedScope;
use App\Scopes\ActiveScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::addGlobalScope(new ActiveScope);
        static::addGlobalScope(new SortedScope);
    }

    protected $table = 'roles';
    protected $primaryKey = 'id';

    protected $fillable = ['id', 'title', 'sort_order', 'status', 'created_by_user_id'];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_role', 'role_id', 'permission_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'role_user', 'role_id', 'user_id');
    }

    public function getRolePermissionIds()
    {
        $permissionIdsArray = [];
        if ($this->permissions->count() > 0) {
            $permissions = $this->permissions;
            foreach ($permissions as $permission) {
                $permissionIdsArray[] = $permission->id;
            }
        }
        return $permissionIdsArray;
    }


}

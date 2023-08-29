<?php

namespace App\Models\Back;

use App\Scopes\SortedScope;
use App\Scopes\ActiveScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermissionGroup extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::addGlobalScope(new ActiveScope);
        static::addGlobalScope(new SortedScope);
    }

    protected $table = 'permissions_group';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'title', 'sort_order', 'status'];

    public function permissions()
    {
        return $this->hasMany(Permission::class, 'permission_group_id', 'id');
    }

}

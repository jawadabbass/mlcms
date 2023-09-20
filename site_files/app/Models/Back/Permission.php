<?php

namespace App\Models\Back;

use App\Scopes\SortedScope;
use App\Scopes\ActiveScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::addGlobalScope(new ActiveScope);
        static::addGlobalScope(new SortedScope);
    }

    protected $table = 'permissions';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'title', 'sort_order', 'status'];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'permission_role', 'permission_id', 'role_id');
    }
}

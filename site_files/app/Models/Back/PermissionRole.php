<?php

namespace App\Models\Back;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermissionRole extends Model
{
    use HasFactory;

    protected $table = 'permission_role';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id', 'permission_id', 'role_id',
    ];

}

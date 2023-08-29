<?php

namespace App\Models\Back;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
    use HasFactory;

    protected $table = 'role_user';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id', 'role_id', 'user_id',
    ];

}

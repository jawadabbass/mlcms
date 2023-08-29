<?php

namespace App\Models\Back;

use Illuminate\Database\Eloquent\Model;

class AdminLogHistory extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'ID';
    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'admin_ID');
    }
}

<?php

namespace App\Models\Back;

use Illuminate\Database\Eloquent\Model;

class ClientsHistory extends Model
{
    protected $table = 'clients_history';
    function user()
    {
        return $this->belongsTo('App\User', 'add_by_user_id', 'id');
    }
    //
}

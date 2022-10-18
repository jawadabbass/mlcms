<?php

namespace App\Models\Back;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Sorted;
use App\Traits\Active;

class State extends Model
{
    use Sorted;
    use Active;
    
    protected $table = 'states';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'id', 'state_code', 'state_name', 'status', 'sort_order', 'created_at', 'updated_at', 'deleted_at',
    ];
}

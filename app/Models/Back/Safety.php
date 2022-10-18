<?php

namespace App\Models\Back;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Active;
use App\Traits\Sorted;

class Safety extends Model
{
    use Active;
    use Sorted;

    protected $table = 'safeties';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'id', 'title', 'status', 'sort_order', 'created_at', 'updated_at', 'deleted_at',
    ];
}

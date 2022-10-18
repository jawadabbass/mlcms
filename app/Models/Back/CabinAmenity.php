<?php

namespace App\Models\Back;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Active;
use App\Traits\Sorted;

class CabinAmenity extends Model
{

    use Active;
    use Sorted;

    protected $table = 'cabin_amenities';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'id', 'title', 'status', 'sort_order', 'created_at', 'updated_at', 'deleted_at',
    ];
}

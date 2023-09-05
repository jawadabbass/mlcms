<?php

namespace App\Models\Back;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Sorted;
use App\Traits\Active;

class City extends Model
{
    use Sorted;
    use Active;
    
    protected $table = 'cities';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'id', 'state_id', 'county_id', 'city_name', 'status', 'sort_order', 'created_at', 'updated_at', 'deleted_at',
    ];

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id', 'id');
    }

    public function county()
    {
        return $this->belongsTo(County::class, 'county_id', 'id');
    }
}

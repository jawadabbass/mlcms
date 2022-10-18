<?php

namespace App\Models\Back;

use App\Traits\Active;
use App\Traits\Sorted;
use App\Models\Back\FleetPlane;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FleetCategory extends Model
{
    use Active;
    use Sorted;

    protected $table = 'fleet_categories';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'id', 'title', 'description', 'status', 'image', 'sort_order', 'created_at', 'updated_at', 'deleted_at',
    ];


    /**
     * Get all of the fleetPlanes for the FleetCategory
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function fleetPlanes(): HasMany
    {
        return $this->hasMany(FleetPlane::class, 'fleet_category_id', 'id');
    }
}

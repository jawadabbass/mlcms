<?php

namespace App\Models\Back;

use Illuminate\Database\Eloquent\Model;

class FleetPlanePerformance extends Model
{
    protected $table = 'fleet_plane_performances';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'id', 'fleet_plane_id', 'performance_id', 'value', 'hint', 'created_at', 'updated_at', 'deleted_at',
    ];

    public static function getFleetPlanePerformance($fleetPlaneId, $passengerCapacityId)
    {
        return self::where('fleet_plane_id', $fleetPlaneId)->where('performance_id', $passengerCapacityId)->firstOrNew();
    }
}

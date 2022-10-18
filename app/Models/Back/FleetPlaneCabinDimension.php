<?php

namespace App\Models\Back;

use Illuminate\Database\Eloquent\Model;

class FleetPlaneCabinDimension extends Model
{
    protected $table = 'fleet_plane_cabin_dimensions';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'id', 'fleet_plane_id', 'cabin_dimension_id', 'value', 'hint', 'created_at', 'updated_at', 'deleted_at',
    ];

    public static function getFleetPlaneCabinDimension($fleetPlaneId, $passengerCapacityId)
    {
        return self::where('fleet_plane_id', $fleetPlaneId)->where('cabin_dimension_id', $passengerCapacityId)->firstOrNew();
    }
}

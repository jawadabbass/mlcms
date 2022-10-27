<?php

namespace App\Models\Back;

use Illuminate\Database\Eloquent\Model;

class FleetPlaneCabinAmenity extends Model
{
    protected $table = 'fleet_plane_cabin_amenities';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'id', 'fleet_plane_id', 'cabin_amenity_id', 'value', 'hint', 'created_at', 'updated_at', 'deleted_at',
    ];

    public static function getFleetPlaneCabinAmenity($fleetPlaneId, $passengerCapacityId)
    {
        return self::where('fleet_plane_id', $fleetPlaneId)->where('cabin_amenity_id', $passengerCapacityId)->firstOrNew();
    }
}

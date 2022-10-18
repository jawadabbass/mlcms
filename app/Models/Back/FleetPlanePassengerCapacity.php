<?php

namespace App\Models\Back;

use Illuminate\Database\Eloquent\Model;

class FleetPlanePassengerCapacity extends Model
{
    protected $table = 'fleet_plane_passenger_capacities';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'id', 'fleet_plane_id', 'passenger_capacity_id', 'value', 'hint', 'created_at', 'updated_at', 'deleted_at',
    ];

    public static function getFleetPlanePassengerCapacity($fleetPlaneId, $passengerCapacityId)
    {
        return self::where('fleet_plane_id', $fleetPlaneId)->where('passenger_capacity_id', $passengerCapacityId)->firstOrNew();
    }
}

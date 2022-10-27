<?php

namespace App\Models\Back;

use Illuminate\Database\Eloquent\Model;

class FleetPlaneBaggageCapacity extends Model
{
    protected $table = 'fleet_plane_baggage_capacities';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'id', 'fleet_plane_id', 'baggage_capacity_id', 'value', 'hint', 'created_at', 'updated_at', 'deleted_at',
    ];

    public static function getFleetPlaneBaggageCapacity($fleetPlaneId, $passengerCapacityId)
    {
        return self::where('fleet_plane_id', $fleetPlaneId)->where('baggage_capacity_id', $passengerCapacityId)->firstOrNew();
    }
}

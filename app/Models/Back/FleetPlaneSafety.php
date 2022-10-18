<?php

namespace App\Models\Back;

use Illuminate\Database\Eloquent\Model;

class FleetPlaneSafety extends Model
{
    protected $table = 'fleet_plane_safeties';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'id', 'fleet_plane_id', 'safety_id', 'value', 'hint', 'created_at', 'updated_at', 'deleted_at',
    ];

    public static function getFleetPlaneSafety($fleetPlaneId, $passengerCapacityId)
    {
        return self::where('fleet_plane_id', $fleetPlaneId)->where('safety_id', $passengerCapacityId)->firstOrNew();
    }
}

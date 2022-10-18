<?php

namespace App\Models\Back;

use Illuminate\Database\Eloquent\Model;

class PlaneImage extends Model
{
    protected $table = 'fleet_plane_images';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'id', 'fleet_plane_id', 'image', 'alt', 'title', 'created_at', 'updated_at', 'deleted_at',
    ];

    public function fleetPlane()
    {
        return $this->belongsTo(FleetPlane::class, 'fleet_plane_id', 'id');
    }
}

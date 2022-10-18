<?php

namespace App\Models\Back;

use Illuminate\Database\Eloquent\Model;
use App\Models\Back\FleetCategory;
use App\Traits\Active;
use App\Traits\Sorted;


class FleetPlane extends Model
{
    use Active;
    use Sorted;

    protected $table = 'fleet_planes';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'id', 'fleet_category_id', 'plane_name', 'description', 'image', 'layout_image', 'spec_sheet', 'created_at', 'updated_at', 'deleted_at',
    ];

    public function fleetCategory()
    {
        return $this->belongsTo(FleetCategory::class, 'fleet_category_id', 'id');
    }

    public function planeImages()
    {
        return $this->hasMany(PlaneImage::class, 'fleet_plane_id', 'id');
    }
}

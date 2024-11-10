<?php

namespace App\Models\Back;

use App\Traits\Active;
use App\Traits\Sorted;
use Illuminate\Database\Eloquent\Model;

class SiteMap extends Model
{
    use Sorted;
    use Active;
    
    protected $table = 'site_map';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'id', 'parent_id', 'title', 'link', 'is_link_internal', 'status', 'sort_order', 'created_at', 'updated_at', 'deleted_at',
    ];

    public function parentSiteMap()
    {
        return $this->belongsTo(SiteMap::class, 'parent_id', 'id')->withDefault([
            'parent_id' => 0,
            'title' => '',
            'link' => '',
            'is_link_internal' => 1,
            'status' => 1,
            'sort_order' => '999999',
            'created_at' => '', 
        ]);
    }

    public function childSiteMaps()
    {
        return $this->hasMany(SiteMap::class, 'parent_id', 'id');
    }
}

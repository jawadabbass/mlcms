<?php

namespace App\Models\Back;

use App\Traits\Active;
use App\Traits\Sorted;
use App\Models\Back\ServiceExtraImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    use Sorted;
    use Active;
    
    protected $table = 'services';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'id', 'parent_id', 'title', 'slug', 'excerpt', 'description', 'featured_image', 'featured_image_title', 'featured_image_alt', 'is_featured', 'status', 'sort_order', 'meta_title', 'meta_keywords', 'meta_description', 'show_follow', 'show_index', 'canonical_url', 'created_at', 'updated_at', 'deleted_at',
    ];

    public function parentService()
    {
        return $this->belongsTo(Service::class, 'parent_id', 'id')->withDefault([
            'parent_id' => 0,
            'title' => '',
            'slug' => '',
            'excerpt' => '',
            'description' => '',
            'featured_image' => '',
            'featured_image_title' => '',
            'featured_image_alt' => '',
            'is_featured' => 0,
            'status' => 0,
            'sort_order' => '',
            'meta_title' => '', 
            'meta_keywords' => '', 
            'meta_description' => '', 
            'show_follow' => 0, 
            'show_index' => 0, 
            'canonical_url' => '', 
            'created_at' => '', 
        ]);
    }

    public function childServices()
    {
        return $this->hasMany(Service::class, 'parent_id', 'id');
    }

    /**
     * Get all of the serviceExtraImages for the Service
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function serviceExtraImages(): HasMany
    {
        return $this->hasMany(ServiceExtraImage::class, 'service_id', 'id');
    }
}

<?php

namespace App\Models\Back;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Sorted;

class ServiceExtraImage extends Model
{
    use Sorted;
    
    protected $table = 'service_extra_images';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'id', 'image_name', 'image_name2', 'isBeforeAfter', 'isBeforeAfterHaveTwoImages', 'service_id', 'session_id', 'image_alt', 'image_title', 'sort_order', 'created_at', 'updated_at', 'deleted_at',
    ];
}

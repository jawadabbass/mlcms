<?php

namespace App\Models\Back;

use Illuminate\Database\Eloquent\Model;

class ModuleVideo extends Model
{
    protected $table = 'module_videos';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'id',
        'module_data_id',
        'video_type',
        'video_link_embed_code',
        'video_name',
        'video_thumb_img',
        'module_type',
        'module_id',
        'session_id',
        'sort_order',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}

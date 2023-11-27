<?php

namespace App\Models\Back;

use Illuminate\Database\Eloquent\Model;

class BannerPopup extends Model
{
    protected $table = 'banner_popups';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'id', 'banner_title', 'content', 'status', 'sort_order', 'created_at', 'updated_at', 'deleted_at',
    ];
}

<?php

namespace App\Models\Back;

use App\Traits\Active;
use App\Traits\Sorted;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use Active;
    use Sorted;

    protected $table = 'news';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'id', 'title', 'description', 'news_date_time', 'has_registration_link', 'registration_link', 'is_hide_event_after_date', 'image', 'image_title', 'image_alt', 'location', 'is_featured', 'is_third_party_link', 'news_link', 'status', 'sort_order', 'created_at', 'updated_at', 'deleted_at',
    ];
}

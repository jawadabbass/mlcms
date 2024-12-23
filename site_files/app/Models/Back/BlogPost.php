<?php

namespace App\Models\Back;

use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'id';
    public function comments()
    {
        return $this->hasMany('App\Models\Back\BlogComment', 'post_id', 'id');
    }
    public function author()
    {
        return $this->belongsTo('App\Models\User', 'author_id', 'id');
    }
    public function category()
    {
        return $this->belongsTo('App\Models\Back\BlogCategory', 'cate_ids', 'id');
    }
}

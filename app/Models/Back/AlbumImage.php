<?php

namespace App\Models\Back;

use Illuminate\Database\Eloquent\Model;

class AlbumImage extends Model
{
    protected $guarded = ['id'];
    protected $table = 'images';
    public $timestamps = false;

    public function album()
    {
        return $this->belongsTo(Album::class, 'album_id', 'id');
    }
}

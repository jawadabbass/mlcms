<?php

namespace App\Models\Back;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table = 'country';
    public $timestamps = false;
    protected $primaryKey = 'id';
}

<?php

namespace App\Models\Back;

use Illuminate\Database\Eloquent\Model;

class ZipCode extends Model
{
    protected $table = 'zipcodes';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'id', 'zipcode', 'zipcode_name', 'city_name', 'state_name', 'county_name', 'created_at', 'updated_at', 'deleted_at',
    ];

}

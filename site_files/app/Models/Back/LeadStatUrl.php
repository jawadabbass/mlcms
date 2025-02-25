<?php

namespace App\Models\Back;

use Illuminate\Database\Eloquent\Model;

class LeadStatUrl extends Model
{

    protected $table = 'lead_stat_urls';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'id',
        'url',
        'final_destination',
        'url_internal_external',
        'created_at',
        'updated_at',
    ];
}

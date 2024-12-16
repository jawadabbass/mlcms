<?php

namespace App\Models\Back;

use Illuminate\Database\Eloquent\Model;

class LeadStat extends Model
{
    protected $table = 'lead_stats';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'id',
        'referrer',
        'created_at',
        'updated_at'
    ];
}

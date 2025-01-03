<?php

namespace App\Models\Back;

use Illuminate\Database\Eloquent\Model;

class ReferrerImpressionLead extends Model
{
    protected $table = 'referrer_impression_lead';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'id',
        'impressions',
        'leads',
        'created_at',
        'updated_at'
    ];
}

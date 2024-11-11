<?php

namespace App\Models\Back;

use Illuminate\Database\Eloquent\Model;

class RecordUpdateHistory extends Model
{
    
    protected $table = 'record_update_history';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'id',
        'record_id',
        'record_title',
        'model_or_table',
        'admin_id',
        'ip',
        'draft',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}

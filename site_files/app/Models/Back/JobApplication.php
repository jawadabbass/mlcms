<?php

namespace App\Models\Back;

use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    public $table = 'job_applications';
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $fillable = [
        'id', 'career_id', 'name', 'email', 'comments', 'ip', 'dated', 'created_at', 'updated_at',
    ];
}

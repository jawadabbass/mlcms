<?php

namespace App\Models\Back;

use Illuminate\Database\Eloquent\Model;

class EmailQueue extends Model
{
    protected $table = 'email_queue';
    protected $primaryKey = 'id';
    public $timestamps = false;
}

<?php

namespace App\Models\Back;

use Illuminate\Database\Eloquent\Model;

class Mod extends Model
{
    public $timestamps = false;
    protected $primaryKey = 't_id';
    protected $table = 'ab_gen_table_info';
}

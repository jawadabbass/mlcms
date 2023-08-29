<?php

namespace App\Models\Back;

use Illuminate\Database\Eloquent\Model;

class ModTableFields extends Model
{
    //ab_gen_table_fields
    public $timestamps = false;
    protected $table = 'ab_gen_table_fields';
    protected $primaryKey = 'ID';
}

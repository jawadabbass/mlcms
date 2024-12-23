<?php

namespace App\Models\Back;

use Illuminate\Database\Eloquent\Model;

class ModMainActions extends Model
{
    public $timestamps = false;
    protected $table = 'ab_gen_action_list';
    protected $primaryKey = 'id';
}

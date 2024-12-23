<?php

namespace App\Models\Back;

use Illuminate\Database\Eloquent\Model;

class ModTemplateActions extends Model
{
    public $timestamps = false;
    protected $table = 'ab_gen_actions';
    protected $primaryKey = 'id';
}

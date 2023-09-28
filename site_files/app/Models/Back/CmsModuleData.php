<?php

namespace App\Models\Back;

use Illuminate\Database\Eloquent\Model;

class CmsModuleData extends Model
{
    protected $table = 'cms_module_datas';
    public $timestamps = false;
    public function module()
    {
        return $this->belongsTo('App\Models\Back\CmsModule', 'cms_module_id', 'id');
    }
}

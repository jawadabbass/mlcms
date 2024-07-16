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
    public function belongsToModule($model, $field = 'type', $default='')
    {
        if((int)$model->belongs_to_module_id > 0){
            $cmsModule = CmsModule::find($model->belongs_to_module_id);
            return $cmsModule->{$field};
        }else{
            return $default;
        }
    }
}

<?php

namespace App\Models\Back;

use Illuminate\Database\Eloquent\Model;

class PackageContent extends Model
{
    protected $table='package_content';
    function package(){
    	return $this->belongsTo('App\Models\Back\CmsModuleData','package_id','id');
    }

}

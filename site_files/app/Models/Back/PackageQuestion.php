<?php

namespace App\Models\Back;

use Illuminate\Database\Eloquent\Model;

class PackageQuestion extends Model
{
    protected $table='package_questions';
    function package(){
    	return $this->belongsTo('App\Models\Back\CmsModuleData','package_id','id');
    }

}

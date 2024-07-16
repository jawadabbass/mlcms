<?php

namespace App\Models\Back;

use Illuminate\Database\Eloquent\Model;

class ClientPackages extends Model
{
	protected $table='client_packages';

    function clientPackage(){
        return $this->belongsTo('App\Models\Back\CmsModuleData','package_id','id');
    }
    function clientPackageQuestions(){
        return $this->hasMany('App\Models\Back\ClientPackagesQuestions','client_package_id','id');
    }

}

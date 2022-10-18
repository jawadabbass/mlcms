<?php

namespace App\Models\Back;

use Illuminate\Database\Eloquent\Model;

class ClientPackagesQuestions extends Model
{
	protected $table='client_package_questions';
    function question(){
        return $this->belongsTo('App\Models\Back\PackageQuestion','question_id','id');
    }
}

<?php

namespace App\Models\Back;

use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model
{
    protected $table = 'contact_us_requests';

    function user(){
    	return $this->hasOne('App\user','id','added_by');
    }
    
     function assessment(){
    	return $this->hasMany('App\Models\Back\AssessmentAnswers','lead_id','id');
    }
    
    
}

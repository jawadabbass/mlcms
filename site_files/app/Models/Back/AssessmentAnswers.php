<?php

namespace App\Models\Back;

use Illuminate\Database\Eloquent\Model;

class AssessmentAnswers extends Model
{
	protected $table='assesment_answers';
	
	 function assessment_question(){
    	return $this->belongsTo('App\Models\Back\AssesmentQuestion','question_id','id');
    }

}

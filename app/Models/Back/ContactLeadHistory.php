<?php

namespace App\Models\Back;

use App\Mail\ContactUs;
use App\User;
use Illuminate\Database\Eloquent\Model;

class ContactLeadHistory extends Model
{

	public function admin()
	{
		return $this->belongsTo(User::class, 'user_id', 'id');
	}
}

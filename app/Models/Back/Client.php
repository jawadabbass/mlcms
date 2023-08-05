<?php

namespace App\Models\Back;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Client extends Authenticatable
{
    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'clients';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    function user()
    {
        return $this->hasOne('App\User', 'id', 'added_by');
    }


    function client_assessment()
    {
        return $this->hasMany('App\Models\Back\AssessmentAnswers', 'client_id', 'id');
    }

    function clientPackage()
    {
        return $this->hasMany('App\Models\Back\ClientPackages', 'client_id', 'id');
    }

    function state()
    {
        return $this->belongsTo('App\Models\Back\State', 'state_id', 'id')->withDefault();
    }

    function clientCity()
    {
        return $this->belongsTo('App\Models\Back\City', 'city_id', 'id')->withDefault();
    }
}

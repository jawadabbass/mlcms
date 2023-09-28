<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\AdminVerifyEmail;
use App\Notifications\AdminResetPassword as AdminResetPasswordNotification;
use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sendAdminEmailVerificationNotification()
    {
        $this->notify(new AdminVerifyEmail);
    }

    public function sendPasswordResetNotification($token)
    {
        if(
            $this->type === config('Constants.USER_TYPE_SUPER_ADMIN') ||
            $this->type === config('Constants.USER_TYPE_NORMAL_ADMIN') ||
            $this->type === config('Constants.USER_TYPE_REPS_ADMIN')
        ){
            $this->notify(new AdminResetPasswordNotification($token));
        }else{
            $this->notify(new ResetPasswordNotification($token));
        }
    }
}

<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Back\Role;
use Laravel\Sanctum\HasApiTokens;
use App\Notifications\AdminVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
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
        'id', 'name', 'email', 'phone', 'type', 'is_super_admin', 'active', 'created_at', 'updated_at', 'api_token', 'on_notification_email', 'profile_image', 'address_line_1', 'address_line_2', 'zipcode', 'city', 'state', 'country'
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
            $this->type === 'admin'
        ){
            $this->notify(new AdminResetPasswordNotification($token));
        }else{
            $this->notify(new ResetPasswordNotification($token));
        }
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id');
    }

    public function getUserRoleIds()
    {
        $roleIdsArray = [];
        if ($this->roles->count() > 0) {
            $roles = $this->roles;
            foreach ($roles as $role) {
                $roleIdsArray[] = $role->id;
            }
        }
        return $roleIdsArray;
    }
}

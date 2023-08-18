<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckSuperAdmin
{
    public function handle(Request $request, Closure $next)
    {
        $superAdmins = User::where('is_super_admin', 1)->where('type', 'like', 'admin')->get();
        if($superAdmins->count() == 0){
            echo view('errors.super_admin', ['code'=>'600','title'=>'Super Admin Error','message'=>'Must be 1 super admin should be available in system','image'=>asset('images/admin.jpg')]);
            exit;
        }elseif($superAdmins->count() > 1){
            echo view('errors.super_admin', ['code'=>'600','title'=>'Super Admin Error','message'=>'Only 1 super admin should be available in system','image'=>asset('images/admin.jpg')]);
            exit;
        }
        return $next($request);
    }
}

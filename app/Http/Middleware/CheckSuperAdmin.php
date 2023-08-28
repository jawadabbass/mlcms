<?php

namespace App\Http\Middleware;

use App\Models\Back\Metadata;
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

        $HSAUNObj = Metadata::where('data_key', 'like', 'has_shown_admin_user_notice')->first();
        if ($HSAUNObj->val1 == 0) {
            $HSAUNObj->val1 = 1;
            $HSAUNObj->save();
            echo view('errors.notice', ['message'=>'Super Admin User (in Users table is_super_admin=1) is for developer only.<br/>It has access to all functionalities. i.e.<br/> * CMS Modules Management<br/> * Permissions and Permissions Group Management.<br/><br/>Client(Owner) will have some restricted access. (i.e Currently Admin Level 1 role)<br/>There is no need to give access to functionalities like <br/> * Modules Management<br/> * Permissions and Permissions Group Managemnt<br/><br/><br/><br/><br/><a href=""><button>Refresh Page to dismiss notice</button></a>']);
            exit;
        }
        return $next($request);
    }
}

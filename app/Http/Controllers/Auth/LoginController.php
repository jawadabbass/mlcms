<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Back\AdminLogHistory;
use App\Models\Back\Metadata;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Traits\AuthTrait;

class LoginController extends Controller
{
    use AuthTrait;
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
    use AuthenticatesUsers {
        logout as performLogout;
    }
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/redirect';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    protected function authenticated(Request $request, User $user)
    {
        return $this->setSession($request);
    }
    public function logout(Request $request)
    {
        $this->performLogout($request);
        return redirect('/');
    }
    public function performLogout(Request $request)
    {
        if (Auth::user()->type != config('Constants.USER_TYPE_FRONT_USER')) {
            $adminLogs = AdminLogHistory::where('admin_id', Auth::user()->id)->where('ip_address', $request->ip())->orderBy('session_start', 'DESC')->first();
            if ($adminLogs != null) {
                $adminLogs->session_end = date("Y-m-d H:i:s");
                $adminLogs->save();
            }
        }
        session_start();
        session_unset();
        session_destroy();
        $this->guard()->logout();
        $request->session()->invalidate();
    }
}

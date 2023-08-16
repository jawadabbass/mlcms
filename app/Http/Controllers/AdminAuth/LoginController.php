<?php

namespace App\Http\Controllers\AdminAuth;

use App\Models\User;
use App\Traits\AuthTrait;
use Illuminate\Http\Request;
use App\Models\Back\Metadata;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\Back\AdminLogHistory;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    use AuthenticatesUsers;
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
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::ADMIN_HOME;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin_guest')->except('logout');
    }
    public function showLoginForm()
    {
        return view('admin_auth.login');
    }
    protected function authenticated(Request $request, User $user)
    {
        return $this->setSession($request);
    }
    public function logout(Request $request)
    {
        $this->performLogout($request);
        $this->guard()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        if ($response = $this->loggedOut($request)) {
            return $response;
        }
        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect('/adminmedia');
    }
    public function performLogout(Request $request)
    {
        $adminLogs = AdminLogHistory::where('admin_id', Auth::user()->id)->where('ip_address', $request->ip())->orderBy('session_start', 'DESC')->first();
        if ($adminLogs != null) {
            $adminLogs->session_end = date("Y-m-d H:i:s");
            $adminLogs->save();
        }
        session_start();
        session_unset();
        session_destroy();
    }
}

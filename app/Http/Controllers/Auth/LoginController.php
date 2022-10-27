<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Back\AdminLogHistory;
use App\Models\Back\Metadata;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
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
        // server should keep session data for AT LEAST 2 hour
        ini_set('session.gc_maxlifetime', 7200);
        // each client should remember their session id for EXACTLY 2 hour
        session_set_cookie_params(7200);
        session_start();
        $_SESSION['auth'] = true;
        $metaDatas = Metadata::where('data_key', 'date_format')
            ->orWhere('data_key', 'date_time_format')
            ->orWhere('data_key', 'time_zone')
            ->orWhere('data_key', 'max_image_size')
            ->get();
        $metaArray = array();
        foreach ($metaDatas as $metaData) {
            $metaArray[$metaData->data_key] = $metaData->val1;
        }
        session([
            'date_format' => $metaArray['date_format'],
            'date_time_format' => $metaArray['date_time_format'],
            'time_zone' => $metaArray['time_zone'],
            'max_image_size' => $metaArray['max_image_size'],
        ]);
        if (Auth::user()->type == 'super-admin' || Auth::user()->type == 'normal-admin') {
            $adminLog = new AdminLogHistory();
            $adminLog->admin_ID = Auth::user()->id;
            $adminLog->ip_address = $request->ip();
            $adminLog->session_start = date("Y-m-d H:i:s");
            $adminLog->save();
        } else
            return redirect('/');
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

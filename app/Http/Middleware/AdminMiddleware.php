<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (
            Auth::guard($guard)->check() &&
            (Auth::guard($guard)->user()->type == config('Constants.USER_TYPE_SUPER_ADMIN') ||
                Auth::guard($guard)->user()->type == config('Constants.USER_TYPE_NORMAL_ADMIN') ||
                Auth::guard($guard)->user()->type == config('Constants.USER_TYPE_REPS_ADMIN')
            )
        ) {
            return $next($request);
        }
        return redirect('/');
    }
}

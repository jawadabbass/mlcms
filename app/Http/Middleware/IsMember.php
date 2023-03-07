<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsMember
{
    public function handle(Request $request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check() && Auth::guard($guard)->user()->type == config('Constants.USER_TYPE_FRONT_USER')) {
            return $next($request);
        }
        abort(403, 'Unauthorized');
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class APIUserAuth
{
    public function handle(Request $request, Closure $next)
    {

        if (auth('users')->check() && $request->user('users')->tokenCan('users'))
            return $next($request);
        return api(false, 400, 'الرجاء اعادة تسجيل الدخول')->get();
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
//        if($request->user()->email_verified_at === NULL && $request->user()->type != 'admin'){
//            return redirect()->route('verify');
//        }
        if(!$request->user()->verified && $request->user()->type != 'admin'){
            return redirect()->route('verify');
        }
        return $next($request);
    }
}

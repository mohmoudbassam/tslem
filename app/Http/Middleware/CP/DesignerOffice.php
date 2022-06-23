<?php

namespace App\Http\Middleware\CP;

use Closure;
use Illuminate\Http\Request;

class DesignerOffice
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
        if(auth()->user()->type=='design_office'){
            return $next($request);
        }
        abort(403);
    }
}

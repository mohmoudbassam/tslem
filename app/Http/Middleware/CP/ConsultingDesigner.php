<?php

namespace App\Http\Middleware\CP;

use Closure;
use Illuminate\Http\Request;

class ConsultingDesigner
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
        if(auth()->user()->is_designer_consulting()){
            return $next($request);
        }
        abort(403);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UnverifiedMiddelware
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
        if ( auth()->user()->verified ) {
            $user_type=auth()->user()->type;
            if(auth()->user()->type == 'admin'){
                return redirect()->route('dashboard');
            }
            if(auth()->user()->type=='service_provider'){
                return redirect()->route('services_providers');
            }
            if(auth()->user()->type=='Delivery'){
                return redirect()->route('delivery');
            }
            return redirect()->route($user_type);
        }
        return $next($request);
    }
}

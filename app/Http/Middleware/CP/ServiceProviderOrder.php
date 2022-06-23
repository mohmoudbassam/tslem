<?php

namespace App\Http\Middleware\CP;

use Closure;
use Illuminate\Http\Request;

class ServiceProviderOrder
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        if (auth()->check() && auth()->user()->service_provider_status == 3) {
            return $next($request);
        }
        abort(403);
    }
}

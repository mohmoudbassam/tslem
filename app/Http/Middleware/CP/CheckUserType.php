<?php

namespace App\Http\Middleware\CP;

use Closure;
use Illuminate\Http\Request;

class CheckUserType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$types
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$types)
    {
        $types = empty($types) ? [ null ] : $types;
        if( in_array(currentUser(optional())->type, $types) )
        {
            return $next($request);
        }

        abort(403);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsFileUploaded
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
        if($request->user()->is_file_uploaded == false && $request->user()->type != 'admin'){
            return redirect()->route('upload_files');
        }
        return $next($request);
    }
}

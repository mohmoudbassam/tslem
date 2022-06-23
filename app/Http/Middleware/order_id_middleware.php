<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use UniSharp\LaravelFilemanager\Lfm;
use UniSharp\LaravelFilemanager\LfmPath;

class order_id_middleware
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

        if(request('id')){

         //   config(['lfm.folder_categories.file.folder_name'=>'files/'.request('id')]);
          // dd(app(Lfm::class)->config('folder_categories'),app(Lfm::class));

         //config(['lfm.folder_categories.file.folder_name'=>'files/'.request('id')]);


      //    config('lfm.folder_categories.file.folder_name');
       //     Artisan::call('config:clear');
            return $next($request);
        }

        return $next($request);
    }
}

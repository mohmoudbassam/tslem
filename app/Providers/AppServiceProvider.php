<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        Schema::defaultStringLength(191);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->share([
                          'dir' => $dir = (currentLocale() == 'ar' ? 'rtl' : 'ltr'),
                          'dir2' => $dir === 'ltr' ? 'rtl' : 'ltr',
                      ]);
        if(strtolower(PHP_OS_FAMILY) == 'windows'){
            config([
                'snappy.pdf.binary' => base_path(trim(env('WKHTML_PDF_BINARY_WINDOWS'), '/\\')),
                'snappy.pdf.image'  => base_path(trim(env('WKHTML_IMG_BINARY_WINDOWS'), '/\\')),
            ]);
        }
    }
}

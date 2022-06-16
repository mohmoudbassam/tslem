<?php

namespace App\Providers;

use App\Models\License;
use App\Models\Order;
use App\Observers\LicenseObserver;
use App\Observers\NotifcationObserver;
use App\Observers\OrderObserver;
use Illuminate\Notifications\DatabaseNotification;
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
        Order::observe(OrderObserver::class);
        License::observe(LicenseObserver::class);
        DatabaseNotification::observe(NotifcationObserver::class);

        view()->share([
                          'dir' => $dir = (currentLocale() == 'ar' ? 'rtl' : 'ltr'),
                          'dir2' => $dir === 'ltr' ? 'rtl' : 'ltr',
                      ]);
    }
}

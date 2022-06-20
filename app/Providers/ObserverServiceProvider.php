<?php

namespace App\Providers;

use App\Models\License;
use App\Models\NewsArticle;
use App\Models\Order;
use App\Observers\LicenseObserver;
use App\Observers\NewsArticleObserver;
use App\Observers\NotifcationObserver;
use App\Observers\OrderObserver;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\ServiceProvider;

class ObserverServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Order::observe(OrderObserver::class);
        License::observe(LicenseObserver::class);
        NewsArticle::observe(NewsArticleObserver::class);
        DatabaseNotification::observe(NotifcationObserver::class);
    }
}

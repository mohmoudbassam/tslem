<?php

namespace App\Http;

use App\Http\Middleware\APIUserAuth;
use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array<int, class-string|string>
     */
    protected $middleware = [
        // \App\Http\Middleware\TrustHosts::class,
        \App\Http\Middleware\TrustProxies::class,
        \Fruitcake\Cors\HandleCors::class,
        \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array<string, array<int, class-string|string>>
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            // \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,

        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array<string, class-string|string>
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'admin'=>\App\Http\Middleware\CP\Admin::class,
        'service_provider'=>\App\Http\Middleware\CP\ServiceProviders::class,
        'design_office'=>\App\Http\Middleware\CP\DesignerOffice::class,
        'delivery'=>\App\Http\Middleware\CP\Delivery::class,
        'consulting_office'=>\App\Http\Middleware\CP\ConsultingOffice::class,
        'verifiedUser'=>\App\Http\Middleware\CP\Verified::class,
        'contractor'=>\App\Http\Middleware\CP\contractor::class,
        'sharer'=>\App\Http\Middleware\CP\Sharer::class,
        'is-verified' => \App\Http\Middleware\IsVerified::class,
        'is-unverified' => \App\Http\Middleware\UnverifiedMiddelware::class,
        'is-file-uploaded' => \App\Http\Middleware\IsFileUploaded::class,
        'APIUserAuth' => APIUserAuth::class,
        'raft_company' => \App\Http\Middleware\CP\RaftCompany::class,
        'raft_center' => \App\Http\Middleware\CP\RaftCenter::class,
        'ServiceProviderOrder' => \App\Http\Middleware\CP\ServiceProviderOrder::class,
        'ConsultingDesigner'=>\App\Http\Middleware\CP\ConsultingDesigner::class,
        'MaintenanceAuth' => \App\Http\Middleware\API\MaintenanceAuth::class,
        'RaftCompanyAuth' => \App\Http\Middleware\API\RaftCompanyAuth::class,
        'user_type' => \App\Http\Middleware\CP\CheckUserType::class,
        'kdana' => \App\Http\Middleware\CP\Kdana::class,
    ];
}

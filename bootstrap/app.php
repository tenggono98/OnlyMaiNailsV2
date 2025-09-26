<?php

use App\Console\Commands\CheckAndCancelUnpaidBookings;
use Carbon\Carbon;
use App\Http\Middleware\RoleCheck;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Console\Scheduling\Schedule;

return Application::configure(basePath: dirname(__DIR__))
    ->withProviders([
        \App\Providers\HttpsServiceProvider::class,
    ])
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => RoleCheck::class,
            'redirectToUserLogin' =>\App\Http\Middleware\RedirectToUserLogin::class

        ]);
        
        // Only apply TrustProxies middleware in production (not local)
        if (env('APP_ENV') === 'production') {
            $middleware->web(append: [
                \App\Http\Middleware\TrustProxies::class,
            ]);
        }
      
        
        // Force HTTPS in production
        if (env('FORCE_HTTPS', false)) {
            $middleware->web(append: [
                \Illuminate\Http\Middleware\HandleCors::class,
            ]);
        }
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->withSchedule(function (Schedule $schedule) {
        // $schedule->call(new CheckAndCancelUnpaidBookings)->daily();
    })->create();

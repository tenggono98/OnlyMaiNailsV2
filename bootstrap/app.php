<?php

use App\Console\Commands\CheckAndCancelUnpaidBookings;
use Carbon\Carbon;
use App\Http\Middleware\RoleCheck;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Console\Scheduling\Schedule;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => RoleCheck::class,
            'redirectToUserLogin' =>\App\Http\Middleware\RedirectToUserLogin::class,
            'check.user.status' => \App\Http\Middleware\CheckUserStatus::class

        ]);

        // Register the CheckUserStatus middleware to run on every web request
        $middleware->web(append: [
            \App\Http\Middleware\CheckUserStatus::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->withSchedule(function (Schedule $schedule) {
        // $schedule->call(new CheckAndCancelUnpaidBookings)->daily();
    })->create();

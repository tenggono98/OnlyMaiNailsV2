<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class HttpsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Force HTTPS URLs in production
        if (config('app.force_https') || env('FORCE_HTTPS', false) || app()->environment('production')) {
            URL::forceScheme('https');
        }
    }
}

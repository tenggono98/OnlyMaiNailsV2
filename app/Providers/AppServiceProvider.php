<?php

namespace App\Providers;

use App\Mail\VerifyEmailUser;
use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\VerifyEmail;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //





         // Ensure $notifiable has an 'email' attribute or a method that provides the recipient email.
         VerifyEmail::toMailUsing(function ($notifiable, $url) {
            $mailData = [
                'title' => 'Verify Email',
                'url' => $url,
            ];

            return (new VerifyEmailUser($mailData))
                        ->to($notifiable->email); // Specify the recipient
        });

    }
}

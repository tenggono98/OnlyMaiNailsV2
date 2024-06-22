<?php

use Illuminate\Support\Facades\Route;

// Can be access as "Guest"
Route::get('/',\App\Livewire\Homepage::class)->name('home');
Route::get('/services',\App\Livewire\Services::class)->name('services');
Route::get('/book',\App\Livewire\Book::class)->name('book');
Route::get('/contact_us',\App\Livewire\ContactUs::class)->name('contact_us');
Route::get('/user/login',\App\Livewire\Login::class)->name('user.login');
Route::get('/draftui/mail_book',\App\Livewire\DraftUI\BookingMail::class);

// Protected the route
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Can be access as "Admin"
        Route::prefix('admin')->group(function () {
                Route::get('/dashboard',\App\Livewire\Admin\Dashboard::class)->name('admin.dashboard');
                Route::view('/profile', 'profile') ->middleware(['auth']) ->name('profile');
                Route::get('/booking',\App\Livewire\Admin\Booking::class)->name('admin.booking');
                Route::get('/schedule',\App\Livewire\Admin\Schedule::class)->name('admin.schedule');
                Route::get('/service',\App\Livewire\Admin\Service::class)->name('admin.service');
                Route::get('/setting',\App\Livewire\Admin\Setting::class)->name('admin.setting');
                Route::get('/users',\App\Livewire\Admin\Setting::class)->name('admin.users');
                Route::get('/profile',\App\Livewire\Admin\Setting::class)->name('admin.profile');
            });
        });
        // Can be access as "User"
        Route::middleware(['auth', 'role:user'])->group(function () {
                // Protect the route so only the user that login can change they own profile use AUTH to validate the id to compare
                Route::get('/change_profile/{id}',\App\Livewire\User\ChangeProfile::class)->name('user.change_profile')->where('id', '[0-9]+');

        });


       
// For Google Login
Route::get('oauth/google', [\App\Http\Controllers\OauthController::class, 'redirectToProvider'])->name('oauth.google');
Route::get('oauth/google/callback', [\App\Http\Controllers\OauthController::class, 'handleProviderCallback'])->name('oauth.google.callback');


require __DIR__.'/auth.php';

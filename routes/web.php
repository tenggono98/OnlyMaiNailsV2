<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// Route::view('/', 'welcome');

Route::get('/',\App\Livewire\Homepage::class)->name('home');
Route::get('/book',\App\Livewire\Book::class)->name('book');
Route::get('/user/login',\App\Livewire\Login::class)->name('user.login');





// Route::group(['middleware'=>'role:admin'],function () {

//     Route::view('dashboard', 'dashboard')
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');

// });


Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::prefix('admin')->group(function () {
        Route::get('/dashboard',\App\Livewire\Admin\Dashboard::class)->name('admin.dashboard');
        Route::view('/profile', 'profile') ->middleware(['auth']) ->name('profile');
    });



});

Route::middleware(['auth', 'role:user'])->group(function () {


});





// For Google Login
Route::get('oauth/google', [\App\Http\Controllers\OauthController::class, 'redirectToProvider'])->name('oauth.google');
Route::get('oauth/google/callback', [\App\Http\Controllers\OauthController::class, 'handleProviderCallback'])->name('oauth.google.callback');




require __DIR__.'/auth.php';

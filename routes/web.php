<?php
use App\Http\Controllers\Pdf\BookingComplete;
use App\Http\Controllers\Pdf\BookingInvoice;
use App\Livewire\DraftUI\BookingMail;
use Illuminate\Support\Facades\Route;

// OLD UI
// For Login
Route::get('/user/login', \App\Livewire\Login::class)->name('user.login');
// Can be access as "Guest"
//Route::get('/',\App\Livewire\NewUI\Homepage::class)->name('home');
// Route::get('/services',\App\Livewire\Services::class)->name('services');
Route::get('/book',\App\Livewire\Book::class)->middleware('throttle:20,1')->name('book');
Route::get('/contact_us',\App\Livewire\ContactUs::class)->name('contact_us');
// Route::get('/product',\App\Livewire\Product::class)->name('product');
Route::get('/draftui/mail_book',\App\Livewire\DraftUI\BookingMail::class)->name('draftui.mail_book');
//OLD UI - END

//NEW UI
Route::get('/', \App\Livewire\V2\Homepage::class)->name('home');
Route::get('/services',\App\Livewire\V2\Services::class)->name('services');

//NEW UI - END
// PDF
Route::get('/pdf', [BookingComplete::class, 'createPDF'])->name('pdf.test');
Route::get('/pdf_view', [BookingInvoice::class, 'show'])->name('pdf.test_view');
    // Protected the route
        Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
            // Can be access as "Admin"
            Route::get('/dashboard',\App\Livewire\Admin\Dashboard::class)->name('admin.dashboard');
            Route::view('/profile', 'profile')->middleware(['auth']) ->name('profile');
            Route::get('/booking',\App\Livewire\Admin\Booking::class)->name('admin.booking');
            Route::get('/schedule',\App\Livewire\Admin\Schedule::class)->name('admin.schedule');
            Route::get('/service',\App\Livewire\Admin\Service::class)->name('admin.service');
            Route::get('/setting',\App\Livewire\Admin\Setting::class)->name('admin.setting');
            Route::get('/users',\App\Livewire\Admin\Users::class)->name('admin.users');
            Route::get('/product',\App\Livewire\Admin\Product::class)->name('admin.product');
            Route::get('/users/{type}',\App\Livewire\Admin\Users::class)->name('admin.users.type');
            Route::get('/review',\App\Livewire\Admin\ReviewUser::class)->name('admin.review');
            Route::get('/homepage-images',\App\Livewire\Admin\HomepageImages::class)->name('admin.homepage-images');

        });
        //OLD UI
         // Can be access as "User"
         Route::middleware(['redirectToUserLogin', 'role:user'])->group(function () {
            // Change Info Profile
            Route::get('/change_profile',\App\Livewire\User\ChangeProfile::class)->name('user.change_profile')->where('id', '[0-9]+');
            // Rechedule or Cancel
            Route::get('/book/schedule/{uuid}',\App\Livewire\User\RescheduleorCancel::class)->name('user.reschedule_or_cancel');
            // Booking History
            Route::get('/book/history_booking',\App\Livewire\User\HistoryBooking::class)->name('user.history_booking');

            //    NEW UI
         });
// For Google Login
Route::get('oauth/google', [\App\Http\Controllers\OauthController::class, 'redirectToProvider'])->name('oauth.google');
Route::get('oauth/google/callback', [\App\Http\Controllers\OauthController::class, 'handleProviderCallback'])->name('oauth.google.callback');
require __DIR__.'/auth.php';

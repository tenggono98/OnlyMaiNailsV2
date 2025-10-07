<?php
use App\Http\Controllers\Pdf\BookingComplete;
use App\Http\Controllers\Pdf\BookingInvoice;
use App\Livewire\DraftUI\BookingMail;
use Illuminate\Support\Facades\Route;

// OLD UI
// For Login
Route::get('/user/login', \App\Livewire\Login::class)->name('user.login');
Route::get('/user/signup', \App\Livewire\SignUp::class)->name('user.signup');
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
// Public Shop routes (no auth required)
Route::get('/shop', \App\Livewire\V2\Shop\Products::class)->name('shop.index');
// Redirect old ID-based URLs to slug-based URLs for SEO (must come first)
Route::get('/shop/product/{id}', function ($id) {
    $product = \App\Models\MProduct::find($id);
    if ($product && $product->slug) {
        return redirect()->route('shop.product', $product->slug, 301);
    }
    abort(404);
})->where('id', '[0-9]+');
// Main product route with slug
Route::get('/shop/product/{slug}', \App\Livewire\V2\Shop\ProductDetail::class)->name('shop.product');
Route::get('/shop/cart', \App\Livewire\V2\Shop\Cart::class)->name('shop.cart');
Route::get('/shop/checkout', \App\Livewire\V2\Shop\Checkout::class)->name('shop.checkout');
Route::get('/shop/order/thank-you/{id}', \App\Livewire\V2\Shop\OrderThankYou::class)->name('shop.order.thankyou');
Route::middleware(['redirectToUserLogin', 'role:user'])->group(function () {
    Route::get('/shop/orders', \App\Livewire\V2\Shop\OrderHistory::class)->name('shop.orders');
    Route::get('/shop/order/{uuid}', \App\Livewire\V2\Shop\OrderDetail::class)->name('shop.order.detail');
});

//NEW UI - END
// PDF
Route::get('/pdf', [BookingComplete::class, 'createPDF'])->name('pdf.test');
Route::get('/pdf_view', [BookingInvoice::class, 'show'])->name('pdf.test_view');
Route::get('/admin/shop/invoice/{id}/download', [\App\Http\Controllers\Pdf\ShopInvoice::class, 'download'])
    ->middleware(['auth','role:admin'])
    ->name('admin.shop.invoice.download');
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
            // Shop
            Route::get('/shop/products', \App\Livewire\Admin\Shop\Products::class)->name('admin.shop.products');
            Route::get('/shop/stock', \App\Livewire\Admin\Shop\Stock::class)->name('admin.shop.stock');
            Route::get('/shop/orders', \App\Livewire\Admin\Shop\Orders::class)->name('admin.shop.orders');
            Route::get('/shop/invoices', \App\Livewire\Admin\Shop\Invoices::class)->name('admin.shop.invoices');
            Route::get('/shop/variant-images', \App\Livewire\Admin\Shop\VariantImages::class)->name('admin.shop.variant-images');

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
            // (Shop routes moved to public section above)
         });
// For Google Login
Route::get('oauth/google', [\App\Http\Controllers\OauthController::class, 'redirectToProvider'])->name('oauth.google');
Route::get('oauth/google/callback', [\App\Http\Controllers\OauthController::class, 'handleProviderCallback'])->name('oauth.google.callback');
require __DIR__.'/auth.php';

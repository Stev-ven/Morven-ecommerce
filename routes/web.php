<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Auth\EmailVerificationController;


Route::get('/', [HomeController::class, 'homepage'])->name('home');

// New category routes
Route::get('/clothing', [HomeController::class, 'viewClothing'])->name('clothing');
Route::get('/footwear', [HomeController::class, 'viewFootwear'])->name('footwear');
Route::get('/accessories', [HomeController::class, 'viewAccessoriesCategory'])->name('accessories');
Route::get('/activewear', [HomeController::class, 'viewActivewear'])->name('activewear');
Route::get('/grooming', [HomeController::class, 'viewGrooming'])->name('grooming');

// Old routes (keeping for backward compatibility)
Route::get('/men', [HomeController::class, 'viewMen'])->name('men');
Route::get('/sneakers', [HomeController::class, 'viewSneakers'])->name('sneakers');
Route::get('/women', [HomeController::class, 'viewWomen'])->name('women');
Route::get('/kids', [HomeController::class, 'viewKids'])->name('kids');

Route::get('/product/{id}', [ProductController::class, 'viewProduct'])->name('product_details');
Route::get('/collection/{id}', [HomeController::class, 'viewCollection'])->name('collection');

Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');
Route::get('/cart-details', [CartController::class, 'viewCart'])->name('viewCart');
Route::get('/cart/place-order', [CartController::class, 'placeOrder'])->name('placeOrder');
// Route::get('/cart/payment', [CartController::class, 'payment'])->name('payment');
Route::get('/cart/payment', [PaymentController::class, 'payment'])->name('payment');

// Payment routes
Route::get('/payment/callback', [PaymentController::class, 'handleCallback'])->name('payment.callback');
Route::get('/order/success/{id}', [PaymentController::class, 'orderSuccess'])->name('order.success');

// Auth routes
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');

// User routes
Route::middleware(['auth'])->group(function () {
    Route::get('/my-orders', [\App\Http\Controllers\OrderController::class, 'myOrders'])->name('my.orders');
    Route::get('/order/{id}', [\App\Http\Controllers\OrderController::class, 'show'])->name('order.details');
    Route::get('/order/{id}/invoice', [\App\Http\Controllers\OrderController::class, 'viewInvoice'])->name('order.invoice');
    Route::get('/order/{id}/invoice/download', [\App\Http\Controllers\OrderController::class, 'downloadInvoice'])->name('order.invoice.download');
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [\App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('profile.password');

    // Wishlist routes
    Route::get('/wishlist', \App\Livewire\Wishlist\WishlistPage::class)->name('wishlist.index');
    Route::post('/wishlist/toggle', [\App\Http\Controllers\WishlistController::class, 'toggle'])->name('wishlist.toggle');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/products', [\App\Http\Controllers\Admin\AdminController::class, 'products'])->name('products');
    Route::get('/products/create', [\App\Http\Controllers\Admin\AdminController::class, 'createProduct'])->name('products.create');
    Route::post('/products', [\App\Http\Controllers\Admin\AdminController::class, 'storeProduct'])->name('products.store');
    Route::get('/products/{id}/edit', [\App\Http\Controllers\Admin\AdminController::class, 'editProduct'])->name('products.edit');
    Route::put('/products/{id}', [\App\Http\Controllers\Admin\AdminController::class, 'updateProduct'])->name('products.update');
    Route::delete('/products/{id}', [\App\Http\Controllers\Admin\AdminController::class, 'deleteProduct'])->name('products.delete');
});

// Email Verification Routes
Route::get('/verify-email', [EmailVerificationController::class, 'verify'])
    ->name('verify-email')
    ->middleware('signed');

Route::post('/email/resend', [\App\Http\Controllers\Auth\EmailVerificationController::class, 'resend'])
    ->middleware(['auth'])
    ->name('verification.resend');

// Password Reset Routes
Route::get('/forgot-password', [\App\Http\Controllers\Auth\PasswordResetController::class, 'showLinkRequestForm'])
    ->name('password.request');
Route::post('/forgot-password', [\App\Http\Controllers\Auth\PasswordResetController::class, 'sendResetLinkEmail'])
    ->name('password.email');
Route::get('/reset-password/{token}', [\App\Http\Controllers\Auth\PasswordResetController::class, 'showResetForm'])
    ->name('password.reset');
Route::post('/reset-password', [\App\Http\Controllers\Auth\PasswordResetController::class, 'reset'])
    ->name('password.update');

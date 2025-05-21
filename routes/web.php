<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\GalleryController;
use Illuminate\Support\Facades\Auth;




Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');
Route::get('/gallery/{gallery}', [GalleryController::class, 'show'])->name('gallery.show');
Route::view('/about', 'about')->name('about');


Route::resource('products', ProductController::class);
Route::get('/gallery/create', [GalleryController::class, 'create'])->name('gallery.create');


// Shop routes for customers
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop', [ShopController::class, 'index'])->name('shop');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// Account routes
Route::middleware(['auth'])->group(function () {
    Route::get('/account', [AccountController::class, 'profile'])->name('account.profile');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/account/edit', [AccountController::class, 'editProfile'])->name('account.profile.edit');
    Route::get('/addresses/{address}', [AccountController::class, 'getAddress']);

    // Route::get('/account/wishlist', [AccountController::class, 'wishlist'])->name('account.wishlist');
    // Route::get('/account/settings', [AccountController::class, 'settings'])->name('account.settings');


    Route::post('/orders', [OrderController::class, 'store'])
        ->name('orders.store');
    Route::get('/cart', [OrderController::class, 'index'])->name('cart.index');
    // You might want to add other order-related routes too
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::delete('/orders/{order}/cancel', [OrderController::class, 'cancel'])
        ->name('orders.cancel');

    Route::get('/orders/{order}/items', [OrderController::class, 'items'])
        ->name('orders.items');

    // Reorder route
    Route::post('/orders/{order}/reorder', [OrderController::class, 'reorder'])
        ->name('orders.reorder');



    // Account settings routes
    Route::prefix('account')->middleware(['auth'])->group(function () {
        Route::get('/wishlist', [AccountController::class, 'settings'])->name('account.wishlist');
        Route::get('/settings', [AccountController::class, 'settings'])->name('account.settings');
        Route::post('/update-password', [AccountController::class, 'updatePassword'])->name('account.update-password');

        // Address routes
        Route::post('/address', [AccountController::class, 'storeAddress'])->name('account.store-address');
        Route::put('/address/{address}', [AccountController::class, 'updateAddress'])->name('account.update-address');
        Route::delete('/address/{address}', [AccountController::class, 'deleteAddress'])->name('account.delete-address');

        // Payment method routes
        Route::post('/payment-method', [AccountController::class, 'storePaymentMethod'])->name('account.store-payment-method');
        Route::delete('/payment-method/{paymentMethod}', [AccountController::class, 'deletePaymentMethod'])->name('account.delete-payment-method');
    });
    Route::middleware('auth')->prefix('account')->group(function () {
        Route::get('settings', [AccountController::class, 'settings'])->name('account.settings');
        Route::post('add-payment-method', [AccountController::class, 'storePaymentMethod'])->name('account.add-payment-method');
        Route::delete('payment-methods/{payment}', [AccountController::class, 'deletePaymentMethod'])->name('account.delete-payment-method');
        Route::post('payment-methods/{payment}/set-default', [AccountController::class, 'setDefaultPaymentMethod'])->name('account.set-default-payment-method');
    });

    // Admin routes
    // Route::middleware(['auth', 'can:isAdmin'])->group(function () {
    //     Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    // });
    Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/users', [AdminController::class, 'indexUsers'])->name('admin.users.index');
        Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');



        Route::get('/products/pending', [AdminController::class, 'pendingProducts'])->name('admin.pending');
        Route::patch('/products/{product}/approve', [AdminController::class, 'approveProduct'])->name('admin.approve');
        Route::patch('/products/{product}/reject', [AdminController::class, 'rejectProduct'])->name('admin.reject');
        Route::post('/gallery/{gallery}/approve', [GalleryController::class, 'approve'])->name('gallery.approve');
        Route::post('/gallery/{gallery}/reject', [GalleryController::class, 'reject'])->name('gallery.reject');
    });

    // Commercial routes
    Route::middleware(['auth', 'role:commercial|admin'])->group(function () {
        Route::resource('products', ProductController::class)->except(['show']);
        Route::get('/product', [ProductController::class, 'index'])->name('product.index');
        Route::get('/gallery/create', [GalleryController::class, 'create'])->name('gallery.create');
        Route::post('/gallery', [GalleryController::class, 'store'])->name('gallery.store');
        Route::get('/gallery/{gallery}/edit', [GalleryController::class, 'edit'])->name('gallery.edit');
        Route::put('/gallery/{gallery}', [GalleryController::class, 'update'])->name('gallery.update');
        Route::delete('/gallery/{gallery}', [GalleryController::class, 'destroy'])->name('gallery.destroy');
    });
});


// Authentication Routes
Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register']);
Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

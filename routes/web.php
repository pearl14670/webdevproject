<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\Auth\LoginController as AdminLoginController;
use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Public routes
Route::get('/', function () {
    return view('welcome');
});

// User routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Cart routes
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::patch('/cart/{cartItem}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cartItem}', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::delete('/cart', [CartController::class, 'clear'])->name('cart.clear');

    // Checkout routes
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

    // Order routes
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');

    // Wishlist routes
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/{product}', [WishlistController::class, 'store'])->name('wishlist.store');
    Route::delete('/wishlist/{product}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');
});

// Product routes
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// Category routes
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Guest admin routes
    Route::middleware('guest:admin')->group(function () {
        Route::get('login', [AdminLoginController::class, 'showLoginForm'])->name('login');
        Route::post('login', [AdminLoginController::class, 'login']);
    });

    // Protected admin routes
    Route::middleware('admin')->group(function () {
        Route::post('logout', [AdminLoginController::class, 'logout'])->name('logout');
        Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // User Management
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
        Route::delete('users/{user}/clear-cart', [\App\Http\Controllers\Admin\UserController::class, 'clearCart'])->name('users.clear-cart');
        Route::post('users/{user}/block', [\App\Http\Controllers\Admin\UserController::class, 'blockUser'])->name('users.block');
        Route::post('users/{user}/unblock', [\App\Http\Controllers\Admin\UserController::class, 'unblockUser'])->name('users.unblock');

        // Product Management
        Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);

        // Category Management
        Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);

        // Order Management
        Route::resource('orders', \App\Http\Controllers\Admin\OrderController::class);
        Route::post('orders/{order}/status', [\App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('orders.status');
        Route::post('orders/{order}/confirm-payment', [\App\Http\Controllers\Admin\OrderController::class, 'confirmPayment'])->name('orders.confirm-payment');

        // Review Management
        Route::resource('reviews', \App\Http\Controllers\Admin\ReviewController::class);
        Route::put('reviews/{review}/approve', [\App\Http\Controllers\Admin\ReviewController::class, 'approve'])->name('reviews.approve');
        Route::put('reviews/{review}/reject', [\App\Http\Controllers\Admin\ReviewController::class, 'reject'])->name('reviews.reject');

        // Admin Profile Management
        Route::get('profile', [\App\Http\Controllers\Admin\ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('profile', [\App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('profile.update');
        Route::delete('profile', [\App\Http\Controllers\Admin\ProfileController::class, 'destroy'])->name('profile.destroy');
    });
});

require __DIR__.'/auth.php';

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

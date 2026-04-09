<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\UserController as AdminUserController;

// =============================================
// PUBLIC ROUTES (No login required)
// =============================================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
Route::get('/category/{id}', [ProductController::class, 'byCategory'])->name('products.category');

// =============================================
// GUEST ROUTES (Only for non-logged-in users)
// =============================================
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // Forgot Password Routes
    Route::get('/forgot-password', [AuthController::class, 'showForgotForm'])->name('password.forgot');
    Route::post('/forgot-password', [AuthController::class, 'verifyEmail'])->name('password.verify');
    Route::get('/reset-password', [AuthController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

// =============================================
// USER AUTHENTICATED ROUTES (Login required)
// =============================================
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // User Dashboard
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');

    // Profile Management
    Route::get('/profile', [UserController::class, 'profile'])->name('user.profile');
    Route::put('/profile/update', [UserController::class, 'updateProfile'])->name('user.profile.update');
    Route::put('/profile/password', [UserController::class, 'changePassword'])->name('user.password.change');

    // Cart Routes
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::put('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

    // Wishlist Routes
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/add/{productId}', [WishlistController::class, 'add'])->name('wishlist.add');
    Route::delete('/wishlist/remove/{productId}', [WishlistController::class, 'remove'])->name('wishlist.remove');
    Route::post('/wishlist/toggle/{productId}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');

    // Product Review Routes
    Route::post('/review', [ReviewController::class, 'store'])->name('reviews.store');
    Route::post('/products/{id}/review', [ReviewController::class, 'storeForProduct'])->name('products.review');

    // Checkout & Orders
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('/orders/place', [OrderController::class, 'placeOrder'])->name('orders.place');
    Route::post('/verify-payment', [OrderController::class, 'verifyPayment'])->name('payment.verify');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/order-confirmation/{id}', [OrderController::class, 'confirmation'])->name('orders.confirmation');
    Route::put('/orders/{id}/cancel', [OrderController::class, 'cancelOrder'])->name('orders.cancel');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/orders/{id}/invoice', [OrderController::class, 'downloadInvoice'])->name('orders.invoice');
});

// =============================================
// ADMIN ROUTES (Login + Admin role required)
// =============================================
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Category Management (CRUD)
    Route::get('/categories', [AdminCategoryController::class, 'index'])->name('categories');
    Route::get('/categories/create', [AdminCategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [AdminCategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{id}/edit', [AdminCategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{id}', [AdminCategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{id}', [AdminCategoryController::class, 'destroy'])->name('categories.delete');

    // Product Management (CRUD)
    Route::get('/products', [AdminProductController::class, 'index'])->name('products');
    Route::get('/products/create', [AdminProductController::class, 'create'])->name('products.create');
    Route::post('/products', [AdminProductController::class, 'store'])->name('products.store');
    Route::get('/products/{id}/edit', [AdminProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}', [AdminProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}', [AdminProductController::class, 'destroy'])->name('products.delete');

    // Order Management
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders');
    Route::get('/orders/{id}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/{id}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.status');

    // User Management
    Route::get('/users', [AdminUserController::class, 'index'])->name('users');
    Route::put('/users/{id}/role', [AdminUserController::class, 'updateRole'])->name('users.role');
    Route::delete('/users/{id}', [AdminUserController::class, 'destroy'])->name('users.delete');
});

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\FranchiseController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\Auth\LoginController;

use App\Http\Controllers\CustomerAddressController;

use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\FranchiseLeadController as AdminFranchiseLeadController;
use App\Http\Controllers\Admin\EventLeadController as AdminEventLeadController;
use App\Http\Controllers\Admin\SettingsController as AdminSettingsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Site
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/our-story', [PageController::class, 'ourStory'])->name('our-story');
Route::get('/locations', [PageController::class, 'locations'])->name('locations');

Route::get('/catering', [PageController::class, 'catering'])->name('catering');
Route::post('/catering', [PageController::class, 'storeCateringLead'])->name('catering.store');

Route::get('/gallery', [PageController::class, 'gallery'])->name('gallery');

Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [PageController::class, 'storeContactLead'])->name('contact.store');

Route::get('/franchise', [FranchiseController::class, 'index'])->name('franchise.index');
Route::post('/franchise/apply', [FranchiseController::class, 'apply'])->name('franchise.apply');

// Menu & Catalog
Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
Route::get('/menu/{slug}', [MenuController::class, 'show'])->name('menu.show');

// AJAX Cart
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/cart/data', [CartController::class, 'getCartData'])->name('cart.data');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');

// Auth Gates
Route::get('/login', [OtpController::class, 'showLoginForm'])->name('login');
Route::post('/login/otp/send', [OtpController::class, 'sendOtp'])->name('login.otp.send');
Route::post('/login/otp/verify', [OtpController::class, 'verifyOtp'])->name('login.otp.verify');
Route::post('/login/password', [LoginController::class, 'login'])->name('login.password');
Route::any('/logout', [OtpController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Authenticated User Portals
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'track'])->group(function () {

    // 1. CUSTOMER PORTAL
    Route::middleware(['role:customer'])->prefix('customer')->name('customer.')->group(function () {
        Route::get('/dashboard', function() { return view('customer.dashboard'); })->name('dashboard');
        Route::get('/profile', function() { return view('customer.profile'); })->name('profile');
        Route::get('/addresses', function() { return view('customer.addresses'); })->name('addresses');
        Route::post('/addresses', [CustomerAddressController::class, 'store'])->name('addresses.store');
        Route::post('/addresses/delete/{id}', [CustomerAddressController::class, 'destroy'])->name('addresses.destroy');
        Route::get('/orders', function() { return view('customer.orders.index'); })->name('orders.index');
        Route::get('/orders/{id}', function($id) { return view('customer.orders.show', compact('id')); })->name('orders.show');
        Route::get('/orders/{id}/track', function($id) { return view('customer.orders.track', compact('id')); })->name('orders.track');
        Route::get('/wallet', function() { return view('customer.wallet'); })->name('wallet');
        Route::get('/support', function() { return view('customer.support.index'); })->name('support.index');
        Route::get('/support/create', function() { return view('customer.support.create'); })->name('support.create');
        Route::get('/support/{id}', function($id) { return view('customer.support.show', compact('id')); })->name('support.show');
    });

    // 2. FRANCHISE PORTAL
    Route::middleware(['role:franchise_partner'])->prefix('franchise-portal')->name('franchise.')->group(function () {
        Route::get('/dashboard', function() { return view('franchise-portal.dashboard'); })->name('dashboard');
        Route::get('/roi-calculator', function() { return view('franchise-portal.investment-calculator'); })->name('roi');
        Route::get('/training', function() { return view('franchise-portal.training'); })->name('training');
        Route::get('/documents', function() { return view('franchise-portal.documents'); })->name('documents');
        Route::get('/opportunities', function() { return view('franchise-portal.opportunities'); })->name('opportunities');
    });

    // 3. DELIVERY PARTNER PANEL
    Route::middleware(['role:delivery_partner'])->prefix('delivery')->name('delivery.')->group(function () {
        Route::get('/dashboard', function() { return view('delivery.dashboard'); })->name('dashboard');
        Route::get('/orders', function() { return view('delivery.orders.index'); })->name('orders');
        Route::get('/active', function() { return view('delivery.orders.active'); })->name('active');
        Route::get('/earnings', function() { return view('delivery.earnings'); })->name('earnings');
    });

    // 4. ADMIN & SUPER ADMIN PANEL
    Route::middleware(['role:super_admin,admin,store_manager'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', function() { return view('admin.dashboard'); })->name('dashboard');
        
        // Products CRUD
        Route::get('/products', [AdminProductController::class, 'index'])->name('products.index');
        Route::get('/products/create', [AdminProductController::class, 'create'])->name('products.create');
        Route::post('/products', [AdminProductController::class, 'store'])->name('products.store');
        Route::post('/products/delete/{id}', [AdminProductController::class, 'destroy'])->name('products.destroy');
        
        // Categories CRUD
        Route::get('/categories', [AdminCategoryController::class, 'index'])->name('categories.index');
        Route::post('/categories', [AdminCategoryController::class, 'store'])->name('categories.store');
        Route::post('/categories/delete/{id}', [AdminCategoryController::class, 'destroy'])->name('categories.destroy');
        
        // Orders Manager
        Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{id}', [AdminOrderController::class, 'show'])->name('orders.show');
        Route::post('/orders/{id}', [AdminOrderController::class, 'update'])->name('orders.update');
        
        // Lead Pipelines
        Route::get('/franchise-leads', [AdminFranchiseLeadController::class, 'index'])->name('franchise-leads.index');
        Route::post('/franchise-leads/{id}/status', [AdminFranchiseLeadController::class, 'updateStatus'])->name('franchise-leads.status');
        
        Route::get('/event-leads', [AdminEventLeadController::class, 'index'])->name('event-leads.index');
        Route::post('/event-leads/delete/{id}', [AdminEventLeadController::class, 'destroy'])->name('event-leads.destroy');
        
        // System Configs
        Route::get('/settings', [AdminSettingsController::class, 'index'])->name('settings');
        Route::post('/settings', [AdminSettingsController::class, 'update'])->name('settings.update');
        
        Route::get('/reports', function() { return view('admin.reports'); })->name('reports');
    });

});

// Checkout process (authenticated only)
Route::middleware(['auth'])->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/coupon', [CheckoutController::class, 'applyCoupon'])->name('checkout.coupon');
    Route::post('/checkout/place', [CheckoutController::class, 'placeOrder'])->name('checkout.place');
});

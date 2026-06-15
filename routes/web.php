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
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\ActivityLogController as AdminActivityLogController;
use App\Http\Controllers\Admin\SystemController as AdminSystemController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\Admin\NotificationController as AdminNotificationController;
use App\Http\Controllers\Admin\ChefController as AdminChefController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Site
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/our-story', [PageController::class, 'ourStory'])->name('our-story');
Route::get('/pages/{slug}', [PageController::class, 'showPage'])->name('pages.show');
Route::get('/locations', [PageController::class, 'locations'])->name('locations');

Route::get('/catering', [PageController::class, 'catering'])->name('catering');
Route::post('/catering', [PageController::class, 'storeCateringLead'])->name('catering.store');

Route::get('/gallery', [PageController::class, 'gallery'])->name('gallery');

Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');
Route::post('/blog/{id}/review', [BlogController::class, 'storeReview'])->name('blog.review.store')->middleware('auth');

Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [PageController::class, 'storeContactLead'])->name('contact.store');

Route::get('/franchise', [FranchiseController::class, 'index'])->name('franchise.index');
Route::post('/franchise/apply', [FranchiseController::class, 'apply'])->name('franchise.apply');

// Menu & Catalog
Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
Route::get('/menu/{slug}', [MenuController::class, 'show'])->name('menu.show');
Route::post('/product/{id}/review', [MenuController::class, 'storeReview'])->name('product.review.store')->middleware('auth');

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

// Customer Registration
Route::get('/register', [OtpController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [OtpController::class, 'register'])->name('register.submit');

// Dedicated Admin Auth Gate
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');

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
        Route::get('/orders/{id}/status', function($id) {
            $order = \App\Models\Order::find($id);
            if (!$order) {
                return response()->json(['success' => false, 'message' => 'Order not found.'], 404);
            }
            return response()->json([
                'success' => true,
                'status' => $order->status,
                'updated_at' => $order->updated_at->toIso8601String()
            ]);
        })->name('orders.status');
        Route::get('/wallet', function() { return view('customer.wallet'); })->name('wallet');
        Route::get('/support', function() { return view('customer.support.index'); })->name('support.index');
        Route::get('/support/create', function() { return view('customer.support.create'); })->name('support.create');
        Route::get('/support/{id}', function($id) { return view('customer.support.show', compact('id')); })->name('support.show');
    });

    // Global Notifications Mark Read Route
    Route::post('/notifications/read-all', function() {
        \App\Models\Notification::where('user_id', \Illuminate\Support\Facades\Auth::id())->unread()->update(['read_at' => now()]);
        return response()->json(['success' => true]);
    })->name('notifications.read-all');

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
        Route::get('/dashboard', [App\Http\Controllers\Delivery\DeliveryController::class, 'dashboard'])->name('dashboard');
        Route::get('/orders', [App\Http\Controllers\Delivery\DeliveryController::class, 'orders'])->name('orders');
        Route::post('/orders/{id}/accept', [App\Http\Controllers\Delivery\DeliveryController::class, 'acceptOrder'])->name('orders.accept');
        Route::get('/active', [App\Http\Controllers\Delivery\DeliveryController::class, 'active'])->name('active');
        Route::post('/orders/{id}/deliver', [App\Http\Controllers\Delivery\DeliveryController::class, 'markDelivered'])->name('orders.deliver');
        Route::get('/earnings', [App\Http\Controllers\Delivery\DeliveryController::class, 'earnings'])->name('earnings');
    });

    // 4. ADMIN & SUPER ADMIN PANEL
    Route::middleware(['role:super_admin,admin,store_manager'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', function() { return view('admin.dashboard'); })->name('dashboard');
        
        // Secure Logout
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

        // Admin Profile Management
        Route::get('/profile', [App\Http\Controllers\Admin\ProfileController::class, 'edit'])->name('profile.edit');
        Route::post('/profile', [App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('profile.update');
        
        // Products CRUD
        Route::get('/products', [AdminProductController::class, 'index'])->name('products.index');
        Route::get('/products/create', [AdminProductController::class, 'create'])->name('products.create');
        Route::post('/products', [AdminProductController::class, 'store'])->name('products.store');
        Route::get('/products/{id}', [AdminProductController::class, 'show'])->name('products.show');
        Route::get('/products/{id}/edit', [AdminProductController::class, 'edit'])->name('products.edit');
        Route::post('/products/update/{id}', [AdminProductController::class, 'update'])->name('products.update');
        Route::post('/products/delete/{id}', [AdminProductController::class, 'destroy'])->name('products.destroy');
        
        // Categories CRUD
        Route::get('/categories', [AdminCategoryController::class, 'index'])->name('categories.index');
        Route::post('/categories', [AdminCategoryController::class, 'store'])->name('categories.store');
        Route::post('/categories/update/{id}', [AdminCategoryController::class, 'update'])->name('categories.update');
        Route::post('/categories/delete/{id}', [AdminCategoryController::class, 'destroy'])->name('categories.destroy');
        
        // Orders Manager
        Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{id}', [AdminOrderController::class, 'show'])->name('orders.show');
        Route::post('/orders/{id}', [AdminOrderController::class, 'update'])->name('orders.update');
        
        // Lead Pipelines
        Route::get('/franchise-leads', [AdminFranchiseLeadController::class, 'index'])->name('franchise-leads.index');
        Route::get('/franchise-leads/{id}', [AdminFranchiseLeadController::class, 'show'])->name('franchise-leads.show');
        Route::post('/franchise-leads/{id}/status', [AdminFranchiseLeadController::class, 'updateStatus'])->name('franchise-leads.status');
        Route::post('/franchise-leads/delete/{id}', [AdminFranchiseLeadController::class, 'destroy'])->name('franchise-leads.destroy');

        Route::get('/event-leads', [AdminEventLeadController::class, 'index'])->name('event-leads.index');
        Route::get('/event-leads/{id}', [AdminEventLeadController::class, 'show'])->name('event-leads.show');
        Route::post('/event-leads/{id}/status', [AdminEventLeadController::class, 'updateStatus'])->name('event-leads.status');
        Route::post('/event-leads/delete/{id}', [AdminEventLeadController::class, 'destroy'])->name('event-leads.destroy');

        // Blog Management
        Route::get('/blogs', [AdminBlogController::class, 'index'])->name('blogs.index');
        Route::get('/blogs/create', [AdminBlogController::class, 'create'])->name('blogs.create');
        Route::post('/blogs', [AdminBlogController::class, 'store'])->name('blogs.store');
        Route::get('/blogs/{id}', [AdminBlogController::class, 'show'])->name('blogs.show');
        Route::get('/blogs/{id}/edit', [AdminBlogController::class, 'edit'])->name('blogs.edit');
        Route::post('/blogs/update/{id}', [AdminBlogController::class, 'update'])->name('blogs.update');
        Route::post('/blogs/delete/{id}', [AdminBlogController::class, 'destroy'])->name('blogs.destroy');
        Route::post('/blogs/{id}/toggle-publish', [AdminBlogController::class, 'togglePublish'])->name('blogs.toggle-publish');

        // Chef Management
        Route::get('/chefs', [AdminChefController::class, 'index'])->name('chefs.index');
        Route::get('/chefs/create', [AdminChefController::class, 'create'])->name('chefs.create');
        Route::post('/chefs', [AdminChefController::class, 'store'])->name('chefs.store');
        Route::get('/chefs/{id}/edit', [AdminChefController::class, 'edit'])->name('chefs.edit');
        Route::post('/chefs/update/{id}', [AdminChefController::class, 'update'])->name('chefs.update');
        Route::post('/chefs/delete/{id}', [AdminChefController::class, 'destroy'])->name('chefs.destroy');
        Route::post('/chefs/{id}/toggle-active', [AdminChefController::class, 'toggleActive'])->name('chefs.toggle-active');

        // Review Management
        Route::get('/product-reviews', [AdminReviewController::class, 'productIndex'])->name('product-reviews.index');
        Route::post('/product-reviews/{id}/toggle-approve', [AdminReviewController::class, 'productToggleApprove'])->name('product-reviews.toggle-approve');
        Route::post('/product-reviews/{id}/reply', [AdminReviewController::class, 'productReply'])->name('product-reviews.reply');
        Route::post('/product-reviews/delete/{id}', [AdminReviewController::class, 'productDestroy'])->name('product-reviews.destroy');

        Route::get('/blog-reviews', [AdminReviewController::class, 'blogIndex'])->name('blog-reviews.index');
        Route::post('/blog-reviews/{id}/toggle-approve', [AdminReviewController::class, 'blogToggleApprove'])->name('blog-reviews.toggle-approve');
        Route::post('/blog-reviews/{id}/reply', [AdminReviewController::class, 'blogReply'])->name('blog-reviews.reply');
        Route::post('/blog-reviews/delete/{id}', [AdminReviewController::class, 'blogDestroy'])->name('blog-reviews.destroy');

        // Notification Actions
        Route::post('/notifications/{id}/mark-read', [AdminNotificationController::class, 'markRead'])->name('notifications.mark-read');
        Route::post('/notifications/{id}/delete', [AdminNotificationController::class, 'destroy'])->name('notifications.delete');
        Route::post('/notifications/mark-all-read', [AdminNotificationController::class, 'markAllRead'])->name('notifications.mark-all-read');
        
        // Users CRUD
        Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
        Route::get('/users/{id}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
        Route::post('/users/{id}', [AdminUserController::class, 'update'])->name('users.update');
        Route::post('/users/delete/{id}', [AdminUserController::class, 'destroy'])->name('users.destroy');

        // Pages CMS
        Route::get('/pages', [AdminPageController::class, 'index'])->name('pages.index');
        Route::get('/pages/create', [AdminPageController::class, 'create'])->name('pages.create');
        Route::post('/pages', [AdminPageController::class, 'store'])->name('pages.store');
        Route::get('/pages/{id}/edit', [AdminPageController::class, 'edit'])->name('pages.edit');
        Route::post('/pages/{id}', [AdminPageController::class, 'update'])->name('pages.update');
        Route::post('/pages/delete/{id}', [AdminPageController::class, 'destroy'])->name('pages.destroy');

        // Activity Logs
        Route::get('/activity-logs', [AdminActivityLogController::class, 'index'])->name('activity-logs.index');

        // System Configs & Tools
        Route::get('/settings', [AdminSettingsController::class, 'index'])->name('settings');
        Route::post('/settings', [AdminSettingsController::class, 'update'])->name('settings.update');
        
        Route::post('/system/cache/clear', [AdminSystemController::class, 'clearCache'])->name('system.cache.clear');
        Route::get('/system/backup/export', [AdminSystemController::class, 'exportBackup'])->name('system.backup.export');
        Route::post('/system/maintenance/toggle', [AdminSystemController::class, 'toggleMaintenance'])->name('system.maintenance.toggle');
        Route::get('/system/tokens', [AdminSystemController::class, 'apiTokens'])->name('system.tokens.index');
        Route::post('/system/tokens', [AdminSystemController::class, 'generateApiToken'])->name('system.tokens.generate');
        Route::post('/system/tokens/revoke/{id}', [AdminSystemController::class, 'revokeApiToken'])->name('system.tokens.revoke');
        Route::get('/notifications', [AdminSystemController::class, 'notifications'])->name('notifications.index');

        Route::get('/reports', function() { return view('admin.reports'); })->name('reports');
    });

});

// Checkout process (authenticated only)
Route::middleware(['auth'])->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/coupon', [CheckoutController::class, 'applyCoupon'])->name('checkout.coupon');
    Route::post('/checkout/place', [CheckoutController::class, 'placeOrder'])->name('checkout.place');
});

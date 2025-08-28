<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\DashboardRedirectController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SocialAuthController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\UserReportController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\Admin\ReportDashController;

// Admin Controllers
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Admin\OnsaleController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\HomepageBannerController;
use App\Http\Controllers\Admin\SellerController as AdminSellerController;

// Seller (vendor) area controllers
use App\Http\Controllers\Seller\DashboardController;
use App\Http\Controllers\Seller\StorefrontController;
use App\Http\Controllers\Seller\ProductController as SellerProductController;
use App\Http\Controllers\Seller\SettingsController as SellerSettingsController;


/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::view('/about', 'about')->name('about');
Route::view('/contact', 'contact')->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');
Route::get('/faq', [FaqController::class, 'index'])->name('faq');
Route::get('/help', [HelpController::class, 'index'])->name('help');

// Language & Currency
Route::get('locale/{locale}', [LocaleController::class, 'switch'])->name('locale.switch');
Route::get('currency/{currency}', [CurrencyController::class, 'switch'])->name('currency.switch');

// Admin Banner quick actions (outside admin group originally)
Route::post('admin/settings/add-banner', [SettingsController::class, 'addBanner'])->name('admin.settings.add_banner');
Route::delete('admin/settings/delete-banner/{banner}', [SettingsController::class, 'deleteBanner'])->name('admin.settings.delete_banner');
Route::put('/admin/settings/banner/{banner}/edit', [SettingsController::class, 'editBanner'])->name('admin.settings.edit_banner');

// Catalog
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('category.show');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/product/{product:slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/shops-on-sale', [ProductController::class, 'shopsOnSale'])->name('products.shops_on_sale');

/*
|--------------------------------------------------------------------------
| User Report Routes
|--------------------------------------------------------------------------
*/
Route::prefix('user-report')->name('user_report.')->group(function () {
    Route::get('/create', [UserReportController::class, 'create'])->name('create');
    Route::post('/', [UserReportController::class, 'store'])->name('store');
    Route::get('/{id}', [UserReportController::class, 'show'])->name('show');
});

/*
|--------------------------------------------------------------------------
| Authenticated User Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardRedirectController::class, 'redirectToDashboard'])
        ->middleware(['verified'])
        ->name('dashboard');

    // Reviews
    Route::resource('reviews', ReviewController::class)->only(['store', 'edit', 'update']);
    Route::delete('reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

    // Cart
    Route::post('/cart', [CartController::class, 'store'])->name('cart.ajax.add');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/add/{product}', [CartController::class, 'add'])->name('add');
        Route::put('/update', [CartController::class, 'update'])->name('update');
        Route::delete('/remove/{product}', [CartController::class, 'remove'])->name('remove');
        Route::delete('/clear', [CartController::class, 'clear'])->name('clear');
        Route::get('/count', [CartController::class, 'count'])->name('count');
    });

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
    Route::post('/notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');

    // Wishlist
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist', [WishlistController::class, 'store'])->name('wishlist.store');
    Route::delete('/wishlist', [WishlistController::class, 'destroy'])->name('wishlist.destroy');
    Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');

    // Orders (user)
    Route::get('/my-orders', [OrderController::class, 'userOrders'])->name('orders.history');
    Route::get('/orders/{orderNumber}', [OrderController::class, 'show'])->name('orders.show');

    // Checkout
    Route::prefix('checkout')->name('checkout.')->group(function () {
        Route::get('/', [CheckoutController::class, 'index'])->name('index');
        Route::post('/', [CheckoutController::class, 'placeOrder'])->name('placeOrder');
        Route::get('/confirmation/{orderNumber}', [CheckoutController::class, 'confirmation'])->name('confirmation');
        Route::post('/paypal-capture', [CheckoutController::class, 'paypalCapture'])->name('paypal.capture');
    });

    // Profile (original)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ALIAS profile routes (account.*) – added fix
    Route::get('/account/profile', [ProfileController::class, 'edit'])->name('account.profile.edit');
    Route::patch('/account/profile', [ProfileController::class, 'update'])->name('account.profile.update');
    Route::delete('/account/profile', [ProfileController::class, 'destroy'])->name('account.profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Social Auth & Verification
|--------------------------------------------------------------------------
*/
Route::get('auth/{provider}', [SocialAuthController::class, 'redirect'])->name('social.login');
Route::get('auth/{provider}/callback', [SocialAuthController::class, 'callback'])->name('social.callback');
Route::get('/social/confirm', [SocialAuthController::class, 'confirm'])->name('social.confirm');
Route::post('/social/confirm/proceed', [SocialAuthController::class, 'confirmProceed'])->name('social.confirm.proceed');
Route::post('/social/confirm/cancel', [SocialAuthController::class, 'confirmCancel'])->name('social.confirm.cancel');

Route::get('/verify', [VerificationController::class, 'showForm'])->name('code.verify.form');
Route::post('/verify', [VerificationController::class, 'verifyCode'])->name('code.verify');
Route::get('/send-verification-code', [VerificationController::class, 'sendVerificationCode'])->name('code.send');

/*
|--------------------------------------------------------------------------
| Admin Routes (auth + admin)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])
    ->name('admin.')
    ->group(function () {
        Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('reports-dash', [ReportDashController::class, 'index'])->name('reports-dash.index');

        // Product import (before resource)
        Route::get('products/import', [AdminProductController::class, 'showImportForm'])->name('products.import.form');
        Route::post('products/import', [AdminProductController::class, 'import'])->name('products.import');
        Route::resource('products', AdminProductController::class);

        Route::resource('categories', AdminCategoryController::class);
        Route::resource('orders', AdminOrderController::class);
        Route::resource('customers', CustomerController::class)
            ->only(['index', 'create', 'store', 'edit', 'update', 'show', 'destroy']);
        Route::resource('reports', UserReportController::class)->only(['index', 'show']);

        Route::resource('reviews', AdminReviewController::class)->only(['index', 'edit', 'update', 'show']);
        Route::delete('reviews/{review}', [AdminReviewController::class, 'destroy'])->name('reviews.destroy');

        Route::resource('onsale', OnsaleController::class)
            ->only(['index', 'edit', 'update'])
            ->parameters(['onsale' => 'product']);

        Route::get('settings/banner/{banner}/edit', [SettingsController::class, 'showEditBanner'])->name('settings.banner.edit');
        Route::put('settings/banner/{banner}', [SettingsController::class, 'updateBanner'])->name('settings.banner.update');
        Route::patch('products/{product}/remove-sale', [OnsaleController::class, 'removeFromSale'])->name('products.removeFromSale');

        // Settings sectional saves
        Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
        Route::post('settings/policies', [SettingsController::class, 'savePolicies'])->name('settings.savePolicies');
        Route::post('settings/general', [SettingsController::class, 'saveGeneral'])->name('settings.save_general');
        Route::post('settings/storefront', [SettingsController::class, 'saveStorefront'])->name('settings.save_storefront');
        Route::post('settings/payment', [SettingsController::class, 'savePayment'])->name('settings.save_payment');
        Route::post('settings/shipping', [SettingsController::class, 'saveShipping'])->name('settings.save_shipping');

        /*
         * Seller management (force binding by numeric id using {seller:id})
         */
        Route::get('sellers', [AdminSellerController::class, 'index'])->name('sellers.index');
        Route::get('sellers/{seller:id}', [AdminSellerController::class, 'show'])->name('sellers.show');
        Route::get('sellers/{seller:id}/edit', [AdminSellerController::class, 'edit'])->name('sellers.edit');
        Route::put('sellers/{seller:id}', [AdminSellerController::class, 'update'])->name('sellers.update');
        Route::patch('sellers/{seller:id}/status/{status}', [AdminSellerController::class, 'updateStatus'])->name('sellers.updateStatus');
    });

/*
|--------------------------------------------------------------------------
| Become a Seller (user -> seller registration)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('/become-seller', [SellerController::class, 'showRegistrationForm'])->name('seller.register.form');
    Route::post('/become-seller', [SellerController::class, 'register'])->name('seller.register');
});

/*
|--------------------------------------------------------------------------
| Seller (Vendor) Dashboard & Product Management
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('seller')->name('seller.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Seller settings routes
    Route::get('settings', [SellerSettingsController::class, 'edit'])->name('settings.edit');
    Route::post('settings', [SellerSettingsController::class, 'update'])->name('settings.update');

    Route::get('products/import', [SellerProductController::class, 'showImportForm'])->name('products.import.form');
    Route::post('products/import', [SellerProductController::class, 'import'])->name('products.import');

    Route::get('products/{product}/edit', [SellerProductController::class, 'edit'])
        ->name('products.edit')->where('product', '[0-9]+');
    Route::get('products/{product}', [SellerProductController::class, 'show'])
        ->name('products.show')->where('product', '[0-9]+');

    Route::resource('products', SellerProductController::class)->except(['edit', 'show']);
});

/*
|--------------------------------------------------------------------------
| Public Storefront Directory (uses slug)
|--------------------------------------------------------------------------
*/
Route::get('/stores', [StorefrontController::class, 'index'])->name('stores.index');
Route::get('/store/{seller:slug}', [StorefrontController::class, 'show'])->name('store.show');

require __DIR__ . '/auth.php';
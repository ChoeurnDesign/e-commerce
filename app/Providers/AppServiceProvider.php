<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use App\Services\CartService;
use App\View\Composers\CartComposer;
use App\Services\CurrencyService;
use App\Models\Report;
use App\Models\Setting;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton('currencyService', CurrencyService::class);

        $this->app->singleton(CartService::class, function ($app) {
            return new CartService();
        });

        // Automatically load all helpers in app/Helpers
        foreach (glob(app_path('Helpers') . '/*.php') as $filename) {
            require_once $filename;
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Provide cartCount to all views via CartComposer
        View::composer('*', CartComposer::class);

        // Provide wishlistCount and unreadCount to all views for users
        View::composer('*', function ($view) {
            $wishlistCount = 0;
            $userUnreadCount = 0;

            if (Auth::check()) {
                $wishlistCount = Auth::user()->wishlistProducts()->count();
                $userUnreadCount = Auth::user()->unreadNotifications()->count();
            }

            $view->with('wishlistCount', $wishlistCount)
                ->with('userUnreadCount', $userUnreadCount);
        });

        // Provide $reports and $unreadCount to admin notification partial
        View::composer('admin.partials.noti', function ($view) {
            $reports = \App\Models\UserReport::latest()->take(5)->get();
            $unreadCount = \App\Models\UserReport::where('is_read', false)->count();
            $view->with('reports', $reports)
                ->with('unreadCount', $unreadCount);
        });

        // Set application locale from session
         if (Session::has('lang')) {
            App::setLocale(Session::get('lang', 'en'));
        }

        // Fetch all settings and make them available to all views.
        // This is a more robust way to handle all your settings in one place.
        View::composer('*', function ($view) {
            $settings = Setting::pluck('value', 'key')->toArray();
            $view->with('settings', $settings);
        });


    }
}

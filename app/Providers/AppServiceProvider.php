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
                 ->with('userUnreadCount', $userUnreadCount); // renamed to avoid collision with admin noti
        });

        // Provide $reports and $unreadCount to admin notification partial
        View::composer('admin.partials.noti', function ($view) {
            $reports = \App\Models\Report::latest()->take(5)->get();
            $unreadCount = \App\Models\Report::where('is_read', false)->count();
            $view->with('reports', $reports)
                 ->with('unreadCount', $unreadCount);
        });

        // Set application locale from session
        App::setLocale(Session::get('locale', config('app.locale')));
    }
}

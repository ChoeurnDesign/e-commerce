<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
        View::composer('*', \App\View\Composers\CartComposer::class);

        // Provide wishlistCount and unreadUserChats to all views for users
        View::composer('*', function ($view) {
            $wishlistCount = 0;
            $unreadUserChats = 0;

            if (Auth::check()) {
                $user = Auth::user();

                try {
                    $wishlistCount = $user->wishlistProducts()->count();
                } catch (\Throwable $e) {
                    Log::warning('Failed to compute wishlistCount: ' . $e->getMessage());
                    $wishlistCount = 0;
                }

                try {
                    $unreadUserChats = DB::table('chat_messages')
                        ->join('chat_participants', 'chat_messages.chat_id', '=', 'chat_participants.chat_id')
                        ->where('chat_participants.user_id', $user->id)
                        ->where('chat_messages.sender_id', '!=', $user->id)
                        ->where(function ($q) {
                            $q->whereNull('chat_messages.is_read')
                              ->orWhere('chat_messages.is_read', false);
                        })
                        ->where(function ($q) {
                            $q->whereNull('chat_participants.last_read_at')
                              ->orWhereColumn('chat_messages.created_at', '>', 'chat_participants.last_read_at');
                        })
                        ->count();
                } catch (\Throwable $e) {
                    Log::warning('Failed to compute unreadUserChats in view composer: ' . $e->getMessage());
                    $unreadUserChats = 0;
                }
            }

            $view->with('wishlistCount', (int) $wishlistCount)
                 ->with('unreadUserChats', (int) $unreadUserChats);
        });

        // Provide $reports and $unreadCount to admin notification partial
        View::composer('admin.partials.noti', function ($view) {
            $reports = \App\Models\UserReport::latest()->take(5)->get();
            $unreadCount = \App\Models\UserReport::where('is_read', false)->count();
            $view->with('reports', $reports)
                ->with('unreadCount', $unreadCount);
        });

        // Provide unreadSellerChats to the seller header so the chat icon is correct on every seller page
        View::composer('seller.partials.header', function ($view) {
            $user = Auth::user();
            $count = 0;

            if ($user) {
                try {
                    $count = DB::table('chat_messages')
                        ->join('chat_participants', 'chat_messages.chat_id', '=', 'chat_participants.chat_id')
                        ->where('chat_participants.user_id', $user->id)
                        ->where('chat_messages.sender_id', '!=', $user->id)
                        ->where(function ($q) {
                            $q->whereNull('chat_messages.is_read')
                              ->orWhere('chat_messages.is_read', false);
                        })
                        ->where(function ($q) {
                            $q->whereNull('chat_participants.last_read_at')
                              ->orWhereColumn('chat_messages.created_at', '>', 'chat_participants.last_read_at');
                        })
                        ->count();
                } catch (\Throwable $e) {
                    Log::error('Failed computing unreadSellerChats in view composer', [
                        'user_id' => $user->id ?? null,
                        'message' => $e->getMessage(),
                    ]);
                    $count = 0;
                }
            }

            $view->with('unreadSellerChats', (int) $count);
        });

        // Set application locale from session
        if (Session::has('lang')) {
            App::setLocale(Session::get('lang', 'en'));
        }

        // Restore settings composer (your original settings code)
        View::composer('*', function ($view) {
            $settings = Setting::pluck('value', 'key')->toArray();
            $view->with('settings', $settings);
        });
    }
}
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class SetLocale
{
    public function handle($request, Closure $next)
{
    // Debug: log the current session language and locale
    Log::info('SetLocale middleware:', [
        'session_lang' => Session::get('lang'),
        'app_locale' => App::getLocale()
    ]);
    App::setLocale(Session::get('lang', config('app.locale', 'en')));
    return $next($request);
}
}

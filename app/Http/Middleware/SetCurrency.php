<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetCurrency
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('currency')) {
            session(['currency' => 'usd']); // Just use USD as default
        }
        return $next($request);
    }
}

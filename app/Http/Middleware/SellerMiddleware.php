<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class SellerMiddleware
{
    public function handle($request, Closure $next)
    {
        // Use your actual field to check if user is a seller, e.g. is_seller or role
        if (Auth::check() && Auth::user()->is_seller) {
            return $next($request);
        }
        abort(403, 'Unauthorized');
    }
}

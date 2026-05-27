<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class SellerMiddleware
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->isSeller()) {
            $seller = Auth::user()->seller;
            if ($seller && $seller->status === 'approved') {
                return $next($request);
            }
            // Seller exists but not yet approved
            abort(403, 'Your seller account is pending approval or has been rejected.');
        }
        abort(403, 'Unauthorized.');
    }
}

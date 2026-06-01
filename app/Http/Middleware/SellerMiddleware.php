<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class SellerMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user   = Auth::user();
        $seller = $user->seller;

        if ($seller && $seller->status === 'approved') {
            return $next($request);
        }

        // Redirect with a clear message instead of a hard 403
        $message = match ($seller?->status) {
            'pending'  => 'Your seller application is still under review. We\'ll email you when it\'s approved.',
            'rejected' => 'Your seller application was not approved.' . ($seller->admin_comment ? ' Reason: ' . $seller->admin_comment : ' Please contact support.'),
            default    => 'You need an approved seller account to access this page.',
        };

        return redirect()->route('seller.register.form')->with('info', $message);
    }
}

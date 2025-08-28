<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureSellerApproved
{
    public function handle(Request $request, Closure $next)
    {
        $seller = auth()->user()->seller;
        if (!$seller) {
            return redirect()->route('sell.start');
        }
        if ($seller->status !== 'approved') {
            // Allow access but maybe redirect to limited page; here simple redirect.
            return redirect()->route('seller.settings.edit')
                ->with('info', 'Your seller account is not approved yet.');
        }
        return $next($request);
    }
}
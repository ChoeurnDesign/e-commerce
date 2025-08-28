<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureSellerExists
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        if (!$user || !$user->seller) {
            return redirect()
                ->route('seller.register.form')
                ->with('warning', 'You must create a seller account first.');
        }
        return $next($request);
    }
}
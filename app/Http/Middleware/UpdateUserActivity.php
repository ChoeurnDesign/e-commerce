<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UpdateUserActivity
{
    public function handle(Request $request, Closure $next)
    {
        // Only update activity for authenticated users
        if (Auth::check()) {
            try {
                Auth::user()->updateLastActive();
            } catch (\Exception $e) {
                Log::error('Failed to update user activity: ' . $e->getMessage());
            }
        }

        return $next($request);
    }
}
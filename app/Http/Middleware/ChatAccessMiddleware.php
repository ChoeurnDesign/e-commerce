<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ChatAccessMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Ensure user is authenticated
        if (!auth()->check()) {
            // For AJAX / fetch requests return JSON 401
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json(['message' => 'Unauthenticated. Please login.'], 401);
            }

            return redirect()->route('login')->with('error', 'Please login to access chat.');
        }

        $role = optional(auth()->user())->role;

        // Allow known roles; adapt to your app's role naming
        $allowed = ['seller', 'customer', 'user', 'admin'];

        if (in_array($role, $allowed, true)) {
            return $next($request);
        }

        // For AJAX/fetch return JSON 403
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json(['message' => 'Forbidden. You do not have access to the chat feature.'], 403);
        }

        return redirect()->route('home')->with('error', 'You do not have access to the chat feature.');
    }
}
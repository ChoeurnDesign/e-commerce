<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <--- Add this line

class DashboardRedirectController extends Controller
{
    public function redirectToDashboard()
    {
        if (Auth::check()) { // You can use Auth::check() here
            if (Auth::user()->role === 'admin') { // And Auth::user() here
                return redirect()->route('admin.dashboard');
            }
            // Regular users get redirected to home
            return redirect()->route('home');
        }

        // Not logged in users get redirected to login
        return redirect()->route('login');
    }
}

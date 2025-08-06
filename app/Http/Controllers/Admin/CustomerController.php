<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class CustomerController extends Controller
{
    public function index()
    {
        // Only show users with 'user' role (not admins)
        $customers = User::where('role', 'user')->latest()->paginate(10);

        return view('admin.customers.index', compact('customers'));
    }
}

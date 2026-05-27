<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $searchTerm = $request->input('q');
        
        if ($searchTerm) {
            $searchTerm = urldecode($searchTerm);
        }
        
        $customers = User::query()
            ->where('role', 'user')
            ->when($searchTerm, function($query, $searchTerm) {
                return $query->search($searchTerm);
            })
            ->orderBy('id', 'asc')  // ← Change this from latest() to orderBy id
            ->paginate(10)
            ->withQueryString();

        return view('admin.customers.index', compact('customers'));
    }

    public function show(int $id)
    {
        $customer = User::findOrFail($id);
        return view('admin.customers.show', compact('customer'));
    }

    public function create()
    {
        return view('admin.customers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role'  => 'required|in:user,admin',
        ]);

        User::create($validated);

        return redirect()->route('admin.customers.index')->with('success', 'Customer added!');
    }

    public function edit(int $id)
    {
        $customer = User::findOrFail($id);
        return view('admin.customers.edit', compact('customer'));
    }

    public function update(Request $request, int $id)
    {
        $customer = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $customer->id,
            'role' => 'required|in:user,admin,seller',
            'phone' => 'nullable|string|max:20',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'nullable|string|min:8|confirmed',
            'shipping_address' => 'nullable|string',
            'billing_address' => 'nullable|string',
            'preferred_currency' => 'nullable|string|size:3',
            'preferred_language' => 'nullable|string|size:2',
            'timezone' => 'nullable|string',
            'status' => 'nullable|in:active,suspended,banned',
            'suspension_reason' => 'nullable|string|required_if:status,suspended,banned',
        ]);

        // Handle profile image
        if ($request->hasFile('profile_image')) {
            if ($customer->profile_image && file_exists(storage_path('app/public/' . $customer->profile_image))) {
                unlink(storage_path('app/public/' . $customer->profile_image));
            }
            $validated['profile_image'] = $request->file('profile_image')->store('profile_images', 'public');
        }

        // Handle password
        if ($request->filled('password')) {
            $validated['password'] = bcrypt($request->password);
        } else {
            unset($validated['password']);
        }

        // Handle same as shipping
        if ($request->has('same_as_shipping')) {
            $validated['billing_address'] = $request->shipping_address;
        }

        $customer->update($validated);

        return redirect()->route('admin.customers.index')
            ->with('success', 'Customer updated successfully!');
    }

    public function destroy(int $id)
    {
        $customer = User::findOrFail($id);
        $customer->delete();

        return redirect()->route('admin.customers.index')->with('success', 'Customer removed successfully!');
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string)$request->input('q'));

        $customers = User::query()
            ->where('role', 'user')  // keep limiting to regular users
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    // Numeric id direct match
                    if (ctype_digit($q)) {
                        $sub->orWhere('id', (int)$q);
                    }
                    // Name / email partial
                    $sub->orWhere('name', 'like', "%{$q}%")
                        ->orWhere('email', 'like', "%{$q}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->appends(['q' => $q]);

        return view('admin.customers.index', compact('customers'));
    }

    public function show($id)
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

    public function edit($id)
    {
        $customer = User::findOrFail($id);
        return view('admin.customers.edit', compact('customer'));
    }

    public function update(Request $request, $id)
    {
        $customer = User::findOrFail($id);

        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $customer->id,
            'role'  => 'required|in:user,admin',
        ]);

        $customer->update($validated);

        return redirect()->route('admin.customers.index')->with('success', 'Customer updated!');
    }

    public function destroy($id)
    {
        $customer = User::findOrFail($id);
        $customer->delete();

        return redirect()->route('admin.customers.index')->with('success', 'Customer removed successfully!');
    }
}

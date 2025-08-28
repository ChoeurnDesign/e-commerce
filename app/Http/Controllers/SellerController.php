<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seller;
use Illuminate\Support\Facades\Auth;

class SellerController extends Controller
{
    public function showRegistrationForm()
    {
        return view('seller.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'store_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'business_document' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048'
        ]);

        $user = Auth::user();

        // Handle file upload
        $documentPath = null;
        if ($request->hasFile('business_document')) {
            $documentPath = $request->file('business_document')->store('business_docs', 'public');
        }

        // Create seller record
        Seller::create([
            'user_id' => $user->id,
            'store_name' => $request->store_name,
            'description' => $request->description,
            'business_document' => $documentPath,
            'status' => 'pending'
        ]);

        // Optionally update the user role
        $user->role = 'seller';
        $user->save();

        return redirect()->route('dashboard')->with('success', 'Your seller application has been submitted and is under review.');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'store_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'business_document' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        // Handle file upload
        if ($request->hasFile('business_document')) {
            $data['business_document'] = $request->file('business_document')->store('seller_docs', 'public');
        }

        // Create seller application (or update user's role/status)
        $request->user()->sellerApplication()->create($data);

        // Optionally, update user role to 'pending_seller'
        $request->user()->update(['role' => 'pending_seller']);

        return redirect()->route('dashboard')->with('success', 'Your application has been submitted for review.');
    }
}

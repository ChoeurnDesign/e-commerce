<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SellerController extends Controller
{
    public function index(Request $request)
    {
        $query = Seller::with('user');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($q2) use ($search) {
                    $q2->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                })->orWhere('store_name', 'like', "%{$search}%");
            });
        }

        $sellers = $query->orderBy('id', 'asc')->paginate(15);

        $stats = [
            'total'    => Seller::count(),
            'pending'  => Seller::where('status', 'pending')->count(),
            'approved' => Seller::where('status', 'approved')->count(),
            'rejected' => Seller::where('status', 'rejected')->count(),
        ];

        return view('admin.sellers.index', compact('sellers', 'stats'));
    }

    public function show(Seller $seller)
    {
        // 1. Load basic relations
        $seller->loadMissing(['user', 'products']);
        $seller->loadCount(['products']);

        // 2. Fetch data through the vendorOrders relationship
        // This solves the "empty orders" issue
        $vendorOrders = $seller->vendorOrders()->with('order')->latest()->get();
        
        // 3. Map to get the actual Order models for the table
        $orders = $vendorOrders->map(fn($vo) => $vo->order);

        // 4. Calculate stats manually since the relationship is bridged
        $seller->orders_count = $vendorOrders->count();
        $seller->total_sales = $vendorOrders->sum('seller_earnings');

        // 5. Fetch products
        $products = $seller->products ? $seller->products->sortByDesc('created_at') : collect();

        return view('admin.sellers.show', compact('seller', 'products', 'orders'));
    }

    public function edit(Seller $seller)
    {
        $seller->load('user');
        return view('admin.sellers.edit', compact('seller'));
    }

    public function update(Request $request, Seller $seller)
    {
        $validated = $request->validate([
            'name'              => 'required|string|max:255',
            'email'             => 'required|email|max:255',
            'store_name'        => 'required|string|max:255',
            'status'            => 'required|in:pending,approved,rejected',
            'business_document' => 'nullable|file|max:2048',
        ]);

        if ($seller->user) {
            $seller->user->name  = $validated['name'];
            $seller->user->email = $validated['email'];
            $seller->user->save();
        }

        $seller->store_name = $validated['store_name'];
        $seller->status     = $validated['status'];

        if ($request->hasFile('business_document')) {
            if ($seller->business_document) {
                Storage::delete($seller->business_document);
            }
            $seller->business_document = $request->file('business_document')->store('business_docs');
        }

        $seller->save();

        return redirect()
            ->route('admin.sellers.show', ['seller' => $seller->id])
            ->with('success', 'Seller updated.');
    }

    public function updateStatus(Request $request, Seller $seller, string $status)
    {
        if (!in_array($status, ['approved', 'rejected'], true)) {
            return back()->with('error', 'Invalid status.');
        }
        $seller->status = $status;
        if ($request->filled('admin_comment')) {
            $seller->admin_comment = $request->admin_comment;
        }
        $seller->save();

        return redirect()
            ->route('admin.sellers.show', ['seller' => $seller->id])
            ->with('success', "Seller {$status}.");
    }
}
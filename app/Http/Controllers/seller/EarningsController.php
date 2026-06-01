<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\VendorOrder;
use Illuminate\Support\Facades\Auth;

class EarningsController extends Controller
{
    public function index()
    {
        $seller = Auth::user()->seller;

        if (!$seller) {
            return redirect()->route('home')->with('error', 'Seller profile not found.');
        }

        $sellerId = $seller->id;

        // Completed earnings (available balance)
        $totalBalance = VendorOrder::where('seller_id', $sellerId)
            ->where('status', 'completed')
            ->sum('seller_earnings');

        // Pending earnings (not yet released)
        $pendingEarnings = VendorOrder::where('seller_id', $sellerId)
            ->whereNotIn('status', ['completed', 'cancelled'])
            ->sum('seller_earnings');

        // Total revenue (only completed — money actually realized)
        $totalRevenue = VendorOrder::where('seller_id', $sellerId)
            ->where('status', 'completed')
            ->sum('subtotal');

        // Commission actually deducted (only from completed orders — pending earnings haven't had commission "paid" yet)
        $totalCommission = VendorOrder::where('seller_id', $sellerId)
            ->where('status', 'completed')
            ->sum('commission_amount');

        // Order counts by status
        $completedOrders = VendorOrder::where('seller_id', $sellerId)->where('status', 'completed')->count();
        $pendingOrders   = VendorOrder::where('seller_id', $sellerId)->where('status', 'pending')->count();
        $totalOrders     = VendorOrder::where('seller_id', $sellerId)->whereNotIn('status', ['cancelled'])->count();

        // Transactions for the table
        $recentTransactions = VendorOrder::where('seller_id', $sellerId)
            ->with('order')
            ->latest()
            ->paginate(10);

        return view('seller.earnings.index', compact(
            'totalBalance',
            'pendingEarnings',
            'totalRevenue',
            'totalCommission',
            'completedOrders',
            'pendingOrders',
            'totalOrders',
            'recentTransactions'
        ));
    }
}

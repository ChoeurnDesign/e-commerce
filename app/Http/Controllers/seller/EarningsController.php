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

        // FIX: Calculate total balance exactly as the Blade file expects.
        $totalBalance = VendorOrder::where('seller_id', $seller->id)
            ->where('status', 'completed')
            ->sum('seller_earnings');

        // Fetch all transactions for the table
        $recentTransactions = VendorOrder::where('seller_id', $seller->id)
            ->latest()
            ->paginate(10);

        return view('seller.earnings.index', [
            'totalBalance' => $totalBalance, 
            'recentTransactions' => $recentTransactions
        ]);
    }
}
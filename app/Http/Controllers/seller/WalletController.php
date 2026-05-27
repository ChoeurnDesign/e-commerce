<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\VendorOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $seller = $user->seller;

        if (!$seller) {
            return redirect()->route('home')->with('error', 'Access Denied.');
        }

        /** * FIX 1: Calculate the Available Balance
         * This creates the $totalBalance variable your Blade file needs.
         * We filter by 'completed' so processing orders don't increase the balance.
         */
        $totalBalance = VendorOrder::where('seller_id', $seller->id)
            ->where('status', 'completed')
            ->sum('seller_earnings');

        /** * FIX 2: Rename $history to $recentTransactions
         * This matches the @forelse loop in your updated Blade file.
         */
        $recentTransactions = VendorOrder::where('seller_id', $seller->id)
            ->with('order')
            ->latest()
            ->paginate(10);

        // Optional: Keep the wallet object if you use it for other fields, 
        // but $totalBalance is what powers the main UI card now.
        $wallet = $seller->wallet ?: $seller->wallet()->create(['balance' => 0]);

        return view('seller.earnings.index', [
            'totalBalance' => $totalBalance,
            'recentTransactions' => $recentTransactions,
            'wallet' => $wallet
        ]);
    }
}
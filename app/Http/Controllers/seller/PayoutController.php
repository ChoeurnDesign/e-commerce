<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\PayoutRequest;
use App\Models\VendorOrder;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PayoutController extends Controller
{
    /** Minimum payout — configurable from settings. */
    const MIN_PAYOUT = 20.00;

    /**
     * Withdrawal page — shows current balance + payout history.
     */
    public function index()
    {
        $seller = Auth::user()->seller;
        abort_unless($seller, 403);

        // Total earnings from completed orders
        $totalEarnings = VendorOrder::where('seller_id', $seller->id)
            ->where('status', 'completed')
            ->sum('seller_earnings');

        // Already withdrawn (paid payouts)
        $totalWithdrawn = PayoutRequest::where('seller_id', $seller->id)
            ->where('status', 'paid')
            ->sum('amount');

        // Pending / approved but not yet paid (locked)
        $pendingPayouts = PayoutRequest::where('seller_id', $seller->id)
            ->whereIn('status', ['pending', 'approved'])
            ->sum('amount');

        $availableBalance = max(0, $totalEarnings - $totalWithdrawn - $pendingPayouts);

        $history = PayoutRequest::where('seller_id', $seller->id)
            ->latest()
            ->paginate(15);

        return view('seller.payouts.index', [
            'seller'           => $seller,
            'totalEarnings'    => $totalEarnings,
            'totalWithdrawn'   => $totalWithdrawn,
            'pendingPayouts'   => $pendingPayouts,
            'availableBalance' => $availableBalance,
            'history'          => $history,
            'minPayout'        => self::MIN_PAYOUT,
        ]);
    }

    /**
     * Create a new payout request.
     */
    public function store(Request $request)
    {
        $seller = Auth::user()->seller;
        abort_unless($seller, 403);

        $validated = $request->validate([
            'amount'         => 'required|numeric|min:' . self::MIN_PAYOUT,
            'bank_name'      => 'required|string|max:100',
            'account_name'   => 'required|string|max:255',
            'account_number' => 'required|string|max:50',
            'phone'          => 'nullable|string|max:20',
            'seller_note'    => 'nullable|string|max:500',
        ]);

        // Calculate available balance again (server-side safety)
        $totalEarnings = VendorOrder::where('seller_id', $seller->id)
            ->where('status', 'completed')->sum('seller_earnings');

        $totalWithdrawn = PayoutRequest::where('seller_id', $seller->id)
            ->where('status', 'paid')->sum('amount');

        $pendingPayouts = PayoutRequest::where('seller_id', $seller->id)
            ->whereIn('status', ['pending', 'approved'])->sum('amount');

        $available = $totalEarnings - $totalWithdrawn - $pendingPayouts;

        if ($validated['amount'] > $available) {
            return back()->with('error',
                'Requested amount ($' . number_format($validated['amount'], 2) .
                ') exceeds your available balance ($' . number_format($available, 2) . ').'
            )->withInput();
        }

        PayoutRequest::create([
            'seller_id'      => $seller->id,
            'amount'         => $validated['amount'],
            'bank_name'      => $validated['bank_name'],
            'account_name'   => $validated['account_name'],
            'account_number' => $validated['account_number'],
            'phone'          => $validated['phone'] ?? null,
            'seller_note'    => $validated['seller_note'] ?? null,
            'status'         => 'pending',
        ]);

        return redirect()->route('seller.payouts.index')
            ->with('success', 'Withdrawal request submitted. Admin will review and process within 1–3 business days.');
    }

    /**
     * Cancel a pending payout request (seller can cancel before admin acts).
     */
    public function destroy(PayoutRequest $payoutRequest)
    {
        $seller = Auth::user()->seller;
        abort_unless($seller && $payoutRequest->seller_id === $seller->id, 403);

        if (!$payoutRequest->isPending()) {
            return back()->with('error', 'You can only cancel pending requests.');
        }

        $payoutRequest->delete();

        return back()->with('success', 'Withdrawal request cancelled.');
    }
}

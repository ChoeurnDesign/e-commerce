<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PayoutRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PayoutController extends Controller
{
    /**
     * Pending payout queue — what admin sees in their dashboard.
     */
    public function index(Request $request)
    {
        $status = $request->input('status', 'pending');

        $payouts = PayoutRequest::with('seller')
            ->when($status, fn($q) => $q->where('status', $status))
            ->latest()
            ->paginate(20)
            ->appends($request->query());

        $counts = [
            'pending'  => PayoutRequest::where('status', 'pending')->count(),
            'approved' => PayoutRequest::where('status', 'approved')->count(),
            'paid'     => PayoutRequest::where('status', 'paid')->count(),
            'rejected' => PayoutRequest::where('status', 'rejected')->count(),
        ];

        return view('admin.payouts.index', compact('payouts', 'status', 'counts'));
    }

    /**
     * Approve — acknowledges request but money not yet transferred.
     * (Optional step — admin can skip straight to 'mark paid' if they prefer.)
     */
    public function approve(PayoutRequest $payoutRequest)
    {
        if (!$payoutRequest->isPending()) {
            return back()->with('error', 'Only pending payouts can be approved.');
        }

        $payoutRequest->update([
            'status'       => 'approved',
            'processed_by' => Auth::id(),
            'processed_at' => now(),
        ]);

        return back()->with('success', 'Payout approved. You can now transfer the money to the seller and mark it as paid.');
    }

    /**
     * Mark Paid — money has been transferred to seller's bank account.
     */
    public function markPaid(Request $request, PayoutRequest $payoutRequest)
    {
        if ($payoutRequest->isPaid() || $payoutRequest->isRejected()) {
            return back()->with('error', 'This payout cannot be marked paid (already finalized).');
        }

        $validated = $request->validate([
            'transaction_reference' => 'required|string|max:255',
            'admin_note'            => 'nullable|string|max:500',
        ]);

        $payoutRequest->update([
            'status'                => 'paid',
            'processed_by'          => Auth::id(),
            'processed_at'          => now(),
            'transaction_reference' => $validated['transaction_reference'],
            'admin_note'            => $validated['admin_note'] ?? null,
        ]);

        return back()->with('success',
            'Payout of $' . number_format($payoutRequest->amount, 2) .
            ' marked as paid to ' . $payoutRequest->seller->store_name . '.'
        );
    }

    /**
     * Reject — payout denied with reason.
     */
    public function reject(Request $request, PayoutRequest $payoutRequest)
    {
        if ($payoutRequest->isPaid()) {
            return back()->with('error', 'Cannot reject a payout that has already been paid.');
        }

        $validated = $request->validate([
            'admin_note' => 'required|string|max:500',
        ]);

        $payoutRequest->update([
            'status'       => 'rejected',
            'processed_by' => Auth::id(),
            'processed_at' => now(),
            'admin_note'   => $validated['admin_note'],
        ]);

        return back()->with('success', 'Payout request rejected. Funds remain in seller balance.');
    }
}

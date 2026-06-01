<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\ReturnRequest;
use App\Services\Refund\RefundService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReturnRequestController extends Controller
{
    public function __construct(protected RefundService $refundService) {}

    public function index(Request $request)
    {
        $seller = Auth::user()->seller;
        if (!$seller) abort(403);

        $status = $request->input('status');

        $query = ReturnRequest::where('seller_id', $seller->id)
            ->with(['order', 'customer', 'items']);

        if ($status) {
            $query->where('status', $status);
        }

        $returns = $query->latest()->paginate(15);

        $counts = [
            'pending_seller_review' => ReturnRequest::where('seller_id', $seller->id)->where('status', 'pending_seller_review')->count(),
            'approved'              => ReturnRequest::where('seller_id', $seller->id)->where('status', 'approved')->count(),
            'refunded'              => ReturnRequest::where('seller_id', $seller->id)->where('status', 'refunded')->count(),
            'rejected'              => ReturnRequest::where('seller_id', $seller->id)->where('status', 'rejected')->count(),
        ];

        return view('seller.returns.index', compact('returns', 'counts', 'status'));
    }

    public function show(ReturnRequest $returnRequest)
    {
        $this->authorizeOwnership($returnRequest);
        $returnRequest->load(['order', 'customer', 'items.orderItem.product', 'attachments', 'refund']);
        return view('seller.returns.show', compact('returnRequest'));
    }

    public function approve(Request $request, ReturnRequest $returnRequest)
    {
        $this->authorizeOwnership($returnRequest);

        $validated = $request->validate([
            'seller_response' => 'nullable|string|max:1000',
        ]);

        try {
            $this->refundService->approve($returnRequest, $validated['seller_response'] ?? null);

            // Auto-process refund immediately on approval (no return shipping required for MVP)
            $this->refundService->processRefund($returnRequest);

            return back()->with('success', "Return approved and refund processed for {$returnRequest->reference}.");
        } catch (\Throwable $e) {
            return back()->with('error', 'Approval failed: ' . $e->getMessage());
        }
    }

    public function reject(Request $request, ReturnRequest $returnRequest)
    {
        $this->authorizeOwnership($returnRequest);

        $validated = $request->validate([
            'seller_response' => 'required|string|min:5|max:1000',
        ]);

        try {
            $this->refundService->reject($returnRequest, $validated['seller_response']);
            return back()->with('success', "Return request {$returnRequest->reference} rejected.");
        } catch (\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    protected function authorizeOwnership(ReturnRequest $returnRequest): void
    {
        $seller = Auth::user()->seller;
        if (!$seller || $returnRequest->seller_id !== $seller->id) {
            abort(403);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\ReturnRequest;
use App\Models\VendorOrder;
use App\Services\Refund\RefundService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ReturnRequestController extends Controller
{
    public function __construct(protected RefundService $refundService) {}

    /**
     * Customer's list of all their return requests.
     */
    public function index()
    {
        $returns = ReturnRequest::where('user_id', Auth::id())
            ->with(['order', 'seller', 'items.orderItem.product'])
            ->latest()
            ->paginate(10);

        return view('returns.index', compact('returns'));
    }

    /**
     * Show form to request a return for a specific vendor order.
     */
    public function create(Order $order, VendorOrder $vendorOrder)
    {
        $this->authorizeOrder($order);

        if ($vendorOrder->order_id !== $order->id) {
            abort(404);
        }

        // Check eligibility
        if (!$this->isEligibleForReturn($order)) {
            return redirect()->route('orders.show', $order->order_number)
                ->with('error', 'This order is not eligible for return. Returns must be requested within 7 days of delivery.');
        }

        // Check if a return already exists
        $existing = ReturnRequest::where('vendor_order_id', $vendorOrder->id)
            ->whereNotIn('status', ['rejected', 'cancelled'])
            ->first();

        if ($existing) {
            return redirect()->route('returns.show', $existing)
                ->with('info', 'A return request already exists for this order.');
        }

        $items = $order->orderItems()
            ->where('seller_id', $vendorOrder->seller_id)
            ->with('product')
            ->get();

        return view('returns.create', compact('order', 'vendorOrder', 'items'));
    }

    /**
     * Submit return request.
     */
    public function store(Request $request, Order $order, VendorOrder $vendorOrder)
    {
        $this->authorizeOrder($order);

        if ($vendorOrder->order_id !== $order->id) {
            abort(404);
        }

        $validated = $request->validate([
            'reason_code'        => ['required', Rule::in(array_keys(ReturnRequest::REASON_LABELS))],
            'reason_description' => 'nullable|string|max:2000',
            'refund_method'      => ['required', Rule::in(['original_payment', 'store_credit'])],
            'items'              => 'required|array|min:1',
            'items.*.order_item_id' => 'required|exists:order_items,id',
            'items.*.quantity'      => 'required|integer|min:1',
            'attachments.*'      => 'nullable|image|max:5120',
        ]);

        if (!$this->isEligibleForReturn($order)) {
            return back()->with('error', 'Order is no longer eligible for return.');
        }

        // Filter items where quantity > 0
        $itemPayload = collect($validated['items'])
            ->filter(fn($i) => ($i['quantity'] ?? 0) > 0)
            ->values()
            ->all();

        if (empty($itemPayload)) {
            return back()->with('error', 'Please select at least one item to return.');
        }

        $returnRequest = $this->refundService->createReturnRequest(
            $order,
            $vendorOrder,
            $itemPayload,
            $validated['reason_code'],
            $validated['reason_description'] ?? null,
            $validated['refund_method']
        );

        // Save attachments
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('return-attachments/' . $returnRequest->id, 'public');
                $returnRequest->attachments()->create([
                    'path'          => $path,
                    'original_name' => $file->getClientOriginalName(),
                    'type'          => 'photo',
                ]);
            }
        }

        return redirect()->route('returns.show', $returnRequest)
            ->with('success', "Return request {$returnRequest->reference} submitted. The seller will review it shortly.");
    }

    /**
     * View a return request.
     */
    public function show(ReturnRequest $returnRequest)
    {
        if ($returnRequest->user_id !== Auth::id()) {
            abort(403);
        }

        $returnRequest->load(['order', 'seller', 'items.orderItem.product', 'attachments', 'refund']);

        return view('returns.show', compact('returnRequest'));
    }

    /**
     * Customer cancels their own return request.
     */
    public function cancel(ReturnRequest $returnRequest)
    {
        if ($returnRequest->user_id !== Auth::id()) {
            abort(403);
        }

        try {
            $this->refundService->cancelByCustomer($returnRequest);
            return back()->with('success', 'Return request cancelled.');
        } catch (\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    // ── Helpers ──────────────────────────────────────────────────────────────

    protected function authorizeOrder(Order $order): void
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }
    }

    /**
     * Order is eligible for return if:
     *   - Delivered or completed
     *   - Within 7 days of delivery
     */
    protected function isEligibleForReturn(Order $order): bool
    {
        if (!in_array($order->status, ['delivered', 'completed'])) {
            return false;
        }

        $deliveredAt = $order->delivered_at ?? $order->updated_at;
        return $deliveredAt && $deliveredAt->diffInDays(now()) <= 7;
    }
}

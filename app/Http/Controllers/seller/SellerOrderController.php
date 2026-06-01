<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\VendorOrder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SellerOrderController extends Controller
{
    public function index(Request $request)
    {
        $seller = Auth::user()->seller;

        if (!$seller) {
            return redirect()->route('home')->with('error', 'Seller profile not found.');
        }

        $search = $request->input('search');

        $orders = VendorOrder::where('seller_id', $seller->id)
            ->with(['order.customer'])  
            ->when($search, function($query) use ($search) {
                $query->whereHas('order', function($q) use ($search) {
                    $q->where('order_number', 'like', "%{$search}%")
                      ->orWhere('customer_name', 'like', "%{$search}%")
                      ->orWhere('customer_email', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10);

        return view('seller.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $seller = Auth::user()->seller;

        $vendorOrder = VendorOrder::where('id', $id)
            ->where('seller_id', $seller->id)
            ->with(['order.customer']) 
            ->firstOrFail();

        $items = DB::table('order_items')
            ->leftJoin('products', 'order_items.product_id', '=', 'products.id')
            ->where('order_items.order_id', $vendorOrder->order_id)
            ->where('order_items.seller_id', $seller->id)
            ->select('order_items.*', 'products.image as fallback_image')
            ->get();

        $vendorOrder->setRelation('items', $items);

        return view('seller.orders.show', compact('vendorOrder'));
    }

    public function confirm(VendorOrder $vendorOrder)
    {
        $seller = Auth::user()->seller;
        if (!$seller || $vendorOrder->seller_id !== $seller->id) {
            abort(403, 'Unauthorized action.');
        }

        $allowedStatuses = ['pending', 'processing'];
        
        if (!in_array($vendorOrder->status, $allowedStatuses)) {
            return back()->with('error', 'This order is already confirmed or completed.');
        }

        // 1. Update this vendor order
        $vendorOrder->update(['status' => 'confirmed']);

        // 2. Only update parent order when ALL vendor orders for this order are confirmed
        $parentOrder     = $vendorOrder->order;
        $totalVendors    = VendorOrder::where('order_id', $vendorOrder->order_id)->count();
        $confirmedVendors = VendorOrder::where('order_id', $vendorOrder->order_id)
            ->where('status', 'confirmed')
            ->count();

        if ($parentOrder && $confirmedVendors >= $totalVendors) {
            $parentOrder->update(['status' => 'confirmed']);
        }

        return back()->with('success', "Order #{$parentOrder->order_number} confirmed. Prepare for shipping!");
    }

    /**
     * Final step: Order is marked as completed.
     * This is the status your Dashboard/Earnings queries should filter for.
     */
    public function complete(VendorOrder $vendorOrder)
    {
        $seller = Auth::user()->seller;
        if (!$seller || $vendorOrder->seller_id !== $seller->id) {
            abort(403, 'Unauthorized action.');
        }

        // Only a 'confirmed' (shipped) order can be marked as 'completed'
        if ($vendorOrder->status !== 'confirmed') {
            return back()->with('error', 'Only confirmed orders can be marked as completed.');
        }

        $vendorOrder->update([
            'status' => 'completed'
        ]);

        return back()->with('success', "Order marked as completed. Funds are now available in your balance.");
    }
}
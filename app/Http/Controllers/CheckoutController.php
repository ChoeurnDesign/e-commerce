<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Seller;
use App\Models\VendorOrder;
use App\Models\Wallet;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class CheckoutController extends Controller
{
    protected CartService $cartService;

    public function __construct(CartService $cartService)
    {
        // Your existing CartService handles the session-based cart
        $this->cartService = $cartService;
    }

    /**
     * Show the checkout form
     */
    public function index()
    {
        if (!$this->cartService->hasItems()) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty. Please add some items before checkout.');
        }

        $hasChanges = $this->cartService->validateCart();
        if ($hasChanges) {
            return redirect()->route('cart.index')
                ->with('warning', 'Some items in your cart have been updated. Please review your cart before proceeding.');
        }

        $cartItems = $this->cartService->getCartItems();
        $cartTotals = $this->cartService->getCartTotals();
        $user = Auth::user();
        $orderTotal = $cartTotals['total'];

        return view('checkout.index', compact('cartItems', 'cartTotals', 'user', 'orderTotal'));
    }

    /**
     * Process the order (unified Place Order button)
     */
    public function placeOrder(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'nullable|string|max:20',

            'shipping_address' => 'required|string|max:500',
            'shipping_city' => 'required|string|max:100',
            'shipping_state' => 'required|string|max:100',
            'shipping_postal_code' => 'required|string|max:20',
            'shipping_country' => 'required|string|max:100',

            'billing_same_as_shipping' => 'boolean',
            'billing_address' => 'required_if:billing_same_as_shipping,false|nullable|string|max:500',
            'billing_city' => 'required_if:billing_same_as_shipping,false|nullable|string|max:100',
            'billing_state' => 'required_if:billing_same_as_shipping,false|nullable|string|max:100',
            'billing_postal_code' => 'required_if:billing_same_as_shipping,false|nullable|string|max:20',
            'billing_country' => 'required_if:billing_same_as_shipping,false|nullable|string|max:100',

            'payment_method' => ['required', Rule::in(['credit_card', 'paypal', 'cash_on_delivery'])],
            'notes' => 'nullable|string|max:1000',
        ]);

        if (!$this->cartService->hasItems()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        try {
            DB::beginTransaction();

            $cartItems = $this->cartService->getCartItems();
            $cartTotals = $this->cartService->getCartTotals();

            // Sync billing address if checkbox is checked
            if ($request->boolean('billing_same_as_shipping')) {
                $validated['billing_address'] = $validated['shipping_address'];
                $validated['billing_city'] = $validated['shipping_city'];
                $validated['billing_state'] = $validated['shipping_state'];
                $validated['billing_postal_code'] = $validated['shipping_postal_code'];
                $validated['billing_country'] = $validated['shipping_country'];
            }

            // 1. Create Main Order
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_number' => $this->generateOrderNumber(),
                'subtotal' => $cartTotals['subtotal'],
                'tax_amount' => $cartTotals['tax'],
                'total_price' => $cartTotals['total'],
                'status' => 'pending', 
                'payment_status' => 'pending',
                'payment_method' => $validated['payment_method'],
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
                'customer_phone' => $validated['customer_phone'],
                'shipping_address' => $validated['shipping_address'],
                'shipping_city' => $validated['shipping_city'],
                'shipping_state' => $validated['shipping_state'],
                'shipping_postal_code' => $validated['shipping_postal_code'],
                'shipping_country' => $validated['shipping_country'],
                'billing_address' => $validated['billing_address'] ?? null,
                'billing_city' => $validated['billing_city'] ?? null,
                'billing_state' => $validated['billing_state'] ?? null,
                'billing_postal_code' => $validated['billing_postal_code'] ?? null,
                'billing_country' => $validated['billing_country'] ?? null,
                'notes' => $validated['notes'] ?? null,
            ]);

            // 2. Create individual items and link to sellers
            $this->createOrderItemsAndDecreaseStock($order, $cartItems);

            // 3. Create Vendor Orders (Splitting the payment logically)
            $this->createVendorOrdersFromItems($order);

            // 4. Handle Payment Gateway Logic
            $paymentResult = $this->processPayment($order, $validated['payment_method']);

            if ($paymentResult['success']) {
                $isCOD = ($validated['payment_method'] === 'cash_on_delivery');

                // FIX: Set to 'processing' so it doesn't auto-confirm
                $paymentStatus = $isCOD ? 'pending' : 'paid';
                $orderStatus = $isCOD ? 'pending' : 'processing'; 

                $order->update([
                    'payment_status' => $paymentStatus,
                    'status' => $orderStatus,
                    'payment_id' => $paymentResult['payment_id'],
                ]);

                // Update wallets ONLY for paid orders
                if ($paymentStatus === 'paid') {
                    foreach ($order->vendorOrders as $vendorOrder) {
                        // 1. UPDATE VENDOR ORDER STATUS
                        // This ensures the Seller Dashboard shows 'Processing' instead of 'Pending'
                        $vendorOrder->update(['status' => 'processing']);

                        // 2. UPDATE WALLET
                        $wallet = \App\Models\Wallet::firstOrCreate(
                            ['seller_id' => $vendorOrder->seller_id], 
                            ['balance' => 0]
                        );
                        $wallet->increment('balance', $vendorOrder->seller_earnings);
                    }
                }

                $this->cartService->clearCart();
                DB::commit();

                return redirect()->route('checkout.confirmation', $order->order_number)
                    ->with('success', 'Order placed successfully!');
            }

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Checkout Error: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to place order: ' . $e->getMessage());
        }
    }

    /**
     * Splits order items by seller and calculates commissions
     */
    private function createVendorOrdersFromItems(Order $order): void
    {
        $itemsBySeller = OrderItem::where('order_id', $order->id)
            ->get()
            ->groupBy('seller_id');

        foreach ($itemsBySeller as $sellerId => $items) {
            // Fetch seller for specific commission rate (default 10%)
            $seller = Seller::find($sellerId);

            //User custom rate or default 10%
            $commissionRate = $seller->commission_rate ?? 10.00;

            $subtotal = round($items->sum('total'), 2);
            $commissionAmount = round($subtotal * ($commissionRate / 100), 2);
            $sellerEarnings = round($subtotal - $commissionAmount, 2);

            VendorOrder::create([
                'order_id' => $order->id,
                'seller_id' => $sellerId,
                'subtotal' => $subtotal,
                'commission_rate' => $commissionRate,
                'commission_amount' => $commissionAmount,
                'seller_earnings' => $sellerEarnings,
                'status' => 'pending',
                'payout_status' => 'pending',
                'stripe_account_id' => $seller->stripe_account_id ?? null,
            ]);
        }
    }

    /**
 * Logic for processing multi-vendor payments
 */
private function processPayment(Order $order, string $paymentMethod): array
{
    switch ($paymentMethod) {
        case 'credit_card':
            try {
                // Set the API key from your .env
                \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

                // Convert total to cents for Stripe
                $amountInCents = (int) ($order->total_price * 100);

                // Create the PaymentIntent
                $paymentIntent = \Stripe\PaymentIntent::create([
                    'amount' => $amountInCents,
                    'currency' => 'usd',
                    'payment_method_types' => ['card'],
                    'description' => 'Order #' . $order->order_number,
                    'metadata' => [
                        'order_id' => $order->id,
                        'customer_name' => $order->customer_name, // Useful for Stripe dashboard
                    ],
                    // "transfer_group" links this payment to the vendor transfers we'll do later
                    'transfer_group' => 'ORDER_' . $order->id,
                ]);

                return [
                    'success' => true, 
                    'payment_id' => $paymentIntent->id,
                    'client_secret' => $paymentIntent->client_secret, // Needed for your frontend JS
                    'message' => 'Intent Created'
                ];

            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Stripe Error: ' . $e->getMessage());
                return [
                    'success' => false,
                    'message' => 'Payment failed: ' . $e->getMessage()
                ];
            }

        case 'cash_on_delivery':
            return [
                'success' => true,
                'payment_id' => 'COD_' . strtoupper(\Illuminate\Support\Str::random(10)),
                'message' => 'Success'
            ];

        default:
            return ['success' => false, 'message' => 'Unsupported payment method'];
    }
}

    private function createOrderItemsAndDecreaseStock(Order $order, array $cartItems): void
    {
        foreach ($cartItems as $item) {
            $product = Product::findOrFail($item['id']);

            if (!$product->is_active || $product->stock_quantity < (int) $item['quantity']) {
                throw new \Exception("Product '{$product->name}' is unavailable or out of stock.");
            }

            OrderItem::create([
                'order_id' => $order->id,
                'seller_id' => $product->seller_id,
                'product_id' => $product->id,
                'product_name' => $product->name,
                'product_sku' => $product->sku,
                'quantity' => (int) $item['quantity'],
                'price' => (float) $item['price'],
                'total' => (float) $item['subtotal'],
            ]);

            $product->decrement('stock_quantity', (int) $item['quantity']);
        }
    }

    private function generateOrderNumber(): string
    {
        do {
            $orderNumber = 'ORD-' . date('Ymd') . '-' . strtoupper(Str::random(6));
        } while (Order::where('order_number', $orderNumber)->exists());

        return $orderNumber;
    }

    public function confirmation($orderNumber)
    {
        $order = Order::with('orderItems.product')
            ->where('order_number', $orderNumber)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('checkout.confirmation', compact('order'));
    }
}
<?php

namespace App\Http\Controllers;

use App\Mail\OrderConfirmation;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Seller;
use App\Models\VendorOrder;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CheckoutController extends Controller
{
    public function __construct(protected CartService $cartService) {}

    public function index()
    {
        if (!$this->cartService->hasItems()) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty. Please add some items before checkout.');
        }

        $changes = $this->cartService->validateCart();
        if (!empty($changes)) {
            session()->flash('cart_changes', $changes);
            return redirect()->route('cart.index');
        }

        $cartItems  = $this->cartService->getCartItems();
        $cartTotals = $this->cartService->getCartTotals();
        $user       = Auth::user();
        $orderTotal = $cartTotals['total'];

        return view('checkout.index', compact('cartItems', 'cartTotals', 'user', 'orderTotal'));
    }

    /**
     * Apply a coupon code (AJAX).
     */
    public function applyCoupon(Request $request)
    {
        $code   = strtoupper(trim($request->coupon_code ?? ''));
        $coupon = Coupon::where('code', $code)->first();

        $cartTotals = $this->cartService->getCartTotals();

        if (!$coupon || !$coupon->isValid((float) $cartTotals['subtotal'])) {
            return response()->json(['success' => false, 'message' => 'Invalid or expired coupon code.']);
        }

        $discount = $coupon->calculateDiscount((float) $cartTotals['subtotal']);

        session(['checkout_coupon' => [
            'code'     => $coupon->code,
            'type'     => $coupon->discount_type,
            'value'    => (float) $coupon->discount_value,
            'discount' => $discount,
        ]]);

        return response()->json([
            'success'  => true,
            'discount' => $discount,
            'code'     => $coupon->code,
            'message'  => "Coupon applied — you save $" . number_format($discount, 2) . "!",
        ]);
    }

    /**
     * Remove applied coupon (AJAX).
     */
    public function removeCoupon()
    {
        session()->forget('checkout_coupon');
        return response()->json(['success' => true]);
    }

    /**
     * Place the order.
     * Returns JSON for credit_card (Stripe flow), redirect for all other methods.
     */
    public function placeOrder(Request $request)
    {
        $validated = $request->validate([
            'customer_name'            => 'required|string|max:255',
            'customer_email'           => 'required|email|max:255',
            'customer_phone'           => 'nullable|string|max:20',
            'shipping_address'         => 'required|string|max:500',
            'shipping_city'            => 'required|string|max:100',
            'shipping_state'           => 'required|string|max:100',
            'shipping_postal_code'     => 'required|string|max:20',
            'shipping_country'         => 'required|string|max:100',
            'billing_same_as_shipping' => 'boolean',
            'billing_address'          => 'required_if:billing_same_as_shipping,false|nullable|string|max:500',
            'billing_city'             => 'required_if:billing_same_as_shipping,false|nullable|string|max:100',
            'billing_state'            => 'required_if:billing_same_as_shipping,false|nullable|string|max:100',
            'billing_postal_code'      => 'required_if:billing_same_as_shipping,false|nullable|string|max:20',
            'billing_country'          => 'required_if:billing_same_as_shipping,false|nullable|string|max:100',
            'payment_method'           => ['required', Rule::in(['credit_card', 'paypal', 'cash_on_delivery', 'bank_transfer'])],
            'notes'                    => 'nullable|string|max:1000',
            'stripe_payment_method_id' => 'required_if:payment_method,credit_card|nullable|string',
            'payment_proof'            => 'required_if:payment_method,bank_transfer|nullable|image|max:5120',
            'payment_reference'        => 'nullable|string|max:255',
        ]);

        if (!$this->cartService->hasItems()) {
            return $this->errorResponse($request, 'Your cart is empty.');
        }

        try {
            DB::beginTransaction();

            $cartItems  = $this->cartService->getCartItems();
            $cartTotals = $this->cartService->getCartTotals();

            if ($request->boolean('billing_same_as_shipping')) {
                $validated['billing_address']       = $validated['shipping_address'];
                $validated['billing_city']          = $validated['shipping_city'];
                $validated['billing_state']         = $validated['shipping_state'];
                $validated['billing_postal_code']   = $validated['shipping_postal_code'];
                $validated['billing_country']       = $validated['shipping_country'];
            }

            // 1. Create main order
            $order = Order::create([
                'user_id'              => Auth::id(),
                'order_number'         => $this->generateOrderNumber(),
                'subtotal'             => $cartTotals['subtotal'],
                'tax_amount'           => $cartTotals['tax'],
                'discount_amount'      => $cartTotals['discount_amount'],
                'coupon_code'          => $cartTotals['coupon_code'],
                'total_price'          => $cartTotals['total'],
                'status'               => 'pending',
                'payment_status'       => 'pending',
                'payment_method'       => $validated['payment_method'],
                'customer_name'        => $validated['customer_name'],
                'customer_email'       => $validated['customer_email'],
                'customer_phone'       => $validated['customer_phone'] ?? null,
                'shipping_address'     => $validated['shipping_address'],
                'shipping_city'        => $validated['shipping_city'],
                'shipping_state'       => $validated['shipping_state'],
                'shipping_postal_code' => $validated['shipping_postal_code'],
                'shipping_country'     => $validated['shipping_country'],
                'billing_address'      => $validated['billing_address'] ?? null,
                'billing_city'         => $validated['billing_city'] ?? null,
                'billing_state'        => $validated['billing_state'] ?? null,
                'billing_postal_code'  => $validated['billing_postal_code'] ?? null,
                'billing_country'      => $validated['billing_country'] ?? null,
                'notes'                => $validated['notes'] ?? null,
            ]);

            // 2. Create order items (with stock lock)
            $this->createOrderItemsAndDecreaseStock($order, $cartItems);

            // 3. Create vendor orders
            $this->createVendorOrdersFromItems($order);

            // 4. Process payment
            $paymentResult = $this->processPayment($order, $validated['payment_method'], $validated['stripe_payment_method_id'] ?? null);

            if (!$paymentResult['success']) {
                DB::rollBack();
                return $this->errorResponse($request, $paymentResult['message']);
            }

            // Stripe 3DS — order saved but not yet paid
            if (!empty($paymentResult['requires_action'])) {
                $order->update([
                    'payment_id'     => $paymentResult['payment_id'],
                    'payment_status' => 'pending',
                    'status'         => 'pending',
                ]);
                DB::commit();
                return response()->json([
                    'requires_action' => true,
                    'client_secret'   => $paymentResult['client_secret'],
                    'order_number'    => $order->order_number,
                ]);
            }

            // Payment succeeded — branch by method
            $method = $validated['payment_method'];

            if ($method === 'cash_on_delivery') {
                $paymentStatus = 'pending';
                $orderStatus   = 'pending';
            } elseif ($method === 'bank_transfer') {
                // Upload the receipt screenshot. Order waits for admin verification.
                $proofPath = $request->file('payment_proof')
                    ->store('payment-proofs', 'public');

                $order->update([
                    'payment_proof'     => $proofPath,
                    'payment_reference' => $validated['payment_reference'] ?? null,
                ]);

                $paymentStatus = 'awaiting_verification';
                $orderStatus   = 'pending';
            } else {
                // credit_card / paypal already paid via gateway
                $paymentStatus = 'paid';
                $orderStatus   = 'processing';
            }

            $order->update([
                'payment_status' => $paymentStatus,
                'status'         => $orderStatus,
                'payment_id'     => $paymentResult['payment_id'],
            ]);

            // For paid orders, mark vendor orders as processing + credit platform wallet
            if ($paymentStatus === 'paid') {
                VendorOrder::where('order_id', $order->id)->update(['status' => 'processing']);

                // Calculate payment gateway fee (Stripe/PayPal)
                $commissionService = app(\App\Services\Commission\CommissionService::class);
                $paymentFee = $commissionService->calculatePaymentFee($method, (float) $order->total_price);
                $order->update(['payment_fee_amount' => $paymentFee]);

                // Money enters the platform wallet
                $platformWallet = \App\Models\PlatformWallet::getInstance();
                $platformWallet->receiveOrderPayment($order, (float) $order->total_price);

                // Record payment fee (deducted from platform commission)
                if ($paymentFee > 0) {
                    $platformWallet->recordPaymentFee($order, $paymentFee);
                }
            }

            // Consume coupon
            $this->consumeCoupon($cartTotals['coupon_code']);
            session()->forget('checkout_coupon');

            $this->cartService->clearCart();
            DB::commit();

            // Send confirmation email
            try {
                $order->load('orderItems');
                Mail::to($order->customer_email)->send(new OrderConfirmation($order));
            } catch (\Exception $e) {
                Log::error('Order confirmation email failed: ' . $e->getMessage());
            }

            if ($request->wantsJson()) {
                return response()->json([
                    'success'  => true,
                    'redirect' => route('checkout.confirmation', $order->order_number),
                ]);
            }

            return redirect()->route('checkout.confirmation', $order->order_number)
                ->with('success', 'Order placed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Checkout Error: ' . $e->getMessage());
            return $this->errorResponse($request, 'Failed to place order: ' . $e->getMessage());
        }
    }

    /**
     * Confirm Stripe payment after 3DS (AJAX).
     */
    public function confirmStripePayment(Request $request)
    {
        $request->validate([
            'payment_intent_id' => 'required|string',
            'order_number'      => 'required|string',
        ]);

        $order = Order::where('order_number', $request->order_number)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        try {
            \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
            $intent = \Stripe\PaymentIntent::retrieve($request->payment_intent_id);

            if ($intent->status !== 'succeeded') {
                return response()->json(['success' => false, 'message' => 'Payment was not completed.']);
            }

            $order->update([
                'payment_status' => 'paid',
                'status'         => 'processing',
                'payment_id'     => $intent->id,
            ]);

            VendorOrder::where('order_id', $order->id)->update(['status' => 'processing']);

            // Consume coupon if not yet done
            if ($order->coupon_code) {
                $this->consumeCoupon($order->coupon_code);
                session()->forget('checkout_coupon');
            }

            try {
                $order->load('orderItems');
                Mail::to($order->customer_email)->send(new OrderConfirmation($order));
            } catch (\Exception $e) {
                Log::error('Order confirmation email failed: ' . $e->getMessage());
            }

            return response()->json([
                'success'  => true,
                'redirect' => route('checkout.confirmation', $order->order_number),
            ]);

        } catch (\Exception $e) {
            Log::error('Stripe 3DS confirm failed: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Payment confirmation failed.']);
        }
    }

    /**
     * PayPal order capture — called after buyer approves on PayPal JS SDK.
     * Frontend submits regular form with paypal_order_id hidden input.
     */
    public function paypalCapture(Request $request)
    {
        $request->validate(['paypal_order_id' => 'required|string']);

        $orderId = $request->paypal_order_id;

        try {
            $accessToken = $this->getPayPalAccessToken();

            $mode    = config('services.paypal.mode', 'sandbox');
            $baseUrl = $mode === 'live' ? 'https://api-m.paypal.com' : 'https://api-m.sandbox.paypal.com';

            $response = \Illuminate\Support\Facades\Http::withToken($accessToken)
                ->post("{$baseUrl}/v2/checkout/orders/{$orderId}/capture");

            $body = $response->json();

            if ($response->successful() && ($body['status'] ?? '') === 'COMPLETED') {
                return response()->json([
                    'success'    => true,
                    'payment_id' => $orderId,
                    'message'    => 'PayPal payment captured.',
                ]);
            }

            return response()->json(['success' => false, 'message' => 'PayPal capture failed.'], 422);

        } catch (\Exception $e) {
            Log::error('PayPal capture error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'PayPal error.'], 500);
        }
    }

    public function confirmation($orderNumber)
    {
        $order = Order::with('orderItems.product')
            ->where('order_number', $orderNumber)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('checkout.confirmation', compact('order'));
    }

    // -------------------------------------------------------------------------
    // Private helpers
    // -------------------------------------------------------------------------

    private function processPayment(Order $order, string $paymentMethod, ?string $stripePaymentMethodId = null): array
    {
        switch ($paymentMethod) {
            case 'credit_card':
                try {
                    \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

                    $amountInCents = (int) round($order->total_price * 100);

                    $intent = \Stripe\PaymentIntent::create([
                        'amount'               => $amountInCents,
                        'currency'             => strtolower(config('app.currency', 'usd')),
                        'payment_method'       => $stripePaymentMethodId,
                        'confirm'              => true,
                        'return_url'           => route('checkout.confirmation', $order->order_number),
                        'payment_method_types' => ['card'],
                        'description'          => 'Order #' . $order->order_number,
                        'metadata'             => [
                            'order_id'      => $order->id,
                            'order_number'  => $order->order_number,
                        ],
                        'transfer_group' => 'ORDER_' . $order->id,
                    ]);

                    if ($intent->status === 'requires_action') {
                        return [
                            'success'         => true,
                            'requires_action' => true,
                            'client_secret'   => $intent->client_secret,
                            'payment_id'      => $intent->id,
                        ];
                    }

                    if ($intent->status === 'succeeded') {
                        return ['success' => true, 'payment_id' => $intent->id];
                    }

                    return ['success' => false, 'message' => 'Payment could not be completed. Please try again.'];

                } catch (\Stripe\Exception\CardException $e) {
                    return ['success' => false, 'message' => $e->getError()->message ?? 'Card declined.'];
                } catch (\Exception $e) {
                    Log::error('Stripe Error: ' . $e->getMessage());
                    return ['success' => false, 'message' => 'Payment processing error. Please try again.'];
                }

            case 'paypal':
                // PayPal is handled via JS SDK + paypalCapture endpoint.
                // When the form reaches here it means the buyer already approved,
                // so we accept it optimistically and treat as paid.
                return [
                    'success'    => true,
                    'payment_id' => 'PP_' . strtoupper(Str::random(10)),
                ];

            case 'cash_on_delivery':
                return [
                    'success'    => true,
                    'payment_id' => 'COD_' . strtoupper(Str::random(10)),
                ];

            case 'bank_transfer':
                /* Bank transfer is verified later by admin — order proceeds
                   immediately so the receipt upload + order record are saved.
                   Status flow: awaiting_verification → paid (after admin approves). */
                return [
                    'success'    => true,
                    'payment_id' => 'BT_' . strtoupper(Str::random(10)),
                ];

            default:
                return ['success' => false, 'message' => 'Unsupported payment method.'];
        }
    }

    private function createOrderItemsAndDecreaseStock(Order $order, array $cartItems): void
    {
        foreach ($cartItems as $item) {
            // Lock row to prevent race conditions on concurrent checkout
            $product = Product::lockForUpdate()->findOrFail($item['id']);

            if (!$product->is_active || $product->stock_quantity < (int) $item['quantity']) {
                throw new \Exception("Product '{$product->name}' is unavailable or out of stock.");
            }

            OrderItem::create([
                'order_id'    => $order->id,
                'seller_id'   => $product->seller_id,
                'product_id'  => $product->id,
                'product_name'=> $product->name,
                'product_sku' => $product->sku,
                'quantity'    => (int) $item['quantity'],
                'price'       => (float) $item['price'],
                'total'       => (float) $item['subtotal'],
            ]);

            $product->decrement('stock_quantity', (int) $item['quantity']);
        }
    }

    private function createVendorOrdersFromItems(Order $order): void
    {
        $commissionService = app(\App\Services\Commission\CommissionService::class);

        // Load items with product + product.category + product.seller
        $itemsBySeller = OrderItem::where('order_id', $order->id)
            ->with(['product.category', 'product.seller'])
            ->get()
            ->groupBy('seller_id');

        // Compute order-level totals for discount allocation
        $orderTotal    = (float) $order->subtotal;
        $totalDiscount = (float) ($order->discount_amount ?? 0);
        $coupon        = $order->coupon_code ? Coupon::where('code', $order->coupon_code)->first() : null;

        foreach ($itemsBySeller as $sellerId => $items) {
            $financials = $commissionService->computeVendorFinancials(
                $items,
                $coupon,
                $orderTotal,
                $totalDiscount
            );

            $seller = Seller::find($sellerId);

            VendorOrder::create([
                'order_id'            => $order->id,
                'seller_id'           => $sellerId,
                'subtotal'            => $financials['subtotal'],
                'discount_allocated'  => $financials['discount_allocated'],
                'commission_rate'     => $financials['commission_rate'],
                'commission_source'   => $financials['commission_source'],
                'commission_amount'   => $financials['commission_amount'],
                'seller_earnings'     => $financials['seller_earnings'],
                'status'              => 'pending',
                'payout_status'       => 'pending',
                'stripe_account_id'   => $seller->stripe_account_id ?? null,
            ]);
        }
    }

    private function consumeCoupon(?string $code): void
    {
        if (!$code) return;
        Coupon::where('code', $code)->increment('used_count');
    }

    private function getPayPalAccessToken(): string
    {
        $mode     = config('services.paypal.mode', 'sandbox');
        $baseUrl  = $mode === 'live' ? 'https://api-m.paypal.com' : 'https://api-m.sandbox.paypal.com';
        $response = Http::withBasicAuth(config('services.paypal.client_id'), config('services.paypal.secret'))
            ->asForm()
            ->post("{$baseUrl}/v1/oauth2/token", ['grant_type' => 'client_credentials']);

        return $response->json('access_token');
    }

    private function generateOrderNumber(): string
    {
        do {
            $number = 'ORD-' . date('Ymd') . '-' . strtoupper(Str::random(6));
        } while (Order::where('order_number', $number)->exists());

        return $number;
    }

    private function errorResponse(Request $request, string $message)
    {
        if ($request->wantsJson()) {
            return response()->json(['success' => false, 'message' => $message], 422);
        }
        return redirect()->back()->withInput()->with('error', $message);
    }
}

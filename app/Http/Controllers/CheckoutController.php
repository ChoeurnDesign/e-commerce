<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CheckoutController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * Show the checkout form
     */
    public function index()
    {
        if (!$this->cartService->hasItems()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty. Please add some items before checkout.');
        }

        $hasChanges = $this->cartService->validateCart();
        if ($hasChanges) {
            return redirect()->route('cart.index')->with('warning', 'Some items in your cart have been updated. Please review your cart before proceeding to checkout.');
        }

        $cartItems = $this->cartService->getCartItems();
        $cartTotals = $this->cartService->getCartTotals();
        $user = Auth::user();
        $orderTotal = $cartTotals['total'];

        return view('checkout.index', compact('cartItems', 'cartTotals', 'user', 'orderTotal'));
    }

    /**
     * Process the order for all payments (unified Place Order button)
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
            'notes' => 'nullable|string|max:1000'
        ]);

        if (!$this->cartService->hasItems()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        // Unified flow: Only allow PayPal via PayPal button with order_id
        if ($validated['payment_method'] === 'paypal') {
            if (!$request->filled('paypal_order_id')) {
                return redirect()->back()->with('paypal_error', 'Please use the PayPal button to complete PayPal payments.');
            }
            // Optional: verify the PayPal order here for extra safety!
        }

        try {
            DB::beginTransaction();

            $cartItems = $this->cartService->getCartItems();
            $cartTotals = $this->cartService->getCartTotals();

            foreach ($cartItems as $item) {
                $product = Product::find($item['id']);
                if (!$product || !$product->is_active) {
                    throw new \Exception("Product '{$item['name']}' is no longer available.");
                }
                if ($product->stock_quantity < $item['quantity']) {
                    throw new \Exception("Insufficient stock for '{$item['name']}'. Only {$product->stock_quantity} available.");
                }
            }

            if ($request->billing_same_as_shipping) {
                $validated['billing_address'] = $validated['shipping_address'];
                $validated['billing_city'] = $validated['shipping_city'];
                $validated['billing_state'] = $validated['shipping_state'];
                $validated['billing_postal_code'] = $validated['shipping_postal_code'];
                $validated['billing_country'] = $validated['shipping_country'];
            }

            $order = Order::create([
                'user_id' => Auth::id(),
                'order_number' => $this->generateOrderNumber(),
                'subtotal' => $cartTotals['subtotal'],
                'tax_amount' => $cartTotals['tax'],
                'total_price' => $cartTotals['total'],
                'status' => ($validated['payment_method'] === 'paypal') ? 'confirmed' : 'pending',
                'payment_status' => ($validated['payment_method'] === 'paypal') ? 'paid' : 'pending',
                'payment_method' => $validated['payment_method'],
                'payment_id' => $request->input('paypal_order_id', null),
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
                'customer_phone' => $validated['customer_phone'],
                'shipping_address' => $validated['shipping_address'],
                'shipping_city' => $validated['shipping_city'],
                'shipping_state' => $validated['shipping_state'],
                'shipping_postal_code' => $validated['shipping_postal_code'],
                'shipping_country' => $validated['shipping_country'],
                'billing_address' => $validated['billing_address'],
                'billing_city' => $validated['billing_city'],
                'billing_state' => $validated['billing_state'],
                'billing_postal_code' => $validated['billing_postal_code'],
                'billing_country' => $validated['billing_country'],
                'notes' => $validated['notes'] ?? null
            ]);

            foreach ($cartItems as $item) {
                $product = Product::find($item['id']);
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'product_sku' => $product->sku,
                    'product_image' => $product->image,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'total' => $item['subtotal']
                ]);
                $product->decrement('stock_quantity', $item['quantity']);
            }

            // Credit card and COD: process payment simulation
            if (in_array($validated['payment_method'], ['credit_card', 'cash_on_delivery'])) {
                $paymentResult = $this->processPayment($order, $validated['payment_method']);
                if ($paymentResult['success']) {
                    $order->update([
                        'payment_status' => 'paid',
                        'status' => 'confirmed',
                        'payment_id' => $paymentResult['payment_id']
                    ]);
                }
            }

            $this->cartService->clearCart();
            DB::commit();

            return redirect()->route('checkout.confirmation', $order->order_number)
                ->with('success', 'Your order has been placed successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to place order: ' . $e->getMessage());
        }
    }

    /**
     * PayPal capture (called by PayPal JS)
     */
    public function paypalCapture(Request $request)
    {
        $orderID = $request->input('orderID');
        $clientId = config('services.paypal.client_id');
        $secret = config('services.paypal.secret');

        // Get Access Token
        $tokenResponse = Http::withBasicAuth($clientId, $secret)
            ->asForm()
            ->post('https://api-m.sandbox.paypal.com/v1/oauth2/token', [
                'grant_type' => 'client_credentials'
            ]);

        if (!$tokenResponse->successful()) {
            Log::error('PayPal Token Error: ' . $tokenResponse->body());
            return response()->json(['success' => false, 'message' => 'PayPal token error'], 500);
        }
        $accessToken = $tokenResponse->json()['access_token'];

        // Capture Payment
        $captureResponse = Http::withToken($accessToken)
            ->post("https://api-m.sandbox.paypal.com/v2/checkout/orders/{$orderID}/capture");

        // Check Capture Status
        if (!($captureResponse->successful() && isset($captureResponse['status']) && $captureResponse['status'] === 'COMPLETED')) {
            // ADDED: Log the full error response from PayPal
            Log::error('PayPal Capture Error: ' . $captureResponse->body());
            return response()->json(['success' => false, 'message' => 'PayPal payment not completed'], 400);
        }

        // Existing code to create order, save to database, etc.
        // ... (rest of your method)
        try {
            DB::beginTransaction();
            $cartItems = $this->cartService->getCartItems();
            $cartTotals = $this->cartService->getCartTotals();
            $user = Auth::user();
            $order = Order::create([
                'user_id' => $user ? $user->id : null,
                'order_number' => $this->generateOrderNumber(),
                'subtotal' => $cartTotals['subtotal'],
                'tax_amount' => $cartTotals['tax'],
                'total_price' => $cartTotals['total'],
                'status' => 'confirmed',
                'payment_status' => 'paid',
                'payment_method' => 'paypal',
                'payment_id' => $orderID,
                'customer_name' => $user ? $user->name : 'PayPal Guest',
                'customer_email' => $user ? $user->email : null,
                'customer_phone' => null,
                'shipping_address' => null,
                'shipping_city' => null,
                'shipping_state' => null,
                'shipping_postal_code' => null,
                'shipping_country' => null,
                'billing_address' => null,
                'billing_city' => null,
                'billing_state' => null,
                'billing_postal_code' => null,
                'billing_country' => null,
                'notes' => null
            ]);
            foreach ($cartItems as $item) {
                $product = Product::find($item['id']);
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'product_sku' => $product->sku,
                    'product_image' => $product->image,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'total' => $item['subtotal']
                ]);
                $product->decrement('stock_quantity', $item['quantity']);
            }
            $this->cartService->clearCart();
            DB::commit();
            return response()->json([
                'success' => true,
                'orderNumber' => $order->order_number
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Show order confirmation
     */
    public function confirmation($orderNumber)
    {
        $order = Order::with('orderItems.product')
            ->where('order_number', $orderNumber)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('checkout.confirmation', compact('order'));
    }

    private function generateOrderNumber()
    {
        do {
            $orderNumber = 'ORD-' . date('Y') . '-' . strtoupper(Str::random(8));
        } while (Order::where('order_number', $orderNumber)->exists());
        return $orderNumber;
    }

    private function processPayment($order, $paymentMethod)
    {
        switch ($paymentMethod) {
            case 'credit_card':
                $success = rand(1, 10) > 1;
                break;
            case 'cash_on_delivery':
                $success = true;
                break;
            default:
                $success = false;
        }
        return [
            'success' => $success,
            'payment_id' => $success ? 'PAY_' . strtoupper(Str::random(10)) : null,
            'message' => $success ? 'Payment processed successfully' : 'Payment failed'
        ];
    }
}

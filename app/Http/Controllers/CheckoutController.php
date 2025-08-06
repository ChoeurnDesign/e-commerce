<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
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
        // Check if cart has items
        if (!$this->cartService->hasItems()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty. Please add some items before checkout.');
        }

        // Validate cart items before checkout
        $hasChanges = $this->cartService->validateCart();
        if ($hasChanges) {
            return redirect()->route('cart.index')->with('warning', 'Some items in your cart have been updated. Please review your cart before proceeding to checkout.');
        }

        $cartItems = $this->cartService->getCartItems();
        $cartTotals = $this->cartService->getCartTotals();
        $user = Auth::user();
        $orderTotal = $cartTotals['total']; // <-- Add this line

        return view('checkout.index', compact('cartItems', 'cartTotals', 'user', 'orderTotal')); // <-- Add orderTotal here
    }

    /**
     * Process the order
     */
    public function placeOrder(Request $request)
    {
        // Validate input
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

        // Check if cart has items
        if (!$this->cartService->hasItems()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        try {
            DB::beginTransaction();

            // Get cart data
            $cartItems = $this->cartService->getCartItems();
            $cartTotals = $this->cartService->getCartTotals();

            // Validate stock availability
            foreach ($cartItems as $item) {
                $product = Product::find($item['id']);
                if (!$product || !$product->is_active) {
                    throw new \Exception("Product '{$item['name']}' is no longer available.");
                }
                if ($product->stock_quantity < $item['quantity']) {
                    throw new \Exception("Insufficient stock for '{$item['name']}'. Only {$product->stock_quantity} available.");
                }
            }

            // Handle billing address
            if ($request->billing_same_as_shipping) {
                $validated['billing_address'] = $validated['shipping_address'];
                $validated['billing_city'] = $validated['shipping_city'];
                $validated['billing_state'] = $validated['shipping_state'];
                $validated['billing_postal_code'] = $validated['shipping_postal_code'];
                $validated['billing_country'] = $validated['shipping_country'];
            }

            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_number' => $this->generateOrderNumber(), // 👈 ADD ORDER NUMBER GENERATION
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
                'billing_address' => $validated['billing_address'],
                'billing_city' => $validated['billing_city'],
                'billing_state' => $validated['billing_state'],
                'billing_postal_code' => $validated['billing_postal_code'],
                'billing_country' => $validated['billing_country'],
                'notes' => $validated['notes'] ?? null
            ]);

            // Create order items and update stock
            foreach ($cartItems as $item) {
                $product = Product::find($item['id']);

                // Create order item
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

                // Update product stock
                $product->decrement('stock_quantity', $item['quantity']);
            }

            // Process payment (mock for now)
            $paymentResult = $this->processPayment($order, $validated['payment_method']);

            if ($paymentResult['success']) {
                $order->update([
                    'payment_status' => 'paid',
                    'status' => 'confirmed',
                    'payment_id' => $paymentResult['payment_id']
                ]);
            }

            // Clear cart
            $this->cartService->clearCart();

            DB::commit();

            // Send confirmation email (optional - implement later)
            // $this->sendOrderConfirmationEmail($order);

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

    /**
     * Generate unique order number
     */
    private function generateOrderNumber()
    {
        do {
            $orderNumber = 'ORD-' . date('Y') . '-' . strtoupper(Str::random(8));
        } while (Order::where('order_number', $orderNumber)->exists());

        return $orderNumber;
    }

    /**
     * Mock payment processing
     */
    private function processPayment($order, $paymentMethod)
    {
        // This is a mock payment processor
        // In a real application, you would integrate with Stripe, PayPal, etc.

        switch ($paymentMethod) {
            case 'credit_card':
                // Mock credit card processing
                $success = rand(1, 10) > 1; // 90% success rate
                break;
            case 'paypal':
                // Mock PayPal processing
                $success = rand(1, 10) > 1; // 90% success rate
                break;
            case 'cash_on_delivery':
                // COD is always successful
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

    /**
     * Send order confirmation email
     */
    private function sendOrderConfirmationEmail($order)
    {
        // Implement email sending logic here
        // Mail::to($order->customer_email)->send(new OrderConfirmation($order));
    }

    public function paypalCapture(Request $request)
    {
        $orderID = $request->input('orderID');
        $payerID = $request->input('payerID');
        // Optionally: Call PayPal API to verify/capture payment
        // Mark order as paid in your DB
        // Return JSON response with order number
        return response()->json(['order_number' => 'ORD-...']);
    }
}

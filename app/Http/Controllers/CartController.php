<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'integer|min:1|max:99'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }
        try {
            $productId = $request->get('product_id');
            $quantity = $request->get('quantity', 1);
            $cartItem = $this->cartService->addToCart($productId, $quantity);

            return response()->json([
                'success' => true,
                'message' => $cartItem['name'] . ' has been added to your cart!',
                'cart_count' => $this->cartService->getCartCount(),
                'cart_totals' => $this->cartService->getCartTotals()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function index()
    {
        $hasChanges = $this->cartService->validateCart();

        if ($hasChanges) {
            session()->flash('warning', 'Some items in your cart have been updated due to price or stock changes.');
        }

        $cartItems = $this->cartService->getCartItems();
        $cartTotals = $this->cartService->getCartTotals();

        return view('cart.index', compact('cartItems', 'cartTotals'));
    }

    public function add(Request $request, $productId)
    {
        $validator = Validator::make($request->all(), [
            'quantity' => 'integer|min:1|max:99'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        try {
            $quantity = $request->get('quantity', 1);
            $cartItem = $this->cartService->addToCart($productId, $quantity);
            session()->flash('success', $cartItem['name'] . ' has been added to your cart!');

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => $cartItem['name'] . ' has been added to your cart!',
                    'cart_count' => $this->cartService->getCartCount(),
                    'cart_totals' => $this->cartService->getCartTotals()
                ]);
            }

            return redirect()->back();
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 400);
            }

            return redirect()->back();
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'quantities' => 'required|array',
            'quantities.*' => 'integer|min:1|max:99'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $quantities = $request->get('quantities', []);

            foreach ($quantities as $productId => $quantity) {
                $this->cartService->updateQuantity($productId, $quantity);
            }

            session()->flash('success', 'Cart updated successfully!');

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Cart updated successfully!',
                    'cart_count' => $this->cartService->getCartCount(),
                    'cart_totals' => $this->cartService->getCartTotals()
                ]);
            }
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 400);
            }
        }

        return redirect()->route('cart.index');
    }

    public function remove($productId)
    {
        try {
            $removedItem = $this->cartService->removeFromCart($productId);

            session()->flash('success', $removedItem['name'] . ' has been removed from your cart.');

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => $removedItem['name'] . ' has been removed from your cart.',
                    'cart_count' => $this->cartService->getCartCount(),
                    'cart_totals' => $this->cartService->getCartTotals()
                ]);
            }
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 400);
            }
        }

        return redirect()->route('cart.index');
    }

    public function clear()
    {
        $this->cartService->clearCart();
        session()->flash('success', 'Your cart has been cleared.');

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Your cart has been cleared.',
                'cart_count' => 0
            ]);
        }

        return redirect()->route('cart.index');
    }
}

<?php

namespace App\Services;

use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class CartService
{
    const CART_SESSION_KEY = 'shopping_cart';

    public function getCartItems()
    {
        if (Auth::check()) {
            return $this->getUserCartItems(Auth::id());
        }
        return $this->getSessionCartItems();
    }

    public function addToCart($productId, $quantity = 1)
    {
        if (Auth::check()) {
            return $this->addToUserCart(Auth::id(), $productId, $quantity);
        }
        return $this->addToSessionCart($productId, $quantity);
    }

    public function updateQuantity($productId, $quantity)
    {
        if (Auth::check()) {
            return $this->updateUserCartQuantity(Auth::id(), $productId, $quantity);
        }
        return $this->updateSessionCartQuantity($productId, $quantity);
    }

    public function removeFromCart($productId)
    {
        if (Auth::check()) {
            return $this->removeFromUserCart(Auth::id(), $productId);
        }
        return $this->removeFromSessionCart($productId);
    }

    public function clearCart()
    {
        if (Auth::check()) {
            $this->clearUserCart(Auth::id());
        } else {
            $this->clearSessionCart();
        }
    }

    public function getCartTotals()
    {
        $cart = $this->getCartItems();

        $subtotal = 0;
        $totalItems = 0;
        $totalQuantity = 0;

        foreach ($cart as $item) {
            $subtotal += $item['subtotal'];
            $totalItems++;
            $totalQuantity += $item['quantity'];
        }

        $taxRate = 0.085;
        $tax = round($subtotal * $taxRate, 2);
        $total = round($subtotal + $tax, 2);

        return [
            'subtotal' => round($subtotal, 2),
            'tax' => $tax,
            'tax_rate' => $taxRate,
            'total' => $total,
            'total_items' => $totalItems,
            'total_quantity' => $totalQuantity
        ];
    }

    public function getCartCount()
    {
        $cart = $this->getCartItems();
        return array_sum(array_column($cart, 'quantity'));
    }

    public function hasItems()
    {
        return !empty($this->getCartItems());
    }

    public function validateCart()
    {
        $cart = $this->getCartItems();
        $updatedCart = [];
        $hasChanges = false;

        foreach ($cart as $productId => $item) {
            $product = Product::find($productId);

            if (!$product || !$product->is_active) {
                $hasChanges = true;
                continue;
            }

            if ($item['price'] != $product->current_price) {
                $item['price'] = $product->current_price;
                $item['subtotal'] = $product->current_price * $item['quantity'];
                $hasChanges = true;
            }

            if ($item['stock_quantity'] != $product->stock_quantity) {
                $item['stock_quantity'] = $product->stock_quantity;
                $hasChanges = true;
            }

            if ($item['quantity'] > $product->stock_quantity) {
                $item['quantity'] = $product->stock_quantity;
                $item['subtotal'] = $product->current_price * $item['quantity'];
                $hasChanges = true;
            }

            $updatedCart[$productId] = $item;
        }

        // Save validated cart
        if ($hasChanges) {
            if (Auth::check()) {
                $this->saveUserCartFromArray(Auth::id(), $updatedCart);
            } else {
                Session::put(self::CART_SESSION_KEY, $updatedCart);
            }
        }

        return $hasChanges;
    }

    // --- SESSION CART (for guests) ---

    private function getSessionCartItems()
    {
        return Session::get(self::CART_SESSION_KEY, []);
    }

    public function addToSessionCart($productId, $quantity = 1)
    {
        $product = Product::findOrFail($productId);

        if (!$product->is_active) {
            throw new \Exception('Product is not available');
        }

        $cart = $this->getSessionCartItems();

        $newQuantity = isset($cart[$productId])
            ? $cart[$productId]['quantity'] + $quantity
            : $quantity;

        if ($newQuantity > $product->stock_quantity) {
            throw new \Exception('Not enough stock available. Only ' . $product->stock_quantity . ' items left.');
        }

        $cart[$productId] = $this->cartItemArray($product, $newQuantity);

        Session::put(self::CART_SESSION_KEY, $cart);

        return $cart[$productId];
    }

    public function updateSessionCartQuantity($productId, $quantity)
    {
        $cart = $this->getSessionCartItems();

        if (!isset($cart[$productId])) {
            throw new \Exception('Product not found in cart');
        }

        $product = Product::findOrFail($productId);

        if ($quantity <= 0) {
            throw new \Exception('Quantity must be greater than 0');
        }

        if ($quantity > $product->stock_quantity) {
            throw new \Exception('Not enough stock available. Only ' . $product->stock_quantity . ' items left.');
        }

        $cart[$productId] = $this->cartItemArray($product, $quantity);

        Session::put(self::CART_SESSION_KEY, $cart);

        return $cart[$productId];
    }

    public function removeFromSessionCart($productId)
    {
        $cart = $this->getSessionCartItems();

        if (isset($cart[$productId])) {
            $removedItem = $cart[$productId];
            unset($cart[$productId]);
            Session::put(self::CART_SESSION_KEY, $cart);
            return $removedItem;
        }

        throw new \Exception('Product not found in cart');
    }

    public function clearSessionCart()
    {
        Session::forget(self::CART_SESSION_KEY);
    }

    // --- USER CART (DB) ---

    public function getUserCartItems($userId)
    {
        $items = CartItem::with('product')->where('user_id', $userId)->get();
        $cart = [];
        foreach ($items as $item) {
            if ($item->product) {
                $cart[$item->product_id] = $this->cartItemArray($item->product, $item->quantity);
            }
        }
        return $cart;
    }

    public function addToUserCart($userId, $productId, $quantity = 1)
    {
        $product = Product::findOrFail($productId);

        if (!$product->is_active) {
            throw new \Exception('Product is not available');
        }

        $cartItem = CartItem::where('user_id', $userId)->where('product_id', $productId)->first();

        $newQuantity = $cartItem
            ? $cartItem->quantity + $quantity
            : $quantity;

        if ($newQuantity > $product->stock_quantity) {
            throw new \Exception('Not enough stock available. Only ' . $product->stock_quantity . ' items left.');
        }

        if ($cartItem) {
            $cartItem->quantity = $newQuantity;
            $cartItem->save();
        } else {
            $cartItem = CartItem::create([
                'user_id' => $userId,
                'product_id' => $productId,
                'quantity' => $newQuantity
            ]);
        }

        return $this->cartItemArray($product, $cartItem->quantity);
    }

    public function updateUserCartQuantity($userId, $productId, $quantity)
    {
        $cartItem = CartItem::where('user_id', $userId)->where('product_id', $productId)->first();
        $product = Product::findOrFail($productId);

        if (!$cartItem) {
            throw new \Exception('Product not found in cart');
        }

        if ($quantity <= 0) {
            throw new \Exception('Quantity must be greater than 0');
        }

        if ($quantity > $product->stock_quantity) {
            throw new \Exception('Not enough stock available. Only ' . $product->stock_quantity . ' items left.');
        }

        $cartItem->quantity = $quantity;
        $cartItem->save();

        return $this->cartItemArray($product, $quantity);
    }

    public function removeFromUserCart($userId, $productId)
    {
        $cartItem = CartItem::where('user_id', $userId)->where('product_id', $productId)->first();
        if ($cartItem) {
            $removed = $this->cartItemArray($cartItem->product, $cartItem->quantity);
            $cartItem->delete();
            return $removed;
        }
        throw new \Exception('Product not found in cart');
    }

    public function clearUserCart($userId)
    {
        CartItem::where('user_id', $userId)->delete();
    }

    public function saveUserCartFromArray($userId, $cartArray)
    {
        // Sync DB with given cart array
        CartItem::where('user_id', $userId)->delete();
        foreach ($cartArray as $productId => $item) {
            CartItem::create([
                'user_id' => $userId,
                'product_id' => $productId,
                'quantity' => $item['quantity']
            ]);
        }
    }

    // --- SHARED ---

    private function cartItemArray($product, $quantity)
    {
        return [
            'id' => $product->id,
            'name' => $product->name,
            'slug' => $product->slug,
            'price' => $product->current_price,
            'original_price' => $product->price,
            'sale_price' => $product->sale_price,
            'image' => $product->image,
            'quantity' => $quantity,
            'stock_quantity' => $product->stock_quantity,
            'subtotal' => round($product->current_price * $quantity, 2)
        ];
    }

    // --- MERGE ON LOGIN ---

    public function mergeSessionCartWithUserCart($userId)
    {
        $sessionCart = $this->getSessionCartItems();
        foreach ($sessionCart as $productId => $item) {
            $this->addToUserCart($userId, $productId, $item['quantity']);
        }
        $this->clearSessionCart();
    }
}

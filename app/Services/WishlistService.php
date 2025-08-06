<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class WishlistService
{
    protected $sessionKey = 'wishlist';

    /**
     * Get the count of items in the wishlist.
     *
     * @return int
     */
    public function getWishlistCount()
    {
        if (Auth::check()) {
            // If you store wishlist items in the database for logged-in users, replace this block with Eloquent query.
            // Example:
            // return Auth::user()->wishlists()->count();
            return count(Session::get($this->sessionKey . '_user_' . Auth::id(), []));
        } else {
            // For guests, store wishlist in session
            return count(Session::get($this->sessionKey, []));
        }
    }

    /**
     * Get all wishlist items.
     *
     * @return array
     */
    public function getWishlistItems()
    {
        if (Auth::check()) {
            return Session::get($this->sessionKey . '_user_' . Auth::id(), []);
        } else {
            return Session::get($this->sessionKey, []);
        }
    }

    /**
     * Add an item to the wishlist.
     *
     * @param  mixed  $itemId
     * @return void
     */
    public function add($itemId)
    {
        if (Auth::check()) {
            $key = $this->sessionKey . '_user_' . Auth::id();
        } else {
            $key = $this->sessionKey;
        }
        $wishlist = Session::get($key, []);
        if (!in_array($itemId, $wishlist)) {
            $wishlist[] = $itemId;
            Session::put($key, $wishlist);
        }
    }

    /**
     * Remove an item from the wishlist.
     *
     * @param  mixed  $itemId
     * @return void
     */
    public function remove($itemId)
    {
        if (Auth::check()) {
            $key = $this->sessionKey . '_user_' . Auth::id();
        } else {
            $key = $this->sessionKey;
        }
        $wishlist = Session::get($key, []);
        $wishlist = array_diff($wishlist, [$itemId]);
        Session::put($key, $wishlist);
    }

    /**
     * Clear the wishlist.
     *
     * @return void
     */
    public function clear()
    {
        if (Auth::check()) {
            Session::forget($this->sessionKey . '_user_' . Auth::id());
        } else {
            Session::forget($this->sessionKey);
        }
    }
}

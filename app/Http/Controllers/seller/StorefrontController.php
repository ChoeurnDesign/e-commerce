<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use Illuminate\Support\Facades\Auth;

class StorefrontController extends Controller
{
    public function index()
    {
        $sellers = Seller::with('user')
            ->withCount('products')
            ->where('status', 'approved')
            ->paginate(16);

        return view('stores.index', compact('sellers'));
    }

    /**
     * Show a single seller's store and their products.
     *
     * Includes logic so the currently authenticated user sees their own review
     * even if it is not yet approved. Public visitors only see approved reviews.
     */
    public function show(Seller $seller)
    {
        $products = $seller->products()->latest()->paginate(12);

        // fetch approved reviews (public)
        $approvedReviews = $seller->receivedStoreReviews()
            ->where('is_approved', 1)
            ->latest()
            ->get();

        // if an authenticated user has a review for this store, include it
        $ownReview = null;
        if (Auth::check()) {
            $ownReview = $seller->receivedStoreReviews()
                ->where('user_id', Auth::id())
                ->first();
        }

        // combine: approved reviews + prepend the user's own unapproved review (if any)
        $reviews = $approvedReviews;
        if ($ownReview && !$ownReview->is_approved) {
            if (! $reviews->contains('id', $ownReview->id)) {
                $reviews = $reviews->prepend($ownReview);
            }
        }

        // compute display average and count based on approved reviews,
        // but include the viewer's own unapproved review in the calculation
        // so they see their rating reflected immediately.
        $ratings = $approvedReviews->pluck('rating')->map(function ($r) {
            return (float) $r;
        })->toArray();

        if ($ownReview && !$ownReview->is_approved) {
            $ratings[] = (float) $ownReview->rating;
        }

        $count = count($ratings);
        $avg = $count ? round(array_sum($ratings) / $count, 1) : 0.0;

        return view('stores.show', compact('seller', 'products', 'reviews', 'avg', 'count'));
    }
}
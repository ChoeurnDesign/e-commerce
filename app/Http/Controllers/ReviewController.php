<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Store a new review for a product.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating'     => 'required|integer|min:1|max:5',
            'comment'    => 'nullable|string|max:1000',
        ]);

        // Only buyers who completed the order may review
        $hasPurchased = OrderItem::where('product_id', $validated['product_id'])
            ->whereHas('order', fn ($q) => $q->where('user_id', Auth::id())->where('status', 'completed'))
            ->exists();

        if (!$hasPurchased) {
            return redirect()->back()->with('error', 'You can only review products you have purchased and received.');
        }

        // Prevent duplicate review
        if (Review::where('user_id', Auth::id())->where('product_id', $validated['product_id'])->exists()) {
            return redirect()->back()->with('error', 'You have already reviewed this product.');
        }

        $review = new Review([
            'user_id'     => Auth::id(),
            'product_id'  => $validated['product_id'],
            'rating'      => $validated['rating'],
            'comment'     => $validated['comment'] ?? '',
            'is_approved' => true,
        ]);

        $review->save();

        return redirect()->back()->with('success', 'Review submitted successfully!');
    }

    public function edit(Review $review)
    {
        // Optional: check if the current user is the owner of the review
        if ($review->user_id !== Auth::id()) {
            abort(403);
        }
        return view('reviews.edit', compact('review'));
    }

    public function update(Request $request, Review $review)
    {
        if ($review->user_id !== Auth::id()) {
            abort(403);
        }
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);
        $review->update($validated);
        return redirect()->route('products.show', $review->product->slug)
            ->with('success', 'Review updated successfully!');
    }

    /**
     * Delete the specified review.
     */
    public function destroy(Review $review)
    {
        if ($review->user_id !== Auth::id()) {
            abort(403);
        }
        $review->delete();

        return redirect()->route('products.show', $review->product->slug)
            ->with('success', 'Review deleted successfully!');
    }
}

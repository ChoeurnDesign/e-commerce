<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StoreReview;
use App\Models\Seller;
use Illuminate\Support\Facades\Auth;

class StoreReviewController extends Controller
{
    public function store(Request $request, Seller $seller)
    {
        $userId = Auth::id();

        // Avoid duplicate reviews from the same user for the seller
        $existingReview = StoreReview::where('user_id', $userId)
            ->where('seller_id', $seller->id)
            ->first();

        if ($existingReview) {
            return back()->with('error', 'You have already reviewed this seller.');
        }

        // Validate the input
        $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'required|string|max:1000',
        ]);

        // Automatically approve the review
        StoreReview::create([
            'user_id' => $userId,
            'seller_id' => $seller->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'is_approved' => true, // Always set to approved
        ]);

        return back()->with('success', 'Review submitted successfully and is now visible.');
    }

    public function index(Request $request)
    {
        $sellerId = $this->resolveSellerIdFromAuth();

        // Handle cases where seller ID is not resolved
        if (!$sellerId) {
            $reviews = StoreReview::with('user')->whereRaw('0 = 1')->paginate(20);
            return view('seller.reviews.index', compact('reviews'));
        }

        $search = trim($request->input('q', ''));

        // Query for reviews with optional search
        $query = StoreReview::with('user')
            ->where('seller_id', $sellerId)
            ->where('is_approved', true) // Ensure only approved reviews are shown
            ->latest();

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                if (ctype_digit($search)) {
                    $q->orWhere('id', $search);
                }

                if (is_numeric($search)) {
                    $r = (int) $search;
                    if ($r >= 1 && $r <= 5) {
                        $q->orWhere('rating', $r);
                    }
                }

                $q->orWhere('comment', 'like', "%{$search}%");

                $q->orWhereHas('user', function ($uq) use ($search) {
                    $uq->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            });
        }

        $reviews = $query->paginate(20)->appends($request->only('q'));

        return view('seller.reviews.index', compact('reviews'));
    }

    public function show(StoreReview $review)
    {
        $this->authorizeSellerAccess($review);
        return view('seller.reviews.show', compact('review'));
    }

    public function edit(StoreReview $review)
    {
        $this->authorizeSellerAccess($review);
        return view('seller.reviews.edit', compact('review'));
    }

    public function update(Request $request, StoreReview $review)
    {
        $userId = Auth::id();
        $sellerId = $this->resolveSellerIdFromAuth();

        // Ensure only authorized users can update reviews
        if ($review->user_id !== $userId && $review->seller_id !== $sellerId) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        // Validate the input
        $data = $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'required|string|max:1000',
        ]);

        $review->update([
            'rating' => $data['rating'],
            'comment' => $data['comment'],
        ]);

        if ($request->ajax() || $request->wantsJson() || $request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Review updated successfully', 'review' => $review]);
        }

        return back()->with('success', 'Review updated successfully!');
    }

    public function destroy(StoreReview $review)
    {
        $userId = Auth::id();

        // Ensure only the review owner can delete
        if ($review->user_id !== $userId) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $review->delete();

        return response()->json(['success' => true, 'message' => 'Review deleted successfully']);
    }

    protected function authorizeSellerAccess(StoreReview $review)
    {
        $sellerId = $this->resolveSellerIdFromAuth();
        if ($review->seller_id !== $sellerId) {
            abort(403);
        }
    }

    protected function resolveSellerIdFromAuth()
    {
        $userId = Auth::id(); // Get authenticated user ID
        
        // Handle cases where the user is not authenticated
        if (!$userId) {
            return null;
        }

        // Fetch seller ID associated with the user
        return Seller::where('user_id', $userId)->value('id');
    }
}
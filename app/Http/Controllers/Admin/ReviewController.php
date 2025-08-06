<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;

class ReviewController extends Controller
{
    public function index()
    {
        // Fetch reviews with related product and user, ordered by latest, paginated
        $reviews = Review::with('product', 'user')->latest()->paginate(10);

        return view('admin.reviews.index', compact('reviews'));
    }
}

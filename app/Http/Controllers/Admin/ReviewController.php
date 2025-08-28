<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string)$request->input('q'));

        $reviews = Review::with(['product','user'])
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    // Numeric: match id or rating exactly
                    if (ctype_digit($q)) {
                        $sub->orWhere('id', (int)$q)
                            ->orWhere('rating', (int)$q);
                    }
                    // Comment text
                    $sub->orWhere('comment', 'like', "%{$q}%")
                        // Product name
                        ->orWhereHas('product', function ($p) use ($q) {
                            $p->where('name', 'like', "%{$q}%");
                        })
                        // Reviewer user (name/email)
                        ->orWhereHas('user', function ($u) use ($q) {
                            $u->where('name', 'like', "%{$q}%")
                              ->orWhere('email', 'like', "%{$q}%");
                        });
                });
            })
            ->latest()
            ->paginate(10)
            ->appends(['q' => $q]);

        return view('admin.reviews.index', compact('reviews'));
    }

    public function edit($id)
    {
        $review = Review::with(['product', 'user'])->findOrFail($id);
        return view('admin.reviews.edit', compact('review'));
    }

    public function update(Request $request, $id)
    {
        $review = Review::findOrFail($id);

        $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'required|string',
        ]);

        $review->update([
            'rating'  => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->route('admin.reviews.index')->with('success', 'Review updated!');
    }

    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        return redirect()->route('admin.reviews.index')
            ->with('success', 'Review removed successfully.');
    }
}

<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class SellerFollowController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Follow a seller.
     */
    public function store(Request $request, Seller $seller)
    {
        $user = $request->user();

        // Optional: prevent following your own store if seller has user_id owner
        if (isset($seller->user_id) && $seller->user_id === $user->id) {
            if ($request->wantsJson()) {
                return response()->json(['status' => 'error', 'message' => 'Cannot follow your own store.'], 403);
            }
            return back()->with('error', 'Cannot follow your own store.');
        }

        $seller->followers()->syncWithoutDetaching([$user->id]);

        // If you added followers_count column, increment it
        if (isset($seller->followers_count)) {
            $seller->increment('followers_count');
        }

        $count = $seller->followers()->count();

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'ok',
                'following' => true,
                'followers_count' => $count,
            ]);
        }

        return back()->with('success', 'You are now following this store.');
    }

    /**
     * Unfollow a seller.
     */
    public function destroy(Request $request, Seller $seller)
    {
        $user = $request->user();

        $deleted = $seller->followers()->detach($user->id);

        if (isset($seller->followers_count) && $deleted) {
            $seller->decrement('followers_count');
        }

        $count = $seller->followers()->count();

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'ok',
                'following' => false,
                'followers_count' => $count,
            ]);
        }

        return back()->with('success', 'You have unfollowed this store.');
    }
}
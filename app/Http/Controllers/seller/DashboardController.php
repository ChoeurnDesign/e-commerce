<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Services\Seller\DashboardMetricsService;

class DashboardController extends Controller
{
    public function index(DashboardMetricsService $metrics)
    {
        $user   = Auth::user();
        $seller = $user->seller;

        if (!$seller) {
            return redirect()->route('seller.register.form')
                ->with('warning', 'Create a seller account first.');
        }

        $data = $metrics->forSeller($seller, [
            'include_products' => true,
            'include_orders'   => true,
            'include_ratings'  => true,
        ]);

        // Compute unread chat count for the header (works with chat_participants + last_read_at schema)
        $unreadSellerChats = 0;
        if ($user) {
            try {
                $unreadSellerChats = DB::table('chat_messages')
                    ->join('chat_participants', 'chat_messages.chat_id', '=', 'chat_participants.chat_id')
                    ->where('chat_participants.user_id', $user->id)
                    ->where('chat_messages.sender_id', '!=', $user->id)
                    ->where(function ($q) {
                        $q->whereNull('chat_messages.is_read')
                          ->orWhere('chat_messages.is_read', false);
                    })
                    ->where(function ($q) {
                        $q->whereNull('chat_participants.last_read_at')
                          ->orWhereColumn('chat_messages.created_at', '>', 'chat_participants.last_read_at');
                    })
                    ->count();
            } catch (\Throwable $e) {
                // Record the failure so you can investigate; keep page functional
                Log::error('Failed computing unreadSellerChats in DashboardController', [
                    'user_id' => $user->id ?? null,
                    'exception' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);

                $unreadSellerChats = 0;
            }
        }

        return view('seller.dashboard', [
            'seller'            => $seller,
            'productsCount'     => $data['products_count'],
            'ordersCount'       => $data['orders_count'],
            'averageRating'     => $data['average_rating'],
            'unreadSellerChats' => (int) $unreadSellerChats,
        ]);
    }
}
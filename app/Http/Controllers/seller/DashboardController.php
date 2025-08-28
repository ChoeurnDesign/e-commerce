<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\Seller\DashboardMetricsService;

class DashboardController extends Controller
{
    public function index(DashboardMetricsService $metrics)
    {
        $user   = Auth::user();
        $seller = $user->seller;

        if (!$seller) {
            return redirect()->route('sell.start')
                ->with('warning', 'Create a seller account first.');
        }

        $data = $metrics->forSeller($seller, [
            'include_products' => true,
            'include_orders'   => true,
            'include_ratings'  => true,
        ]);

        return view('seller.dashboard', [
            'seller'          => $seller,
            'productsCount'   => $data['products_count'],
            'ordersCount'     => $data['orders_count'],
            'averageRating'   => $data['average_rating'],
        ]);
    }
}
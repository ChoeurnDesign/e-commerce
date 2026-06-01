<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PlatformWallet;
use App\Models\Product;
use App\Models\Seller;
use App\Models\User;
use App\Models\VendorOrder;
use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Creates ~30 demo orders across every status to showcase the full lifecycle.
 *
 * Distribution:
 *   - 5 pending          (just placed, COD)
 *   - 5 processing       (paid, awaiting seller)
 *   - 5 confirmed        (seller confirmed, preparing)
 *   - 5 shipped          (in transit, has shipped_at)
 *   - 5 delivered        (eligible for refund — within 7 days)
 *   - 8 completed        (customer confirmed receipt, money paid out)
 *   - 1 cancelled
 *   - 1 with refund flow (separately created by DemoReturnSeeder)
 *
 * Mixes payment methods (COD / credit card / paypal / bank transfer).
 * Some orders are multi-vendor (items from 2 different sellers).
 */
class DemoOrderSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Creating demo orders across all statuses...');

        $customers = User::where('role', 'user')->get();
        $products  = Product::where('is_active', true)->where('stock_quantity', '>', 5)->get();

        if ($customers->isEmpty() || $products->isEmpty()) {
            $this->command->error('  ✕ Need customers and products first.');
            return;
        }

        $platformWallet = PlatformWallet::getInstance();

        // ── Status distribution ─────────────────────────────────────────────
        $statusPlan = [
            ['count' => 5, 'status' => 'pending',    'payment_status' => 'pending',                'payment_method' => 'cash_on_delivery', 'days_ago_min' => 0, 'days_ago_max' => 2],
            ['count' => 5, 'status' => 'processing', 'payment_status' => 'paid',                   'payment_method' => 'credit_card',      'days_ago_min' => 1, 'days_ago_max' => 3],
            ['count' => 5, 'status' => 'confirmed',  'payment_status' => 'paid',                   'payment_method' => 'paypal',           'days_ago_min' => 2, 'days_ago_max' => 5],
            ['count' => 5, 'status' => 'shipped',    'payment_status' => 'paid',                   'payment_method' => 'credit_card',      'days_ago_min' => 4, 'days_ago_max' => 7,  'shipped' => true],
            ['count' => 5, 'status' => 'delivered',  'payment_status' => 'paid',                   'payment_method' => 'credit_card',      'days_ago_min' => 5, 'days_ago_max' => 8,  'shipped' => true, 'delivered' => true],
            ['count' => 8, 'status' => 'completed',  'payment_status' => 'paid',                   'payment_method' => 'paypal',           'days_ago_min' => 10, 'days_ago_max' => 60, 'shipped' => true, 'delivered' => true, 'completed' => true],
            ['count' => 1, 'status' => 'cancelled',  'payment_status' => 'failed',                 'payment_method' => 'cash_on_delivery', 'days_ago_min' => 3, 'days_ago_max' => 3],
            ['count' => 2, 'status' => 'pending',    'payment_status' => 'awaiting_verification',  'payment_method' => 'bank_transfer',    'days_ago_min' => 1, 'days_ago_max' => 2],
        ];

        $totalCreated = 0;

        foreach ($statusPlan as $plan) {
            for ($i = 0; $i < $plan['count']; $i++) {
                $createdAt = Carbon::now()->subDays(rand($plan['days_ago_min'], $plan['days_ago_max']))
                    ->subHours(rand(0, 23))->subMinutes(rand(0, 59));

                $customer = $customers->random();

                // Some orders are multi-vendor (40% chance for completed/delivered)
                $multiVendor = in_array($plan['status'], ['completed', 'delivered']) && rand(1, 10) <= 4;
                $sellerCount = $multiVendor ? 2 : 1;

                $orderProducts = $products->shuffle()
                    ->groupBy('seller_id')
                    ->take($sellerCount)
                    ->map(fn($group) => $group->take(rand(1, 3)))
                    ->flatten();

                if ($orderProducts->isEmpty()) continue;

                DB::transaction(function () use ($orderProducts, $customer, $plan, $createdAt, $platformWallet) {
                    // Calculate totals
                    $subtotal = 0;
                    foreach ($orderProducts as $p) {
                        $qty   = rand(1, 2);
                        $price = $p->on_sale && $p->sale_price ? (float) $p->sale_price : (float) $p->price;
                        $subtotal += $price * $qty;
                    }
                    $tax        = round($subtotal * 0.085, 2);
                    $totalPrice = $subtotal + $tax;

                    // Create the order
                    $order = Order::create([
                        'order_number'     => 'ORD-' . $createdAt->format('Ymd') . '-' . strtoupper(Str::random(5)),
                        'user_id'          => $customer->id,
                        'subtotal'         => $subtotal,
                        'tax_amount'       => $tax,
                        'total_price'      => $totalPrice,
                        'status'           => $plan['status'],
                        'payment_status'   => $plan['payment_status'],
                        'payment_method'   => $plan['payment_method'],
                        'payment_id'       => strtoupper(substr($plan['payment_method'], 0, 3)) . '_' . strtoupper(Str::random(10)),
                        'customer_name'    => $customer->name,
                        'customer_email'   => $customer->email,
                        'customer_phone'   => '+1 555 ' . rand(1000, 9999),
                        'shipping_address' => rand(100, 999) . ' Demo Street',
                        'shipping_city'    => collect(['Phnom Penh', 'New York', 'London', 'Singapore', 'Tokyo'])->random(),
                        'shipping_state'   => '',
                        'shipping_postal_code' => (string) rand(10000, 99999),
                        'shipping_country' => collect(['Cambodia', 'USA', 'UK', 'Singapore', 'Japan'])->random(),
                        'shipped_at'       => !empty($plan['shipped'])   ? $createdAt->copy()->addDays(1)   : null,
                        'delivered_at'     => !empty($plan['delivered']) ? $createdAt->copy()->addDays(3)   : null,
                        'created_at'       => $createdAt,
                        'updated_at'       => $createdAt,
                    ]);

                    // Create order items
                    foreach ($orderProducts as $p) {
                        $qty   = rand(1, 2);
                        $price = $p->on_sale && $p->sale_price ? (float) $p->sale_price : (float) $p->price;
                        OrderItem::create([
                            'order_id'     => $order->id,
                            'seller_id'    => $p->seller_id,
                            'product_id'   => $p->id,
                            'product_name' => $p->name,
                            'product_sku'  => $p->sku,
                            'product_image' => $p->image,
                            'quantity'     => $qty,
                            'price'        => $price,
                            'total'        => $price * $qty,
                        ]);
                    }

                    // Create vendor orders (one per seller)
                    $itemsBySeller = $order->orderItems()->get()->groupBy('seller_id');
                    foreach ($itemsBySeller as $sellerId => $items) {
                        $seller         = Seller::find($sellerId);
                        $commissionRate = $seller->commission_rate ?? 10.00;
                        $vSubtotal      = round($items->sum('total'), 2);
                        $commission     = round($vSubtotal * $commissionRate / 100, 2);
                        $earnings       = round($vSubtotal - $commission, 2);

                        // Determine vendor order status based on main order status
                        $voStatus = match ($plan['status']) {
                            'pending'    => 'pending',
                            'processing' => 'processing',
                            'confirmed', 'shipped' => 'confirmed',
                            'delivered'  => 'confirmed',
                            'completed'  => 'completed',
                            'cancelled'  => 'cancelled',
                            default      => 'pending',
                        };

                        VendorOrder::create([
                            'order_id'          => $order->id,
                            'seller_id'         => $sellerId,
                            'subtotal'          => $vSubtotal,
                            'commission_rate'   => $commissionRate,
                            'commission_source' => 'seller',
                            'commission_amount' => $commission,
                            'seller_earnings'   => $earnings,
                            'status'            => $voStatus,
                            'payout_status'     => $voStatus === 'completed' ? 'pending' : 'pending',
                            'created_at'        => $createdAt,
                            'updated_at'        => $createdAt,
                        ]);
                    }

                    // ── MONEY FLOW ──
                    // If paid: credit platform wallet
                    if ($plan['payment_status'] === 'paid') {
                        $platformWallet->receiveOrderPayment($order, $totalPrice);

                        // Payment gateway fee for card/paypal
                        if (in_array($plan['payment_method'], ['credit_card', 'paypal'])) {
                            $feeRate = $plan['payment_method'] === 'credit_card' ? 2.9 : 3.49;
                            $feeFlat = $plan['payment_method'] === 'credit_card' ? 0.30 : 0.49;
                            $fee = round(($totalPrice * $feeRate / 100) + $feeFlat, 2);
                            $order->update(['payment_fee_amount' => $fee]);
                            $platformWallet->recordPaymentFee($order, $fee);
                        }
                    }

                    // If completed: distribute earnings to sellers
                    if (!empty($plan['completed'])) {
                        $order->distributeVendorEarnings();
                    }
                });

                $totalCreated++;
            }
        }

        $this->command->info("  ✓ Created {$totalCreated} demo orders");
        $this->command->info("    Distribution: 5 pending + 5 processing + 5 confirmed + 5 shipped + 5 delivered + 8 completed + 1 cancelled + 2 bank-transfer awaiting-verification");
    }
}

<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Models\PlatformWallet;
use App\Models\VendorOrder;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Auto-confirm delivered orders that customers forgot to confirm.
 *
 * Industry standard:
 *   • Shopee  → 7 days after delivery
 *   • Amazon  → 14 days after delivery
 *   • Lazada  → 7 days after delivery
 *
 * Runs daily via scheduler at 02:00.
 * Finds orders in `delivered` status older than N days,
 * marks them `completed`, and credits seller wallets via platform.
 */
class AutoConfirmDeliveredOrders extends Command
{
    protected $signature = 'orders:auto-confirm {--days=7 : Number of days after delivery to auto-confirm}';

    protected $description = 'Auto-confirm delivered orders after N days and release seller earnings.';

    public function handle(): int
    {
        $days = (int) $this->option('days');
        $threshold = Carbon::now()->subDays($days);

        $this->info("Looking for delivered orders older than {$days} days (before {$threshold->toDateString()})…");

        $orders = Order::where('status', 'delivered')
            ->where('payout_released', false)
            ->where(function ($q) use ($threshold) {
                $q->where(function ($q1) use ($threshold) {
                        $q1->whereNotNull('delivered_at')
                           ->where('delivered_at', '<=', $threshold);
                    })
                    ->orWhere(function ($q1) use ($threshold) {
                        $q1->whereNull('delivered_at')
                           ->where('updated_at', '<=', $threshold);
                    });
            })
            ->with('vendorOrders')
            ->get();

        if ($orders->isEmpty()) {
            $this->info('No orders to auto-confirm. ✓');
            return self::SUCCESS;
        }

        $this->info("Found {$orders->count()} orders to auto-confirm.");

        $confirmed = 0;
        $errors    = 0;
        $totalPaid = 0;

        foreach ($orders as $order) {
            try {
                DB::transaction(function () use ($order, &$totalPaid) {

                    // 1. If COD and payment still pending → mark as paid + credit platform
                    if ($order->payment_method === 'cash_on_delivery' && $order->payment_status !== 'paid') {
                        $order->update(['payment_status' => 'paid']);
                        PlatformWallet::getInstance()->receiveOrderPayment($order, (float) $order->total_price);
                    }

                    // 2. Mark order + vendor orders as completed
                    $order->update(['status' => 'completed']);

                    VendorOrder::where('order_id', $order->id)
                        ->whereNotIn('status', ['completed', 'cancelled'])
                        ->update(['status' => 'completed']);

                    // 3. Distribute earnings via the proper method
                    //    (credits seller wallets + debits platform wallet + records transactions)
                    $order->distributeVendorEarnings();

                    $totalPaid += (float) $order->vendorOrders->sum('seller_earnings');
                });

                $confirmed++;
                $this->line("  ✓ Order #{$order->order_number} auto-confirmed");

            } catch (\Throwable $e) {
                $errors++;
                Log::error('Auto-confirm failed for order ' . $order->order_number, [
                    'order_id' => $order->id,
                    'error'    => $e->getMessage(),
                ]);
                $this->error("  ✕ Order #{$order->order_number} failed: {$e->getMessage()}");
            }
        }

        $this->newLine();
        $this->info("Summary:");
        $this->info("  • Confirmed: {$confirmed}");
        $this->info("  • Errors:    {$errors}");
        $this->info("  • Paid out:  $" . number_format($totalPaid, 2));

        return $errors > 0 ? self::FAILURE : self::SUCCESS;
    }
}

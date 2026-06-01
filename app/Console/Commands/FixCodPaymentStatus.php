<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Models\PlatformWallet;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

/**
 * One-time repair: Fix COD orders that were completed but never had
 * payment_status updated to "paid" (due to pre-fix code path).
 *
 * Run: php artisan orders:fix-cod-payment-status
 */
class FixCodPaymentStatus extends Command
{
    protected $signature = 'orders:fix-cod-payment-status {--dry-run : Show what would be fixed without making changes}';

    protected $description = 'Repair COD orders that completed without payment_status being updated to paid.';

    public function handle(): int
    {
        $dryRun = $this->option('dry-run');

        // Find broken orders: COD + completed/delivered + payment_status NOT paid
        $brokenOrders = Order::where('payment_method', 'cash_on_delivery')
            ->whereIn('status', ['completed', 'delivered'])
            ->where('payment_status', '!=', 'paid')
            ->get();

        if ($brokenOrders->isEmpty()) {
            $this->info('No broken COD orders found. All clean!');
            return self::SUCCESS;
        }

        $this->warn("Found {$brokenOrders->count()} broken COD orders to repair:");

        $totalFixed = 0;

        foreach ($brokenOrders as $order) {
            $this->line("  - #{$order->order_number}  status={$order->status}  payment_status={$order->payment_status}  total=\${$order->total_price}");

            if ($dryRun) continue;

            try {
                DB::transaction(function () use ($order, &$totalFixed) {
                    $order->update(['payment_status' => 'paid']);

                    PlatformWallet::getInstance()
                        ->receiveOrderPayment($order, (float) $order->total_price);

                    $totalFixed += (float) $order->total_price;
                });

                $this->info("    Fixed - platform credited \${$order->total_price}");
            } catch (\Throwable $e) {
                $this->error("    Failed: {$e->getMessage()}");
            }
        }

        $this->newLine();
        if ($dryRun) {
            $this->comment("Dry-run mode - no changes made. Run without --dry-run to apply.");
        } else {
            $this->info("Repair complete. Platform wallet credited: \$" . number_format($totalFixed, 2));
        }

        return self::SUCCESS;
    }
}

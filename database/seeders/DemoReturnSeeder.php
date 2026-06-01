<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Refund;
use App\Models\ReturnRequest;
use App\Models\ReturnRequestItem;
use App\Services\Refund\RefundService;
use Illuminate\Database\Seeder;

class DemoReturnSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Creating demo return requests...');

        // Pick 3 completed orders for returns
        $completedOrders = Order::where('status', 'completed')
            ->with(['vendorOrders', 'orderItems'])
            ->latest()
            ->limit(3)
            ->get();

        if ($completedOrders->count() < 3) {
            $this->command->warn('  ⚠ Need at least 3 completed orders. Run DemoOrderSeeder first.');
            return;
        }

        $service = app(RefundService::class);

        // ── Return 1: PENDING SELLER REVIEW ─────────────────────────────────
        $order1 = $completedOrders[0];
        $vo1    = $order1->vendorOrders->first();
        $items1 = $order1->orderItems->where('seller_id', $vo1->seller_id);

        if ($items1->isNotEmpty()) {
            $return1 = $service->createReturnRequest(
                $order1,
                $vo1,
                $items1->map(fn($i) => ['order_item_id' => $i->id, 'quantity' => $i->quantity])->values()->all(),
                'damaged',
                'The package arrived with a crack on the side. Item is unusable. Please see attached photos.',
                'original_payment'
            );
            $this->command->info("  ✓ Return 1: {$return1->reference} (pending seller review)");
        }

        // ── Return 2: APPROVED + REFUNDED ───────────────────────────────────
        $order2 = $completedOrders[1];
        $vo2    = $order2->vendorOrders->first();
        $items2 = $order2->orderItems->where('seller_id', $vo2->seller_id)->take(1);

        if ($items2->isNotEmpty()) {
            $return2 = $service->createReturnRequest(
                $order2,
                $vo2,
                $items2->map(fn($i) => ['order_item_id' => $i->id, 'quantity' => 1])->values()->all(),
                'not_as_described',
                'The color is different from what was shown in the listing.',
                'store_credit'
            );

            try {
                $service->approve($return2, 'We apologize for the mix-up. Store credit will be issued immediately.');
                $service->processRefund($return2);
                $this->command->info("  ✓ Return 2: {$return2->reference} (approved + refunded as store credit)");
            } catch (\Throwable $e) {
                $this->command->warn("  ⚠ Return 2 approval/refund failed: " . $e->getMessage());
            }
        }

        // ── Return 3: REJECTED ──────────────────────────────────────────────
        $order3 = $completedOrders[2];
        $vo3    = $order3->vendorOrders->first();
        $items3 = $order3->orderItems->where('seller_id', $vo3->seller_id)->take(1);

        if ($items3->isNotEmpty()) {
            $return3 = $service->createReturnRequest(
                $order3,
                $vo3,
                $items3->map(fn($i) => ['order_item_id' => $i->id, 'quantity' => 1])->values()->all(),
                'changed_mind',
                'I changed my mind, I want to return it.',
                'original_payment'
            );

            try {
                $service->reject($return3, 'Per our policy, change-of-mind returns are not accepted after 7 days. The item is also clearly used.');
                $this->command->info("  ✓ Return 3: {$return3->reference} (rejected)");
            } catch (\Throwable $e) {
                $this->command->warn("  ⚠ Return 3 rejection failed: " . $e->getMessage());
            }
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\PayoutRequest;
use App\Models\Seller;
use App\Models\User;
use Illuminate\Database\Seeder;

class DemoPayoutSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Creating demo payout requests...');

        $sellers = Seller::where('status', 'approved')->get();
        $admin   = User::where('role', 'admin')->first();

        if ($sellers->isEmpty() || !$admin) {
            $this->command->warn('  ⚠ Need approved sellers and an admin.');
            return;
        }

        $payouts = [
            // Pending — admin must process
            [
                'seller_idx'           => 0,
                'amount'               => 247.50,
                'bank_name'            => 'ABA Bank',
                'account_name'         => 'Demo Seller',
                'account_number'       => '000 123 456',
                'phone'                => '+855 12 345 678',
                'seller_note'          => 'Please process when convenient.',
                'status'               => 'pending',
                'processed_by'         => null,
                'processed_at'         => null,
                'days_ago'             => 2,
            ],
            // Approved — admin acknowledged but not paid yet
            [
                'seller_idx'           => 1,
                'amount'               => 532.10,
                'bank_name'            => 'ACLEDA Bank',
                'account_name'         => 'MobileHub Owner',
                'account_number'       => '111 222 333',
                'phone'                => '+855 12 222 333',
                'status'               => 'approved',
                'processed_by'         => $admin->id,
                'processed_at'         => now()->subDays(1),
                'days_ago'             => 5,
            ],
            // Paid — fully completed
            [
                'seller_idx'           => 2,
                'amount'               => 1245.80,
                'bank_name'            => 'Wing Bank',
                'account_name'         => 'GadgetZone Owner',
                'account_number'       => '999 888 777',
                'phone'                => '+855 12 999 888',
                'status'               => 'paid',
                'processed_by'         => $admin->id,
                'processed_at'         => now()->subDays(7),
                'transaction_reference' => 'TXN-' . strtoupper(\Illuminate\Support\Str::random(10)),
                'admin_note'           => 'Transferred via ABA. Confirmation sent to seller email.',
                'days_ago'             => 14,
            ],
        ];

        foreach ($payouts as $p) {
            $idx = $p['seller_idx'];
            if (!isset($sellers[$idx])) continue;

            $seller = $sellers[$idx];
            unset($p['seller_idx'], $p['days_ago']);

            PayoutRequest::updateOrCreate(
                [
                    'seller_id' => $seller->id,
                    'amount'    => $p['amount'],
                ],
                $p + [
                    'seller_id'  => $seller->id,
                    'created_at' => now()->subDays(rand(2, 14)),
                ]
            );

            $this->command->info("  ✓ Payout {$p['status']}: \${$p['amount']} → {$seller->store_name}");
        }
    }
}

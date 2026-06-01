<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Illuminate\Database\Seeder;

class DemoCouponSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Creating demo coupons...');

        $coupons = [
            // Platform-funded (marketing campaign)
            [
                'code'             => 'WELCOME10',
                'discount_type'    => 'percentage',
                'discount_value'   => 10,
                'funded_by'        => 'platform',
                'min_order_amount' => 50,
                'max_uses'         => 1000,
                'is_active'        => true,
                'expiry_date'      => now()->addMonths(3),
            ],
            [
                'code'             => 'NEWYEAR50',
                'discount_type'    => 'fixed',
                'discount_value'   => 50,
                'funded_by'        => 'platform',
                'min_order_amount' => 200,
                'max_uses'         => 500,
                'is_active'        => true,
                'expiry_date'      => now()->addMonth(),
            ],
            // Seller-funded (seller absorbs the discount)
            [
                'code'             => 'SELLER15',
                'discount_type'    => 'percentage',
                'discount_value'   => 15,
                'funded_by'        => 'seller',
                'min_order_amount' => 100,
                'max_uses'         => 200,
                'is_active'        => true,
                'expiry_date'      => now()->addMonths(2),
            ],
            [
                'code'             => 'FLASH20',
                'discount_type'    => 'percentage',
                'discount_value'   => 20,
                'funded_by'        => 'platform',
                'min_order_amount' => 0,
                'max_uses'         => 100,
                'is_active'        => true,
                'expiry_date'      => now()->addDays(7),
            ],
            // Expired (for variety)
            [
                'code'             => 'BLACKFRIDAY',
                'discount_type'    => 'percentage',
                'discount_value'   => 25,
                'funded_by'        => 'platform',
                'min_order_amount' => 0,
                'max_uses'         => 1000,
                'used_count'       => 847,
                'is_active'        => false,
                'expiry_date'      => now()->subDays(30),
            ],
        ];

        foreach ($coupons as $c) {
            Coupon::updateOrCreate(['code' => $c['code']], $c);
            $this->command->info("  ✓ {$c['code']}  ({$c['discount_value']}{$this->symbol($c)} off, funded by {$c['funded_by']})");
        }
    }

    protected function symbol(array $c): string
    {
        return $c['discount_type'] === 'percentage' ? '%' : '$';
    }
}

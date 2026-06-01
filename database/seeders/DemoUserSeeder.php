<?php

namespace Database\Seeders;

use App\Models\Seller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * Seeds the user accounts needed for demo:
 *   - 1 admin
 *   - 5 sellers (3 approved, 1 pending, 1 rejected)
 *   - 10 customers (1 demo + 9 realistic from different countries)
 *
 * Demo logins (all password: 'password'):
 *   admin@shop.com         → administrator
 *   seller@shop.com        → main demo seller (TechWorld VIP)
 *   customer@shop.com      → main demo customer
 */
class DemoUserSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Creating demo users...');

        // ── ADMIN ────────────────────────────────────────────────────────────
        $admin = User::updateOrCreate(
            ['email' => 'admin@shop.com'],
            [
                'name'           => 'Admin User',
                'password'       => Hash::make('password'),
                'role'           => 'admin',
                'email_verified_at' => now(),
            ]
        );
        $this->command->info("  ✓ Admin: admin@shop.com / password");

        // ── DEMO SELLER (main one for demo) ──────────────────────────────────
        $demoSellerUser = User::updateOrCreate(
            ['email' => 'seller@shop.com'],
            [
                'name'           => 'Demo Seller',
                'password'       => Hash::make('password'),
                'role'           => 'seller',
                'email_verified_at' => now(),
            ]
        );

        Seller::updateOrCreate(
            ['user_id' => $demoSellerUser->id],
            [
                'store_name'        => 'TechWorld VIP',
                'slug'              => 'techworld-vip',
                'description'       => 'Your trusted source for the latest electronics, smartphones, and laptops. Free shipping on orders over $100.',
                'status'            => 'approved',
                'contact_email'     => 'contact@techworld.com',
                'phone'             => '+1 555 0101',
                'address'           => '123 Tech Avenue, San Francisco, CA',
                'website'           => 'https://techworld-vip.example.com',
                'commission_rate'   => 8.00,  // VIP gets 8% instead of 10%
                'ships_worldwide'   => true,
                'returns_days'      => 7,
                'response_time'     => 'Within 24 hours',
                'shipping_summary'  => 'Standard shipping 3-5 business days. Express 1-2 days available.',
                'verified_at'       => now()->subMonths(8),
            ]
        );
        $this->command->info("  ✓ Demo Seller: seller@shop.com / password (TechWorld VIP)");

        // ── OTHER SELLERS ────────────────────────────────────────────────────
        $sellers = [
            [
                'email'      => 'mobile@shop.com',
                'name'       => 'MobileHub Owner',
                'store'      => 'MobileHub',
                'desc'       => 'Smartphones, tablets, and mobile accessories from top brands worldwide.',
                'status'     => 'approved',
                'phone'      => '+44 20 7946 0101',
                'address'    => '45 King Street, London, UK',
                'rate'       => 10.00,
                'months_ago' => 5,
            ],
            [
                'email'      => 'gadgets@shop.com',
                'name'       => 'GadgetZone Owner',
                'store'      => 'GadgetZone',
                'desc'       => 'Smart home, wearables, and innovative tech gadgets.',
                'status'     => 'approved',
                'phone'      => '+65 6789 0123',
                'address'    => '10 Marina Boulevard, Singapore',
                'rate'       => 10.00,
                'months_ago' => 3,
            ],
            [
                'email'      => 'laptops@shop.com',
                'name'       => 'LaptopExpress Owner',
                'store'      => 'LaptopExpress',
                'desc'       => 'Laptops, desktops, and computing accessories. Business and gaming.',
                'status'     => 'pending',         // ← admin must review
                'phone'      => '+855 12 345 678',
                'address'    => 'Street 271, Phnom Penh, Cambodia',
                'rate'       => 10.00,
                'months_ago' => 0,
            ],
            [
                'email'      => 'rejected@shop.com',
                'name'       => 'AccessoryPro Owner',
                'store'      => 'AccessoryPro',
                'desc'       => 'Cables, chargers, and tech accessories.',
                'status'     => 'rejected',
                'admin_comment' => 'Insufficient business documentation. Please re-apply with a valid business license.',
                'phone'      => '+1 555 9999',
                'address'    => '999 Reject Lane, New York, NY',
                'rate'       => 10.00,
                'months_ago' => 1,
            ],
        ];

        foreach ($sellers as $s) {
            $user = User::updateOrCreate(
                ['email' => $s['email']],
                [
                    'name'           => $s['name'],
                    'password'       => Hash::make('password'),
                    'role'           => $s['status'] === 'approved' ? 'seller' : 'user',
                    'email_verified_at' => now(),
                ]
            );

            Seller::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'store_name'      => $s['store'],
                    'slug'            => Str::slug($s['store']),
                    'description'     => $s['desc'],
                    'status'          => $s['status'],
                    'admin_comment'   => $s['admin_comment'] ?? null,
                    'contact_email'   => $s['email'],
                    'phone'           => $s['phone'],
                    'address'         => $s['address'],
                    'commission_rate' => $s['rate'],
                    'ships_worldwide' => true,
                    'returns_days'    => 7,
                    'response_time'   => 'Within 48 hours',
                    'verified_at'     => $s['status'] === 'approved' ? now()->subMonths($s['months_ago']) : null,
                ]
            );

            $this->command->info("  ✓ Seller: {$s['email']} ({$s['store']}, {$s['status']})");
        }

        // ── DEMO CUSTOMER ────────────────────────────────────────────────────
        User::updateOrCreate(
            ['email' => 'customer@shop.com'],
            [
                'name'           => 'Demo Customer',
                'password'       => Hash::make('password'),
                'role'           => 'user',
                'email_verified_at' => now(),
            ]
        );
        $this->command->info("  ✓ Demo Customer: customer@shop.com / password");

        // ── OTHER CUSTOMERS (mixed countries) ───────────────────────────────
        $customers = [
            ['Sok Dara',     'sok.dara@gmail.com',     'Cambodia'],
            ['Chan Theary',  'chan.theary@gmail.com',  'Cambodia'],
            ['John Smith',   'john.smith@gmail.com',   'USA'],
            ['Emma Johnson', 'emma.johnson@gmail.com', 'USA'],
            ['Wei Chen',     'wei.chen@gmail.com',     'Singapore'],
            ['Sarah Wong',   'sarah.wong@gmail.com',   'Singapore'],
            ['Oliver Brown', 'oliver.brown@gmail.com', 'UK'],
            ['Mia Davis',    'mia.davis@gmail.com',    'UK'],
            ['Yuki Tanaka',  'yuki.tanaka@gmail.com',  'Japan'],
        ];

        foreach ($customers as [$name, $email, $country]) {
            User::updateOrCreate(
                ['email' => $email],
                [
                    'name'           => $name,
                    'password'       => Hash::make('password'),
                    'role'           => 'user',
                    'email_verified_at' => now()->subDays(rand(30, 365)),
                ]
            );
        }
        $this->command->info("  ✓ 9 additional customers (mixed countries)");

        $this->command->newLine();
        $this->command->info('═══════════════════════════════════════════════════');
        $this->command->info(' DEMO LOGINS (all use password: "password")');
        $this->command->info('═══════════════════════════════════════════════════');
        $this->command->info(' Admin:    admin@shop.com');
        $this->command->info(' Seller:   seller@shop.com  (TechWorld VIP)');
        $this->command->info(' Customer: customer@shop.com');
        $this->command->info('═══════════════════════════════════════════════════');
        $this->command->newLine();
    }
}

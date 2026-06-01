<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class DemoSettingSeeder extends Seeder
{
    /**
     * Seed the platform settings so that branding (logo, store name, bank
     * details, etc.) survive a `migrate:fresh`. Without this, the admin would
     * have to re-upload everything every time the DB is reset.
     */
    public function run(): void
    {
        $this->command->info('Setting platform defaults…');

        /*
         * Pick an existing logo from public/img/logo if any exist.
         * Path is stored relative to public/ so the nav-logo partial finds it.
         */
        $logoPath = $this->pickExistingLogo();

        $defaults = [
            'store_name'           => 'ShopExpress',
            'store_logo'           => $logoPath,
            'store_email'          => 'support@shopexpress.com',
            'store_phone'          => '+855 12 345 678',
            'store_address'        => 'Phnom Penh, Cambodia',
            'storefront_title'     => 'Welcome to ShopExpress',
            'welcome_message'      => 'Discover trusted products from verified sellers — fast shipping, secure checkout.',

            /* Bank details for the manual bank-transfer payment flow. */
            'bank_name'            => 'ABA Bank',
            'bank_account_name'    => 'ShopExpress Co Ltd',
            'bank_account_number'  => '000 123 456 789',
        ];

        foreach ($defaults as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        $this->command->info('  ✓ Platform settings configured');
        if ($logoPath) {
            $this->command->info("  ✓ Store logo: {$logoPath}");
        }
    }

    /**
     * Find a usable logo file in public/img/logo/ — picks the first one alphabetically.
     */
    protected function pickExistingLogo(): ?string
    {
        $logoDir = public_path('img/logo');
        if (!is_dir($logoDir)) return null;

        $files = glob($logoDir . '/*.{png,jpg,jpeg,svg,webp}', GLOB_BRACE);
        if (empty($files)) return null;

        sort($files);
        return 'img/logo/' . basename($files[0]);
    }
}

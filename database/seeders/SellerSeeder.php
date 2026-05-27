<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Seller;
use Illuminate\Support\Facades\Storage;

class SellerSeeder extends Seeder
{
    public function run(): void
{
    $phonePrefixes = ['012', '013', '014', '015', '016', '017', '018', '098', '099', '010'];
    $storeLogos   = json_decode(file_get_contents(storage_path('app/store_logos.json')), true);
    $storeBanners = json_decode(file_get_contents(storage_path('app/store_banners.json')), true);

    if (
        !$storeLogos || !is_array($storeLogos) || count($storeLogos) === 0 ||
        !$storeBanners || !is_array($storeBanners) || count($storeBanners) === 0
    ) {
        $this->command->error(
            "store_logos.json or store_banners.json is missing or invalid. Please ensure both files exist in storage/app/ and each contains a valid JSON array of at least one image URL."
        );
        return;
    }

        for ($i = 1; $i <= 10; $i++) {
            $email = "seller$i@shopexpress.com";
            $phone = $phonePrefixes[array_rand($phonePrefixes)] . ' ' . rand(100, 999) . ' ' . str_pad($i, 4, '0', STR_PAD_LEFT);

            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => "Seller $i",
                    'password' => bcrypt("password$i"),
                    'role' => 'user',
                    'email_verified_at' => now(),
                ]
            );

            $logoPath = $storeLogos[array_rand($storeLogos)];
            $bannerPath = $storeBanners[array_rand($storeBanners)];

            Seller::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'store_name'        => "Demo Store $i",
                    'slug'              => "demo-store-$i",
                    'description'       => "Welcome to Demo Store $i. We offer awesome products in various categories.",
                    'business_document' => "business_doc_$i.pdf",
                    'status'            => 'approved',
                    'admin_comment'     => "Verified demo seller #$i",
                    'store_logo'        => $logoPath,
                    'store_banner'      => $bannerPath,
                    'contact_email'     => $email,
                    'address'           => "123 Demo Road, City $i",
                    'phone'             => $phone,
                    'website'           => "https://store$i.demo.com",
                    'facebook'          => "https://facebook.com/demo.store$i",
                    'instagram'         => "https://instagram.com/demo.store$i",
                    'tiktok'            => "https://tiktok.com/@demo.store$i",
                    'ships_worldwide'   => true,
                    'returns_days'      => rand(7, 30),
                    'shipping_summary'  => "We ship worldwide in 2-6 days from Store $i.",
                    'response_time'     => rand(1, 24) . " hours",
                    'verified_at'       => now(),
                ]
            );
        }
    }
}
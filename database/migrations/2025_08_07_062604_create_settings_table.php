<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('settings', function (Blueprint $table) {
        $table->id();
        $table->string('key')->unique();
        $table->text('value')->nullable();
        $table->timestamps();
    });

    // Added the missing keys here
    DB::table('settings')->insert([
        ['key' => 'store_name',        'value' => 'ShopExpress'],
        ['key' => 'store_email',       'value' => 'admin@shopexpress.com'],
        ['key' => 'store_phone',       'value' => null], // Missing before
        ['key' => 'store_address',     'value' => null],
        ['key' => 'store_logo',        'value' => null], // Missing before
        ['key' => 'support_email',     'value' => null], // Missing before
        ['key' => 'support_phone',     'value' => null], // Missing before
        ['key' => 'default_currency',  'value' => 'USD'],
        ['key' => 'storefront_title',  'value' => 'Welcome to ShopExpress'],
        ['key' => 'welcome_message',   'value' => null],
        ['key' => 'payment_gateway',   'value' => 'none'],
        ['key' => 'api_key',           'value' => null],
        ['key' => 'free_shipping',     'value' => '0'],
        ['key' => 'shipping_threshold','value' => null],
        ['key' => 'shipping_policy',   'value' => null],
    ]);
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
}

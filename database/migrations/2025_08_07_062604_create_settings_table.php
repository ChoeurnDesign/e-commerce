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

        // Optionally: Seed initial keys as empty/default
        DB::table('settings')->insert([
            ['key' => 'store_name',           'value' => null],
            ['key' => 'store_email',          'value' => null],
            ['key' => 'store_address',        'value' => null],
            ['key' => 'default_currency',     'value' => 'USD'],
            ['key' => 'storefront_title',     'value' => null],
            ['key' => 'welcome_message',      'value' => null],
            ['key' => 'payment_gateway',      'value' => 'none'],
            ['key' => 'api_key',              'value' => null],
            ['key' => 'free_shipping',        'value' => '0'],
            ['key' => 'shipping_threshold',   'value' => null],
            ['key' => 'shipping_policy',      'value' => null],
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

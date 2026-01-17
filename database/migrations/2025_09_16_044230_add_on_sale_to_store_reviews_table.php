<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('store_reviews', function (Blueprint $table) {
            // Adding the 'on_sale' column without the 'after' clause
            $table->boolean('on_sale')->default(false)->comment('Indicates if the product is on sale');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('store_reviews', function (Blueprint $table) {
            $table->dropColumn('on_sale');
        });
    }
};
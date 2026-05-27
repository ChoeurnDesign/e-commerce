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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('seller_id');   // multi-vendor
            $table->unsignedBigInteger('product_id');

            $table->string('product_name'); // store name at time of order
            $table->string('product_sku')->nullable();
            $table->string('product_image')->nullable(); // ✅ ADD THIS

            $table->integer('quantity');
            $table->decimal('price', 10, 2); // price at time of order
            $table->decimal('total', 10, 2); // quantity * price

            $table->timestamps();

            // Foreign keys
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('seller_id')->references('id')->on('sellers')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

            // Indexes
            $table->index(['order_id', 'product_id']);
            $table->index(['order_id', 'seller_id']);
            $table->index('seller_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
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
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            // Relationships
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreignId('seller_id')->constrained()->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');

            // Product details
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->text('short_description')->nullable();

            // Pricing
            $table->decimal('price', 10, 2);
            $table->decimal('compare_price', 10, 2)->nullable();
            $table->decimal('sale_price', 10, 2)->nullable();
            $table->boolean('on_sale')->default(false)->comment('Indicates if the product is on sale');

            // Inventory
            $table->integer('stock_quantity')->default(0);
            $table->unsignedBigInteger('page_views')->default(0);

            // SKU & Media
            $table->string('sku')->unique();
            $table->string('image')->nullable();
            $table->json('gallery')->nullable();
            $table->json('images')->nullable();

            // Specifications, flags, meta
            $table->json('specifications')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
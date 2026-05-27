<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vendor_orders', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('seller_id');

            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('commission_rate', 5, 2)->default(10.00);
            $table->decimal('commission_amount', 10, 2)->default(0);
            $table->decimal('seller_earnings', 10, 2)->default(0);

            $table->enum('status', ['pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled', 'completed'])->default('pending');
            $table->enum('payout_status', ['pending', 'available', 'paid'])->default('pending');
            
            $table->string('stripe_account_id')->nullable();
            $table->string('stripe_transfer_id')->nullable();
            $table->timestamp('paid_out_at')->nullable();

            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('seller_id')->references('id')->on('sellers')->onDelete('cascade');

            $table->unique(['order_id', 'seller_id']);
            $table->index(['seller_id', 'status']);
            $table->index(['seller_id', 'payout_status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vendor_orders');
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Single-row wallet for the platform
        Schema::create('platform_wallet', function (Blueprint $table) {
            $table->id();
            $table->decimal('balance', 15, 2)->default(0.00);           // Current available balance
            $table->decimal('total_revenue', 15, 2)->default(0.00);     // All-time order revenue received
            $table->decimal('total_commission', 15, 2)->default(0.00);  // All-time commission kept
            $table->decimal('total_paid_out', 15, 2)->default(0.00);    // All-time paid out to sellers
            $table->timestamps();
        });

        // Transaction ledger — every money movement
        Schema::create('platform_transactions', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['order_received', 'seller_payout', 'commission_earned', 'refund']);
            $table->decimal('amount', 15, 2);
            $table->decimal('balance_after', 15, 2);
            $table->string('description')->nullable();
            $table->foreignId('order_id')->nullable()->constrained()->nullOnDelete();
            $table->unsignedBigInteger('seller_id')->nullable();
            $table->unsignedBigInteger('payout_request_id')->nullable();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('platform_transactions');
        Schema::dropIfExists('platform_wallet');
    }
};

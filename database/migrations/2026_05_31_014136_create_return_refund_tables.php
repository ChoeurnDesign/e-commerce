<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ── RETURN REQUESTS ─────────────────────────────────────────────────
        // Customer's request to return part or all of an order from a single seller
        Schema::create('return_requests', function (Blueprint $table) {
            $table->id();
            $table->string('reference', 40)->unique();          // e.g. RTN-20260531-A8K2L
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('vendor_order_id')->constrained()->cascadeOnDelete(); // Per-seller scope
            $table->foreignId('user_id')->constrained();         // Customer who requested
            $table->foreignId('seller_id')->constrained();       // Seller affected

            // Reason
            $table->enum('reason_code', [
                'damaged',
                'wrong_item',
                'not_as_described',
                'defective',
                'changed_mind',
                'never_received',
                'other',
            ]);
            $table->text('reason_description')->nullable();

            // Refund preference
            $table->enum('refund_method', ['original_payment', 'store_credit'])->default('original_payment');
            $table->decimal('refund_amount', 10, 2)->default(0);  // Calculated from items
            $table->boolean('return_items_required')->default(true); // false = "keep the item" refund

            // Lifecycle status
            $table->enum('status', [
                'pending_seller_review',  // Just submitted
                'approved',                // Seller accepted
                'rejected',                // Seller declined
                'in_transit',              // Customer shipped items back
                'received',                // Seller confirmed receipt
                'refunded',                // Money returned
                'completed',               // Closed
                'disputed',                // Customer escalated
                'cancelled',               // Customer withdrew
            ])->default('pending_seller_review');

            // Seller response
            $table->text('seller_response')->nullable();
            $table->timestamp('seller_responded_at')->nullable();

            // Admin mediation (for disputes)
            $table->foreignId('admin_id')->nullable();
            $table->text('admin_notes')->nullable();
            $table->timestamp('resolved_at')->nullable();

            // Return shipping
            $table->string('return_tracking_number', 100)->nullable();
            $table->string('return_carrier', 50)->nullable();

            // Refund processing
            $table->string('refund_transaction_id', 100)->nullable(); // Stripe refund id
            $table->timestamp('refund_processed_at')->nullable();

            $table->timestamps();

            $table->index(['status', 'created_at']);
            $table->index(['seller_id', 'status']);
            $table->index(['user_id', 'status']);
        });

        // ── RETURN REQUEST ITEMS ────────────────────────────────────────────
        // Which order items are being returned (supports partial returns)
        Schema::create('return_request_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('return_request_id')->constrained()->cascadeOnDelete();
            $table->foreignId('order_item_id')->constrained();
            $table->integer('quantity');                          // Quantity being returned
            $table->decimal('unit_refund', 10, 2);                // Refund per unit
            $table->decimal('line_refund', 10, 2);                // quantity × unit_refund
            $table->timestamps();

            $table->unique(['return_request_id', 'order_item_id']);
        });

        // ── RETURN ATTACHMENTS ──────────────────────────────────────────────
        // Photos/documents customer uploads as proof
        Schema::create('return_request_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('return_request_id')->constrained()->cascadeOnDelete();
            $table->string('path');
            $table->string('original_name')->nullable();
            $table->enum('type', ['photo', 'document'])->default('photo');
            $table->timestamps();
        });

        // ── REFUNDS (separate audit table) ──────────────────────────────────
        // Every refund is recorded here for financial audit trail
        Schema::create('refunds', function (Blueprint $table) {
            $table->id();
            $table->string('reference', 40)->unique();            // e.g. REF-20260531-X9P3M
            $table->foreignId('order_id')->constrained();
            $table->foreignId('return_request_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('amount', 10, 2);
            $table->string('payment_method', 30);                 // credit_card, paypal, cod, bank_transfer
            $table->enum('refund_type', ['original_payment', 'store_credit', 'bank_transfer'])->default('original_payment');
            $table->enum('status', ['pending', 'processing', 'completed', 'failed'])->default('pending');
            $table->string('gateway_refund_id', 100)->nullable(); // Stripe/PayPal refund id
            $table->text('failure_reason')->nullable();
            $table->foreignId('processed_by')->nullable();        // admin user id
            $table->timestamp('processed_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['status', 'created_at']);
        });

        // ── ORDER WALLET (store credit) ────────────────────────────────────
        // If customer chose "store credit" refund, balance is held here
        Schema::create('customer_wallets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->decimal('balance', 10, 2)->default(0);
            $table->decimal('lifetime_credit', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_wallets');
        Schema::dropIfExists('refunds');
        Schema::dropIfExists('return_request_attachments');
        Schema::dropIfExists('return_request_items');
        Schema::dropIfExists('return_requests');
    }
};

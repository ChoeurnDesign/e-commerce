<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        /* Extend payment_method enum-like string column to support bank_transfer.
           (column is already a generic string, no schema change needed.) */

        Schema::table('orders', function (Blueprint $table) {
            // Receipt screenshot uploaded by the customer after bank transfer.
            $table->string('payment_proof')->nullable()->after('payment_method');
            // Reference number / note (customer can type the bank transaction ref).
            $table->string('payment_reference')->nullable()->after('payment_proof');
            // Admin who verified the payment.
            $table->unsignedBigInteger('payment_verified_by')->nullable()->after('payment_reference');
            // Timestamp when admin verified the payment.
            $table->timestamp('payment_verified_at')->nullable()->after('payment_verified_by');
            // Optional admin note on verification (e.g. rejection reason).
            $table->text('payment_verification_note')->nullable()->after('payment_verified_at');
        });

        /* Extend payment_status enum to allow awaiting_verification. */
        // Drop and recreate the enum to add the new value safely (MySQL workaround).
        if (Schema::hasColumn('orders', 'payment_status')) {
            DB::statement("ALTER TABLE orders MODIFY COLUMN payment_status ENUM(
                'pending', 'awaiting_verification', 'paid', 'failed', 'refunded'
            ) NOT NULL DEFAULT 'pending'");
        }
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'payment_proof',
                'payment_reference',
                'payment_verified_by',
                'payment_verified_at',
                'payment_verification_note',
            ]);
        });

        if (Schema::hasColumn('orders', 'payment_status')) {
            DB::statement("ALTER TABLE orders MODIFY COLUMN payment_status ENUM(
                'pending', 'paid', 'failed', 'refunded'
            ) NOT NULL DEFAULT 'pending'");
        }
    }
};

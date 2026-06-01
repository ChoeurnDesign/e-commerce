<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ── SELLERS: per-seller commission rate + promo period ──────────────
        Schema::table('sellers', function (Blueprint $table) {
            $table->decimal('commission_rate', 5, 2)->default(10.00)->after('verified_at')
                ->comment('Default commission % for this seller. Overrides platform default but is overridden by category.');
            $table->date('promo_until')->nullable()->after('commission_rate')
                ->comment('If set and in the future, seller pays 0% commission until this date.');
        });

        // ── CATEGORIES: per-category commission override ─────────────────────
        Schema::table('categories', function (Blueprint $table) {
            $table->decimal('commission_rate', 5, 2)->nullable()->after('sort_order')
                ->comment('Commission % for products in this category. NULL = inherit from seller/platform.');
        });

        // ── COUPONS: who funds the discount ──────────────────────────────────
        Schema::table('coupons', function (Blueprint $table) {
            $table->enum('funded_by', ['platform', 'seller'])->default('platform')->after('discount_value')
                ->comment('platform = platform absorbs discount, seller = seller absorbs discount.');
        });

        // ── VENDOR ORDERS: audit trail of how commission was calculated ──────
        Schema::table('vendor_orders', function (Blueprint $table) {
            $table->decimal('discount_allocated', 10, 2)->default(0)->after('subtotal')
                ->comment('Portion of order discount allocated to this vendor (if seller-funded coupon).');
            $table->string('commission_source', 20)->default('default')->after('commission_rate')
                ->comment('Where commission rate came from: category, seller, default, or promo.');
            $table->decimal('payment_fee', 10, 2)->default(0)->after('commission_amount')
                ->comment('Payment processing fee allocated to this vendor order (eats into platform commission).');
        });

        // ── ORDERS: track total payment processing fee ───────────────────────
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('payment_fee_amount', 10, 2)->default(0)->after('total_price')
                ->comment('Payment gateway fee (Stripe/PayPal). Deducted from platform commission.');
        });

        // ── PLATFORM WALLET: track payment fees ──────────────────────────────
        Schema::table('platform_wallet', function (Blueprint $table) {
            $table->decimal('total_payment_fees', 15, 2)->default(0)->after('total_paid_out')
                ->comment('All-time payment gateway fees paid (Stripe/PayPal).');
        });

        // ── PLATFORM TRANSACTIONS: add payment_fee type ──────────────────────
        // (enum modification done via raw SQL since Schema can't alter enums)
        DB::statement("ALTER TABLE platform_transactions MODIFY COLUMN type ENUM('order_received', 'seller_payout', 'commission_earned', 'refund', 'payment_fee') NOT NULL");
    }

    public function down(): void
    {
        Schema::table('sellers', function (Blueprint $table) {
            $table->dropColumn(['commission_rate', 'promo_until']);
        });
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('commission_rate');
        });
        Schema::table('coupons', function (Blueprint $table) {
            $table->dropColumn('funded_by');
        });
        Schema::table('vendor_orders', function (Blueprint $table) {
            $table->dropColumn(['discount_allocated', 'commission_source', 'payment_fee']);
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('payment_fee_amount');
        });
        Schema::table('platform_wallet', function (Blueprint $table) {
            $table->dropColumn('total_payment_fees');
        });
        DB::statement("ALTER TABLE platform_transactions MODIFY COLUMN type ENUM('order_received', 'seller_payout', 'commission_earned', 'refund') NOT NULL");
    }
};

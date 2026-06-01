<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('coupons', function (Blueprint $table) {
            $table->enum('discount_type', ['percentage', 'fixed'])->default('percentage')->after('code');
            $table->decimal('discount_value', 10, 2)->default(0)->after('discount_type');
            $table->decimal('min_order_amount', 10, 2)->default(0)->after('discount_value');
            $table->unsignedInteger('max_uses')->nullable()->after('min_order_amount');
            $table->unsignedInteger('used_count')->default(0)->after('max_uses');
            $table->boolean('is_active')->default(true)->after('used_count');
        });
    }

    public function down(): void
    {
        Schema::table('coupons', function (Blueprint $table) {
            $table->dropColumn(['discount_type', 'discount_value', 'min_order_amount', 'max_uses', 'used_count', 'is_active']);
        });
    }
};

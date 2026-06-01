<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * The original coupons migration created a legacy `discount` (string)
 * column. A later migration added `discount_type` + `discount_value` —
 * the modern fields actually used by the app. The old `discount` column
 * still exists as NOT NULL, breaking the seeder.
 *
 * Fix: make it nullable so legacy code (and the seeder) can ignore it.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('coupons', 'discount')) {
            DB::statement("ALTER TABLE coupons MODIFY COLUMN discount VARCHAR(255) NULL");
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('coupons', 'discount')) {
            DB::statement("ALTER TABLE coupons MODIFY COLUMN discount VARCHAR(255) NOT NULL");
        }
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1) Create pivot table to store follower relations
        Schema::create('seller_followers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->constrained('sellers')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['seller_id', 'user_id']);
            $table->index('user_id');
        });

        // 2) Add denormalized counter on sellers (optional, will only add if sellers table exists)
        if (Schema::hasTable('sellers')) {
            Schema::table('sellers', function (Blueprint $table) {
                if (! Schema::hasColumn('sellers', 'followers_count')) {
                    // adjust 'after' column if your sellers table doesn't have products_count
                    if (Schema::hasColumn('sellers', 'products_count')) {
                        $table->unsignedBigInteger('followers_count')->default(0)->after('products_count');
                    } else {
                        $table->unsignedBigInteger('followers_count')->default(0);
                    }
                }
            });
        }
    }

    public function down(): void
    {
        // Remove denormalized column first (if exists)
        if (Schema::hasTable('sellers')) {
            Schema::table('sellers', function (Blueprint $table) {
                if (Schema::hasColumn('sellers', 'followers_count')) {
                    $table->dropColumn('followers_count');
                }
            });
        }

        // Then drop pivot table
        Schema::dropIfExists('seller_followers');
    }
};
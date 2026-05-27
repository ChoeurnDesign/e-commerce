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
        Schema::table('vendor_orders', function (Blueprint $table) {
            // This changes the 'status' column to a string so it can accept 'completed' 
            // and any other future status names without crashing.
            $table->string('status')->default('pending')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vendor_orders', function (Blueprint $table) {
            // Optional: Rollback to a limited set if needed
            $table->enum('status', ['pending', 'processing', 'shipped'])->default('pending')->change();
        });
    }
};
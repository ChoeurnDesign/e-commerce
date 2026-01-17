<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

return new class extends Migration
{
    public function up(): void
    {
        // Set email_verified_at to now() where it is null (for existing users)
        DB::table('users')->whereNull('email_verified_at')->update([
            'email_verified_at' => Carbon::now(),
        ]);
    }

    public function down(): void
    {
        // Optional: If you ever want to revert, you could set all email_verified_at to null
        // DB::table('users')->update(['email_verified_at' => null]);
    }
};
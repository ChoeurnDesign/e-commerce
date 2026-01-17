<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddContactEmailAndAddressToSellersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sellers', function (Blueprint $table) {
            // Add columns (nullable). Adjust ->after(...) if your DB driver supports it and the column exists.
            $table->string('contact_email')->nullable()->after('description');
            $table->string('address')->nullable()->after('contact_email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sellers', function (Blueprint $table) {
            if (Schema::hasColumn('sellers', 'contact_email')) {
                $table->dropColumn('contact_email');
            }
            if (Schema::hasColumn('sellers', 'address')) {
                $table->dropColumn('address');
            }
        });
    }
}
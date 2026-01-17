<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStoreBannerToSellersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * Adds a nullable store_banner column to store the banner file path.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sellers', function (Blueprint $table) {
            // Adjust the column name if you prefer banner_path or store_banner_path
            if (!Schema::hasColumn('sellers', 'store_banner')) {
                $table->string('store_banner')->nullable()->comment('Path to store banner image (public disk)');
            }
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
            if (Schema::hasColumn('sellers', 'store_banner')) {
                $table->dropColumn('store_banner');
            }
        });
    }
}
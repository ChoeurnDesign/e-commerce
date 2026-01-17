<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddContactFieldsToSellersTable extends Migration
{
    public function up()
    {
        Schema::table('sellers', function (Blueprint $table) {
            // $table->string('contact_email')->nullable()->after('store_banner');
            $table->string('phone')->nullable()->after('contact_email');
            $table->string('website')->nullable()->after('phone');
            $table->string('facebook')->nullable()->after('website');
            $table->string('instagram')->nullable()->after('facebook');
            $table->string('tiktok')->nullable()->after('instagram');
            $table->boolean('ships_worldwide')->nullable()->after('tiktok');
            $table->unsignedSmallInteger('returns_days')->nullable()->after('ships_worldwide');
            $table->string('shipping_summary')->nullable()->after('returns_days');
            $table->string('response_time')->nullable()->after('shipping_summary');
            $table->timestamp('verified_at')->nullable()->after('response_time');
        });
    }

    public function down()
    {
        Schema::table('sellers', function (Blueprint $table) {
            $table->dropColumn([
                'contact_email','phone','website','facebook','instagram','tiktok',
                'ships_worldwide','returns_days','shipping_summary','response_time','verified_at'
            ]);
        });
    }
}
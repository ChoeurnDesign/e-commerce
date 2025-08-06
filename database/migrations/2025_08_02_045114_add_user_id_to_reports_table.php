<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('reports', function (Blueprint $table) {
        $table->unsignedBigInteger('user_id')->nullable()->after('description');
        // Add foreign key if you want
        // $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
    });
}

public function down()
{
    Schema::table('reports', function (Blueprint $table) {
        // Drop foreign key if added
        // $table->dropForeign(['user_id']);
        $table->dropColumn('user_id');
    });
}

};

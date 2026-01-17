<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImagesTable extends Migration
{
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->string('path'); // storage path
            $table->unsignedBigInteger('user_id')->index(); // uploader (admin/seller)
            $table->unsignedBigInteger('product_id')->nullable()->index(); // related product if any
            $table->string('alt')->nullable();
            $table->string('type')->nullable(); // 'main', 'gallery', etc
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('images');
    }
}
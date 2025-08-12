<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserReportsTable extends Migration
{
    public function up()
    {
        Schema::create('user_reports', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('status')->default('open');
            $table->boolean('is_read')->default(false);
            $table->text('images')->nullable(); // store as JSON/text
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_reports');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestaurantsTable extends Migration
{
    public function up()
    {
        Schema::create('restaurants', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('photo')->nullable();
            $table->integer('priority');
            $table->string('background_image')->nullable();
            $table->string('map_image')->nullable();
            $table->string('map_link')->nullable();
            $table->string('address');
            $table->text('description');
            $table->longText('privacy')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('restaurants');
    }
}

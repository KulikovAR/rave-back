<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceSchedulesTable extends Migration
{
    public function up()
    {
        Schema::create('service_schedules', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('day_of_week');
            $table->boolean('is_open')->default(true);
            $table->time('opening_time')->nullable();
            $table->time('closing_time')->nullable();
            $table->uuid('restaurant_id');
            $table->timestamps();

            $table->unique(['restaurant_id', 'day_of_week']);
            $table->foreign('restaurant_id')->references('id')->on('restaurants')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('service_schedules');
    }
}

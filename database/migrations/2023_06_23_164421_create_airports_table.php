<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('airports', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
			$table->string('city_en')->nullable();
            $table->string('city_code')->nullable();
            $table->string('name')->nullable();
            $table->string('name_en')->nullable();
            $table->string('main_airport_name')->nullable();
            $table->enum('type', ['city', 'airport']);
            $table->integer('weight')->nullable();
            $table->string('cases')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('airports');
    }
};
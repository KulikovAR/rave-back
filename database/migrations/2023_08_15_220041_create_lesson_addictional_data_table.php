<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lesson_addictional_data', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('file');
            $table->uuid('lesson_id');
            $table->foreign('lesson_id')
                ->references('id')
                ->on('lessons');
            $table->timestamps();
            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lesson_addictional_data');
    }
};

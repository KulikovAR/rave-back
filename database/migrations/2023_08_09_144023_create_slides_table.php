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
        Schema::create('slides', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('short_id');
            $table->foreign('short_id')
                ->references('id')
                ->on('shorts')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->string('image');
            $table->string('video_path')->nullable();
            $table->timestamps();
            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('slides');
    }
};

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
        Schema::create('lesson_tag', function (Blueprint $table) {
            $table->id();

            $table->uuid('lesson_id');
            $table->foreign('lesson_id')
                ->references('id')
                ->on('lessons');

            $table->uuid('tag_id');
            $table->foreign('tag_id')
                ->references('id')
                ->on('tags');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lesson_tag');
    }
};

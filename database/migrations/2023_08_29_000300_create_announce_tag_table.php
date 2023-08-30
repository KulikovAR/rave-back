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
        Schema::create('announce_tag', function (Blueprint $table) {
            $table->id();

            $table->uuid('announce_id');
            $table->foreign('announce_id')
                ->references('id')
                ->on('announces')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->uuid('tag_id');
            $table->foreign('tag_id')
                ->references('id')
                ->on('tags')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('announce_tag');
    }
};

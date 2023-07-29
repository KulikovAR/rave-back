<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('confirm_codes', function (Blueprint $table) {
            $table->id();
            $table->char('verification_code_phone', 6)->nullable();
            $table->char('verification_code_email', 6)->nullable();

            $table->char('recovery_code_phone', 6)->nullable();
            $table->char('recovery_code_email', 6)->nullable();

            $table->string('two_factor_type', 50)->default('email');
            $table->string('two_factor_code', 4)->nullable();
            $table->dateTime('two_factor_expires_at')->nullable();
            $table->dateTime('two_factor_enabled_at')->nullable();
            $table->tinyInteger('two_factor_enabled')->nullable();
            $table->tinyInteger('two_factor_confirmation')->nullable();

            $table->uuid('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('confirm_codes');
    }
};

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
        Schema::create('banks', function (Blueprint $table) {
            $table->uuid('id');

            $table->string('org_inn');
            $table->string('org_kpp');
            $table->string('org_ogrn');
            $table->string('org_name');
            $table->string('org_address');
            $table->string('org_location')->nullable();

            $table->string('contact_fio');
            $table->string('contact_job')->nullable();
            $table->string('contact_email');
            $table->string('contact_tel')->nullable();

            $table->string('bank_bik');
            $table->string('bank_user_account');
            $table->string('bank_account');
            $table->string('bank_name');

            $table->uuid('user_id');
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->timestamps();

            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banks');
    }
};

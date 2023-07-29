<?php

use App\Models\UserProfile;
use App\Services\MigrationService;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends MigrationService {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $this->registerDoctrineEnumType();

        Schema::create('user_profiles', function (Blueprint $table) {
            $table->uuid('id');
            $table->text('firstname');
            $table->text('lastname');
            $table->string('patronymic')->nullable();
            $table->string('country');
            $table->enum('gender', [UserProfile::MALE, UserProfile::FEMALE]);
            $table->text('document_number');
            $table->text('document_expires')->nullable();
            $table->text('birthday');
            $table->char('phone_prefix', 10);
            $table->text('phone');

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
        Schema::dropIfExists('user_profiles');
    }
};

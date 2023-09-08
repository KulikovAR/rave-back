<?php

use App\Models\TakeOut;
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

        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('name')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->char('salt', 60)->nullable();
            $table->string('password')->nullable();
            $table->char('language', 2)->nullable();
            $table->boolean('is_blocked')->default(false);
            $table->timestamp('subscription_expires_at')->nullable();
            $table->timestamp('subscription_created_at')->nullable();
            $table->string('subscription_type')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->rememberToken();

            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['credential_id']);
        });

        Schema::dropIfExists('users');
    }
};

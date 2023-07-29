<?php

use App\Enums\PassengerTypeEnum;
use App\Models\UserProfile;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_passengers', function (Blueprint $table) {
            $table->uuid('id');
            $table->text('firstname');
            $table->text('lastname');
            $table->string('patronymic')->nullable();
            $table->string('country');
            $table->enum('gender', [UserProfile::MALE, UserProfile::FEMALE]);
            $table->enum('type', [PassengerTypeEnum::ADULT->value, PassengerTypeEnum::CHILD->value, PassengerTypeEnum::INFANT->value])->default(PassengerTypeEnum::ADULT->value);
            $table->text('document_number');
            $table->text('document_expires')->nullable();
            $table->text('birthday');

            $table->uuid('order_id');
            $table->foreign('order_id')
                  ->references('id')
                  ->on('orders')
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
        Schema::dropIfExists('passengers');
    }
};

<?php

use App\Models\Order;
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

        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('user_id')->nullable();

            $table->string('email');
            $table->char('phone_prefix', 10)->nullable();
            $table->string('phone')->nullable();

            $table->integer('price');

            $table->uuid('promocode_id')->nullable();
            $table->string('promo_code')->nullable();
            $table->integer('commission')->nullable();
            $table->integer('discount')->nullable();

            $table->enum('order_type', [Order::TYPE_NORMAL, Order::TYPE_VIP])->default(Order::TYPE_NORMAL);
            $table->string('order_number');
            $table->dateTime('order_start_booking');
            $table->enum('order_status', [Order::CREATED, Order::PAYED, Order::PROCESSING, Order::FINISHED, Order::CANCELED])->default(Order::CREATED);

            $table->json('trip_to');
            $table->json('trip_back')->nullable();
            $table->string('comment')->nullable();

            $table->string('hotel_city')->nullable();
            $table->dateTime('hotel_check_in')->nullable();
            $table->dateTime('hotel_check_out')->nullable();
            $table->string('hotel_booking_id')->nullable();

            $table->string('payment_id')->nullable();

            $table->text('reservation_to_token')->nullable();
            $table->text('reservation_from_token')->nullable();

            $table->string('flight_to_booking_id')->nullable();
            $table->string('flight_from_booking_id')->nullable();


            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null')
                  ->onUpdate('cascade');

            $table->foreign('promocode_id')
                  ->references('id')
                  ->on('promocodes')
                  ->onDelete('set null')
                  ->onUpdate('cascade');

            $table->uuid('manager_id')->nullable();
            $table->foreign('manager_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null')
                  ->onUpdate('cascade');

            $table->softDeletes();
            $table->timestamps();

            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

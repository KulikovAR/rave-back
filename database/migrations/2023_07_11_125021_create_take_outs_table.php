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

        Schema::create('take_outs', function (Blueprint $table) {
            $table->uuid('id');

            $table->integer('amount');
            $table->integer('amount_left')->nullable();
            $table->enum('status', [Order::CREATED, Order::PAYED, Order::PROCESSING, Order::FINISHED, Order::CANCELED])->default(Order::CREATED);

            $table->uuid('takeoutable_id');
            $table->string('takeoutable_type');

            $table->uuid('user_id');
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade')
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
        Schema::dropIfExists('take_outs');
    }
};

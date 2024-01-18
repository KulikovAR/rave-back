<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('card')->nullable();
            $table->string('card_id_tinkoff')->nullable();
            $table->string('status')->nullable();
            $table->string('err_code')->nullable();
            $table->string('token')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('card');
            $table->dropColumn('card_id_tinkoff');
            $table->dropColumn('status');
            $table->dropColumn('err_code');
            $table->dropColumn('token');
        });
    }
};

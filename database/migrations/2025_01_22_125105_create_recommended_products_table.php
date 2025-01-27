<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecommendedProductsTable extends Migration
{
    public function up()
    {
        Schema::create('recommended_products', function (Blueprint $table) {
            $table->uuid('product_id');
            $table->uuid('recommended_product_id');
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products')->cascadeOnDelete();
            $table->foreign('recommended_product_id')->references('id')->on('products')->cascadeOnDelete();

            $table->primary(['product_id', 'recommended_product_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('recommended_products');
    }
}
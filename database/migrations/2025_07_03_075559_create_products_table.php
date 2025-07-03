<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('category');
            $table->decimal('price', 10, 2);
            $table->string('brand');
            $table->integer('stock');
            $table->timestamps();

            // You can add more columns as needed
            $table->decimal('discount_percentage', 5, 2)->nullable();
            $table->decimal('rating', 3, 2)->nullable();
            $table->json('tags')->nullable();
            $table->string('sku')->unique()->nullable();
            $table->decimal('weight', 8, 2)->nullable();
            $table->json('dimensions')->nullable();
            $table->string('warranty_information')->nullable();
            $table->string('shipping_information')->nullable();
            $table->string('availability_status')->nullable();
            $table->json('reviews')->nullable();
            $table->string('return_policy')->nullable();
            $table->integer('minimum_order_quantity')->nullable();
            $table->json('meta')->nullable();
            $table->json('images')->nullable();
            $table->string('thumbnail')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
};

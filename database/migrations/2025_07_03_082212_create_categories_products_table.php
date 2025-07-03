<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('categories_products', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('url');
            $table->text('description')->nullable();
            $table->decimal('price', 8, 2);
            $table->decimal('discount_percentage', 5, 2)->nullable();
            $table->decimal('rating', 3, 2)->nullable();
            $table->integer('stock')->default(0);
            $table->string('brand')->nullable();
            $table->string('category')->default('beauty');
            $table->string('thumbnail')->nullable();
            $table->json('images')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('beauty_products');
    }
};

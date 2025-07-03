<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('address');
            $table->string('city');
            $table->string('state');
            $table->string('state_code');
            $table->string('postal_code');
            $table->string('country');
            $table->timestamps();
        });

        Schema::create('address_coordinates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('address_id')->constrained()->onDelete('cascade');
            $table->decimal('lat', 10, 6);
            $table->decimal('lng', 10, 6);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('address_coordinates');
        Schema::dropIfExists('addresses');
    }
};

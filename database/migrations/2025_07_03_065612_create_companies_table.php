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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('department');
            $table->string('name');
            $table->string('title');
            $table->timestamps();
        });

        Schema::create('company_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->string('address');
            $table->string('city');
            $table->string('state');
            $table->string('state_code');
            $table->string('postal_code');
            $table->string('country');
            $table->timestamps();
        });

        Schema::create('company_coordinates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_address_id')->constrained('company_addresses')->onDelete('cascade');
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
        Schema::dropIfExists('company_coordinates');
        Schema::dropIfExists('company_addresses');
        Schema::dropIfExists('companies');
    }
};

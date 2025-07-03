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
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->string('first_name');
            $table->string('last_name');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('maiden_name')->nullable();
            $table->integer('age');
            $table->enum('gender', ['male', 'female', 'other']);
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('username')->unique();
            $table->string('password');
            $table->date('birth_date');
            $table->string('image');
            $table->string('blood_group');
            $table->decimal('height', 8, 2);
            $table->decimal('weight', 8, 2);
            $table->string('eye_color');
            $table->string('ip');
            $table->string('mac_address');
            $table->string('university');
            $table->string('ein')->nullable();
            $table->string('ssn')->nullable();
            $table->text('user_agent');
            $table->enum('role', ['admin', 'moderator', 'user'])->default('user');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};

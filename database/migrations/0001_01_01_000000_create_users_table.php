<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('google_id', 255)->unique()->nullable();
            $table->string('name', 255);
            $table->string('email', 255)->unique();
            $table->string('phone', 255)->nullable();
            $table->text('address')->nullable();
            $table->string('city', 255)->nullable();
            $table->string('province', 255)->nullable();
            $table->string('postal_code', 255)->nullable();
            $table->string('avatar', 255)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 255)->nullable();
            $table->string('role', 255)->default('customer');
            $table->string('remember_token', 100)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
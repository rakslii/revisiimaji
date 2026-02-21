<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('consultation_general', function (Blueprint $table) {
            $table->id();
            $table->string('phone_number'); // Nomor WhatsApp
            $table->string('display_text')->default('Chat WhatsApp'); // Teks tombol
            $table->text('message_template')->nullable(); // Template pesan
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('consultation_general');
    }
};
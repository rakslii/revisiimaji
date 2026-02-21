<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('consultation_products', function (Blueprint $table) {
            $table->id();
            $table->string('phone_number'); // Nomor WhatsApp untuk semua produk
            $table->string('display_text')->default('Konsultasi via WhatsApp');
            $table->text('message_template')->nullable(); // Template dengan [PRODUCT_NAME] dan [PRODUCT_URL]
            $table->boolean('include_product_url')->default(true); // Otomatis include URL produk
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('consultation_products');
    }
};
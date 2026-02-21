<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('consultation_custom_products', function (Blueprint $table) {
            $table->id();
            $table->string('phone_number'); // Nomor WhatsApp untuk produk custom
            $table->string('display_text')->default('Konsultasi Produk Custom');
            $table->text('message_template')->nullable(); // Template dengan [PRODUCT_NAME]
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('consultation_custom_products');
    }
};
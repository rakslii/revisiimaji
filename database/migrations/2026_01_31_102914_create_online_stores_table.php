<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('online_stores', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Contoh: "Shopee", "Tokopedia"
            $table->string('slug')->unique(); // Contoh: "shopee", "tokopedia"
            $table->string('platform'); // "ecommerce", "social_media"
            $table->text('description')->nullable();
            $table->string('url'); // URL toko
            $table->string('icon_class')->default('fas fa-store'); // FontAwesome class
            $table->string('color')->default('#193497'); // Warna utama
            $table->string('gradient_from')->default('#193497'); // Warna gradient awal
            $table->string('gradient_to')->default('#720e87'); // Warna gradient akhir
            $table->string('store_username')->nullable(); // Username toko di platform
            $table->string('store_id')->nullable(); // ID toko di platform
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0); // Urutan tampilan
            $table->json('metadata')->nullable(); // Data tambahan (JSON)
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index('slug');
            $table->index('platform');
            $table->index('is_active');
            $table->index('order');
        });
    }

    public function down()
    {
        Schema::dropIfExists('online_stores');
    }
};
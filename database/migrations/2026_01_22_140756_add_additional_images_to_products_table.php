<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdditionalImagesToProductsTable extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            // Tambahkan kolom untuk gambar tambahan (max 5 gambar)
            $table->string('image_2')->nullable()->after('image');
            $table->string('image_3')->nullable()->after('image_2');
            $table->string('image_4')->nullable()->after('image_3');
            $table->string('image_5')->nullable()->after('image_4');

            // Atau jika ingin lebih fleksibel dengan JSON
            $table->json('additional_images')->nullable()->after('image');

            // Kolom untuk thumbnail
            $table->string('thumbnail')->nullable()->after('image');

            // Kolom untuk menentukan gambar utama
            $table->string('main_image')->nullable()->after('image');
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['image_2', 'image_3', 'image_4', 'image_5', 'additional_images', 'thumbnail', 'main_image']);
        });
    }
}

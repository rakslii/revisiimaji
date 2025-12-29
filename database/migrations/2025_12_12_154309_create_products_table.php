// Isi baru untuk file: 2025_12_12_154309_create_products_table.php
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->decimal('price', 15, 2);
            $table->enum('category', ['instan', 'non-instan']); // Tetap ada untuk filter cepat
            $table->boolean('is_active')->default(true);
            $table->string('image')->nullable();
            $table->foreignId('category_id')->nullable(); // TANPA constrained() untuk sekarang
            $table->integer('stock')->default(0);
            $table->integer('min_order')->default(1);
            $table->json('specifications')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('promo_code_product', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('promo_code_id');
            $table->unsignedBigInteger('product_id');
            $table->decimal('discount_amount', 15, 2)->nullable();
            $table->enum('discount_type', ['percentage', 'nominal'])->nullable();
            $table->integer('max_usage_per_product')->nullable();
            $table->integer('used_count')->default(0);
            $table->timestamps();

            // Foreign keys
            $table->foreign('promo_code_id')
                  ->references('id')
                  ->on('promo_codes')
                  ->onDelete('cascade');
                  
            $table->foreign('product_id')
                  ->references('id')
                  ->on('products')
                  ->onDelete('cascade');
            
            // Unique constraint
            $table->unique(['promo_code_id', 'product_id']);
            
            // Indexes for performance
            $table->index('promo_code_id');
            $table->index('product_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('promo_code_product');
    }
};
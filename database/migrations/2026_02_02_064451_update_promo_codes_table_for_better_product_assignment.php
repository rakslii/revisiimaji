<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('promo_codes', function (Blueprint $table) {
            // Tambah kolom untuk tipe assignment
            $table->enum('product_assignment_type', ['all', 'specific_products', 'category_based', 'price_range', 'stock_based'])
                  ->default('all')
                  ->after('is_for_all_products');
            
            // Hapus kolom product_scope yang lama
            $table->dropColumn('product_scope');
            
            // Tambah kolom untuk kategori
            $table->json('category_ids')->nullable()->after('product_assignment_type');
            
            // Tambah kolom untuk filter harga
            $table->decimal('min_product_price', 15, 2)->nullable()->after('category_ids');
            $table->decimal('max_product_price', 15, 2)->nullable()->after('min_product_price');
            
            // Tambah kolom untuk filter stock
            $table->enum('stock_filter', ['any', 'in_stock', 'low_stock', 'out_of_stock'])->default('any')->after('max_product_price');
            
            // Tambah kolom untuk diskon khusus per produk
            $table->enum('product_discount_type', ['same_as_promo', 'custom'])->default('same_as_promo')->after('stock_filter');
            
            // Tambah kolom untuk tipe eksklusif
            $table->boolean('is_exclusive')->default(false)->after('is_active');
            $table->integer('priority')->default(0)->after('is_exclusive');
            
            // Tambah kolom untuk limit penggunaan per user
            $table->integer('usage_limit_per_user')->nullable()->after('quota');
            
            // Tambah kolom untuk max discount
            $table->decimal('max_discount', 15, 2)->nullable()->after('value');
        });
        
        // Buat tabel pivot untuk produk spesifik dengan diskon custom
        if (!Schema::hasTable('promo_code_products')) {
            Schema::create('promo_code_products', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('promo_code_id');
                $table->unsignedBigInteger('product_id');
                $table->enum('discount_type', ['percentage', 'nominal'])->nullable();
                $table->decimal('discount_value', 15, 2)->nullable();
                $table->integer('max_usage')->nullable();
                $table->integer('used_count')->default(0);
                $table->timestamps();

                $table->foreign('promo_code_id')->references('id')->on('promo_codes')->onDelete('cascade');
                $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
                
                $table->unique(['promo_code_id', 'product_id']);
                $table->index('promo_code_id');
                $table->index('product_id');
            });
        }
    }

    public function down()
    {
        Schema::table('promo_codes', function (Blueprint $table) {
            $table->dropColumn([
                'product_assignment_type',
                'category_ids',
                'min_product_price',
                'max_product_price',
                'stock_filter',
                'product_discount_type',
                'is_exclusive',
                'priority',
                'usage_limit_per_user',
                'max_discount'
            ]);
            
            $table->text('product_scope')->nullable()->comment('JSON of product categories or types');
        });
        
        Schema::dropIfExists('promo_code_products');
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            // Ubah nama kolom discount_percent menjadi base_discount_percent
            $table->renameColumn('discount_percent', 'base_discount_percent');
            
            // Tambahkan kolom baru untuk sistem diskon yang dinamis
            $table->decimal('calculated_discount_percent', 5, 2)->default(0)->after('base_discount_percent');
            $table->integer('discount_override_percent')->nullable()->after('calculated_discount_percent');
            $table->enum('discount_calculation_type', ['auto', 'manual'])->default('auto')->after('discount_override_percent');
            $table->unsignedBigInteger('active_product_promotion_id')->nullable()->after('discount_calculation_type');
            
            // Tambahkan foreign key constraint
            $table->foreign('active_product_promotion_id')
                  ->references('id')
                  ->on('product_promotions')
                  ->onDelete('set null');
                  
            // Tambahkan index untuk performa query
            $table->index(['discount_calculation_type', 'calculated_discount_percent'], 'idx_discount_calc');
            $table->index('active_product_promotion_id', 'idx_active_promo');
            $table->index(['is_active', 'calculated_discount_percent'], 'idx_active_discount');
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            // Hapus foreign key dan index terlebih dahulu
            $table->dropForeign(['active_product_promotion_id']);
            $table->dropIndex('idx_discount_calc');
            $table->dropIndex('idx_active_promo');
            $table->dropIndex('idx_active_discount');
            
            // Hapus kolom baru
            $table->dropColumn([
                'calculated_discount_percent',
                'discount_override_percent',
                'discount_calculation_type',
                'active_product_promotion_id'
            ]);
            
            // Kembalikan nama kolom ke semula
            $table->renameColumn('base_discount_percent', 'discount_percent');
        });
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('promo_codes', function (Blueprint $table) {
            $table->boolean('is_for_all_products')->default(false)->after('is_active');
            $table->text('product_scope')->nullable()->after('is_for_all_products')->comment('JSON of product categories or types');
        });
    }

    public function down(): void
    {
        Schema::table('promo_codes', function (Blueprint $table) {
            $table->dropColumn(['is_for_all_products', 'product_scope']);
        });
    }
};
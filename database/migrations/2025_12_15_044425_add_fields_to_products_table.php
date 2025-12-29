<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::table('products', function (Blueprint $table) {
        $table->string('short_description')->nullable()->after('description');
        $table->integer('discount_percent')->default(0)->after('price');
        $table->integer('sales_count')->default(0)->after('stock');
        $table->decimal('rating', 3, 1)->nullable()->after('sales_count');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            //
        });
    }
};

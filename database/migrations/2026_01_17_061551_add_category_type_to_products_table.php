<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            // Tambah kolom category_type jika belum ada
            if (!Schema::hasColumn('products', 'category_type')) {
                $table->enum('category_type', ['instan', 'non-instan'])
                      ->after('category')
                      ->nullable();
            }
        });

        // Update data existing: copy dari category ke category_type
        DB::statement("UPDATE products SET category_type = category WHERE category IS NOT NULL");
        
        // Set category_type sebagai required
        Schema::table('products', function (Blueprint $table) {
            $table->enum('category_type', ['instan', 'non-instan'])->nullable(false)->change();
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('category_type');
        });
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('product_categories', function (Blueprint $table) {
            $table->string('featured_image_1')->nullable()->after('icon');
            $table->string('featured_image_2')->nullable()->after('featured_image_1');
            $table->string('featured_image_3')->nullable()->after('featured_image_2');
            $table->string('featured_image_4')->nullable()->after('featured_image_3');
            $table->string('featured_image_5')->nullable()->after('featured_image_4');
            $table->string('featured_image_6')->nullable()->after('featured_image_5');
            $table->string('category_color')->default('#193497')->after('featured_image_6');
            $table->string('accent_color')->default('#c0f820')->after('category_color');
        });
    }

    public function down()
    {
        Schema::table('product_categories', function (Blueprint $table) {
            $table->dropColumn([
                'featured_image_1',
                'featured_image_2', 
                'featured_image_3',
                'featured_image_4',
                'featured_image_5',
                'featured_image_6',
                'category_color',
                'accent_color'
            ]);
        });
    }
};
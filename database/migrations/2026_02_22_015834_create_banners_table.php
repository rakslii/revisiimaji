<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('mobile_image')->nullable();
            $table->string('link')->nullable();
            $table->string('button_text')->default('Lihat Promo');
            $table->enum('type', ['home_banner', 'popup'])->default('home_banner');
            $table->enum('position', ['center', 'top', 'bottom', 'left', 'right'])->default('center');
            $table->enum('size', ['small', 'medium', 'large', 'full'])->default('medium');
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->integer('display_order')->default(0);
            $table->boolean('is_active')->default(true);
            
            // Settings untuk popup
            $table->boolean('show_once_per_session')->default(true);
            $table->integer('delay_seconds')->default(3);
            $table->boolean('show_close_button')->default(true);
            $table->boolean('show_on_mobile')->default(true);
            $table->boolean('show_on_tablet')->default(true);
            $table->boolean('show_on_desktop')->default(true);
            
            // Background color & opacity
            $table->string('background_color')->default('#ffffff')->nullable();
            $table->integer('background_opacity')->default(100)->nullable();
            
            // Statistics
            $table->integer('views_count')->default(0);
            $table->integer('clicks_count')->default(0);
            
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index(['type', 'is_active', 'start_date', 'end_date']);
            $table->index('display_order');
        });
    }

    public function down()
    {
        Schema::dropIfExists('banners');
    }
};
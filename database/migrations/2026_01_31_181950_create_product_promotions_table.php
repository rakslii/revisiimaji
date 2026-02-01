<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_promotions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            
            // Promo Information
            $table->string('name')->nullable();
            $table->enum('type', ['percentage', 'nominal'])->default('percentage');
            $table->decimal('value', 15, 2);
            $table->integer('quota')->nullable()->comment('Max usage for this product');
            $table->integer('used_count')->default(0);
            
            // Validity Period
            $table->dateTime('valid_from');
            $table->dateTime('valid_until');
            
            // Conditions
            $table->decimal('min_purchase', 15, 2)->nullable();
            $table->integer('min_quantity')->nullable()->default(1);
            
            // Status
            $table->boolean('is_active')->default(true);
            $table->boolean('is_exclusive')->default(false)->comment('Cannot be combined with other promos');
            
            // Relationship with main promo (optional)
            $table->foreignId('promo_code_id')->nullable()->constrained('promo_codes')->onDelete('set null');
            
            // Priority
            $table->integer('priority')->default(0)->comment('Higher number = higher priority');
            
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index('product_id');
            $table->index('promo_code_id');
            $table->index('valid_from');
            $table->index('valid_until');
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_promotions');
    }
};
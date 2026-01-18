<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Drop existing table
        Schema::dropIfExists('orders');
        
        // Create new complete table
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_code')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Customer Information
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('customer_email');
            
            // Shipping Information
            $table->text('shipping_address');
            $table->string('shipping_city');
            $table->string('shipping_postal_code');
            $table->enum('shipping_method', ['pickup', 'delivery', 'cargo'])->default('pickup');
            $table->string('shipping_note')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            
            // Payment Information
            $table->string('payment_method')->default('qris');
            $table->enum('payment_status', ['unpaid', 'paid', 'failed', 'expired', 'cancelled'])->default('unpaid');
            $table->string('snap_token')->nullable();
            $table->string('midtrans_order_id')->nullable();
            
            // Price Information
            $table->decimal('subtotal', 15, 2);
            $table->decimal('shipping_cost', 15, 2)->default(0);
            $table->decimal('discount', 15, 2)->default(0);
            $table->decimal('total', 15, 2);
            
            // Order Status
            $table->enum('status', [
                'pending',
                'waiting_payment',
                'paid',
                'processing',
                'completed',
                'cancelled'
            ])->default('pending');
            
            // Additional Information
            $table->text('notes')->nullable();
            $table->text('design_files')->nullable();
            $table->text('design_notes')->nullable();
            $table->string('promo_code')->nullable();
            $table->text('admin_notes')->nullable();
            
            // Timestamps
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
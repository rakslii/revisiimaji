<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Add missing columns if they don't exist
            if (!Schema::hasColumn('orders', 'customer_name')) {
                $table->string('customer_name')->after('user_id');
            }
            if (!Schema::hasColumn('orders', 'customer_phone')) {
                $table->string('customer_phone')->after('customer_name');
            }
            if (!Schema::hasColumn('orders', 'customer_email')) {
                $table->string('customer_email')->after('customer_phone');
            }
            if (!Schema::hasColumn('orders', 'shipping_city')) {
                $table->string('shipping_city')->after('shipping_address');
            }
            if (!Schema::hasColumn('orders', 'shipping_postal_code')) {
                $table->string('shipping_postal_code')->after('shipping_city');
            }
            if (!Schema::hasColumn('orders', 'shipping_method')) {
                $table->enum('shipping_method', ['pickup', 'delivery', 'cargo'])->after('shipping_postal_code');
            }
            if (!Schema::hasColumn('orders', 'payment_method')) {
                $table->string('payment_method')->after('shipping_method');
            }
            if (!Schema::hasColumn('orders', 'payment_status')) {
                $table->enum('payment_status', ['unpaid', 'paid', 'failed', 'expired', 'cancelled'])->default('unpaid')->after('payment_method');
            }
            if (!Schema::hasColumn('orders', 'snap_token')) {
                $table->string('snap_token')->nullable()->after('payment_status');
            }
            if (!Schema::hasColumn('orders', 'midtrans_order_id')) {
                $table->string('midtrans_order_id')->nullable()->after('snap_token');
            }
            if (!Schema::hasColumn('orders', 'notes')) {
                $table->text('notes')->nullable()->after('midtrans_order_id');
            }
            if (!Schema::hasColumn('orders', 'design_files')) {
                $table->text('design_files')->nullable()->after('notes');
            }
            if (!Schema::hasColumn('orders', 'design_notes')) {
                $table->text('design_notes')->nullable()->after('design_files');
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $columns = [
                'customer_name', 'customer_phone', 'customer_email',
                'shipping_city', 'shipping_postal_code', 'shipping_method',
                'payment_method', 'payment_status', 'snap_token',
                'midtrans_order_id', 'notes', 'design_files', 'design_notes'
            ];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('orders', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
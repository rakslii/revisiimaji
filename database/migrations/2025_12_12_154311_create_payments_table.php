<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->string('payment_method')->default('qris');
            $table->string('qr_code')->nullable();
            $table->string('qr_url')->nullable();
            $table->string('external_id')->unique();
            $table->decimal('amount', 15, 2);
            $table->enum('status', ['pending', 'processing', 'paid', 'expired', 'failed']);
            $table->datetime('expired_at');
            $table->json('payment_data')->nullable(); // Response dari Midtrans
            $table->string('bank')->nullable();
            $table->string('va_number')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};

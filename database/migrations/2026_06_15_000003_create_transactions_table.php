<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('subscription_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('order_id', 50)->unique();
            $table->string('midtrans_order_id', 100)->nullable();
            $table->unsignedInteger('amount');
            $table->string('payment_type', 50)->nullable();
            $table->string('transaction_status', 30)->default('pending');
            $table->string('snap_token')->nullable();
            $table->string('snap_redirect_url')->nullable();
            $table->json('midtrans_response')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'transaction_status']);
            $table->index('order_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};

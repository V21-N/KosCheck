<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('plan_name', 50)->default('premium');
            $table->string('plan_type', 20)->default('monthly');
            $table->unsignedInteger('price');
            $table->unsignedTinyInteger('duration_days')->default(30);
            $table->timestamp('started_at');
            $table->timestamp('expired_at');
            $table->enum('status', ['active', 'expired', 'cancelled', 'pending'])->default('pending');
            $table->timestamps();

            $table->index(['user_id', 'status']);
            $table->index(['status', 'expired_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};

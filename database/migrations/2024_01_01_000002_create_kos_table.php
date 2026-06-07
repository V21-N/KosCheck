<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('address');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->integer('price');
            $table->enum('gender', ['putra', 'putri', 'campur'])->default('campur');
            $table->text('description')->nullable();
            $table->string('whatsapp');
            $table->string('phone')->nullable();
            $table->enum('status', ['pending', 'active', 'rejected'])->default('pending');
            $table->boolean('is_premium')->default(false);
            $table->timestamp('premium_expires_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->softDeletes();
            $table->timestamps();

            $table->index(['is_premium', 'created_at']);
            $table->index('gender');
            $table->index('price');
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kos');
    }
};

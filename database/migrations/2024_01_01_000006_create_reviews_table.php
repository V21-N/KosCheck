<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kos_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->integer('rating');
            $table->integer('rating_cleanliness')->nullable();
            $table->integer('rating_security')->nullable();
            $table->integer('rating_facilities')->nullable();
            $table->text('comment');
            $table->integer('helpful_count')->default(0);
            $table->boolean('is_flagged')->default(false);
            $table->boolean('is_visible')->default(true);
            $table->timestamps();

            $table->unique(['kos_id', 'user_id']);
            $table->index('is_flagged');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};

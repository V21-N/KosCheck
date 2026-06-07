<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('image_url');
            $table->string('target_url');
            $table->enum('position', ['homepage', 'search_result', 'kos_detail', 'sidebar']);
            $table->string('area')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->boolean('is_active')->default(true);
            $table->integer('max_clicks')->nullable();
            $table->integer('click_count')->default(0);
            $table->timestamps();

            $table->index(['position', 'is_active', 'start_date', 'end_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ads');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Change default value of is_visible to false
        // Reviews should NOT be visible until approved by admin
        Schema::table('reviews', function (Blueprint $table) {
            $table->boolean('is_visible')->default(false)->change();
        });
    }

    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->boolean('is_visible')->default(true)->change();
        });
    }
};

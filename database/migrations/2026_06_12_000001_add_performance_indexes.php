<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            // Add composite index for common query patterns
            $table->index(['is_visible', 'created_at']);
            $table->index(['is_flagged', 'is_visible']);
        });

        Schema::table('bookings', function (Blueprint $table) {
            // Add composite index for user bookings query
            $table->index(['user_id', 'status']);
        });

        Schema::table('users', function (Blueprint $table) {
            // Add index for role-based queries
            $table->index('role');
            $table->index(['role', 'is_active']);
        });

        Schema::table('photos', function (Blueprint $table) {
            // Add index for kos photos ordering
            $table->index(['kos_id', 'is_primary']);
        });

        Schema::table('notifications', function (Blueprint $table) {
            // Add index for user notifications
            $table->index(['user_id', 'read_at']);
        });

        Schema::table('favorite_kos', function (Blueprint $table) {
            // Add index for user favorites
            $table->index(['user_id', 'kos_id']);
        });
    }

    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropIndex(['is_visible_created_at_index']);
            $table->dropIndex(['is_flagged_is_visible_index']);
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->dropIndex(['user_id_status_index']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['role_index']);
            $table->dropIndex(['role_is_active_index']);
        });

        Schema::table('photos', function (Blueprint $table) {
            $table->dropIndex(['kos_id_is_primary_index']);
        });

        Schema::table('notifications', function (Blueprint $table) {
            $table->dropIndex(['user_id_read_at_index']);
        });

        Schema::table('favorite_kos', function (Blueprint $table) {
            $table->dropIndex(['user_id_kos_id_index']);
        });
    }
};

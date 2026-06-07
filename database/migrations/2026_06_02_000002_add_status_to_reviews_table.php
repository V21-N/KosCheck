<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->string('status', 20)->default('pending')->after('is_visible');
            $table->text('rejection_reason')->nullable()->after('status');
            $table->string('moderated_by')->nullable()->after('rejection_reason');
            $table->timestamp('moderated_at')->nullable()->after('moderated_by');
        });
    }

    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropColumn(['status', 'rejection_reason', 'moderated_by', 'moderated_at']);
        });
    }
};
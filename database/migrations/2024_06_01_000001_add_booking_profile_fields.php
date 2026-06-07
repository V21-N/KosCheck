<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('phone', 20)->nullable()->after('rejection_reason');
            $table->string('university', 100)->nullable()->after('phone');
            $table->enum('gender', ['L', 'P'])->nullable()->after('university');
            $table->date('move_in_date')->nullable()->after('gender');
            $table->unsignedTinyInteger('duration_months')->nullable()->after('move_in_date');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['phone', 'university', 'gender', 'move_in_date', 'duration_months']);
        });
    }
};

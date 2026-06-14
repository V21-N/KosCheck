<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kos', function (Blueprint $table) {
            // Room details
            $table->unsignedInteger('total_rooms')->nullable()->after('gender');
            $table->unsignedInteger('available_rooms')->nullable()->after('total_rooms');
            $table->unsignedInteger('room_size')->nullable()->after('available_rooms'); // in m²

            // Pricing details
            $table->unsignedInteger('deposit')->nullable()->after('price');
            $table->boolean('long_stay_discount')->default(false)->after('deposit');

            // Additional info
            $table->json('rules')->nullable()->after('description'); // Store rules as JSON array
        });
    }

    public function down(): void
    {
        Schema::table('kos', function (Blueprint $table) {
            $table->dropColumn([
                'total_rooms',
                'available_rooms',
                'room_size',
                'deposit',
                'long_stay_discount',
                'rules',
            ]);
        });
    }
};
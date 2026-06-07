<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->string('report_id')->unique()->after('id');
            $table->string('contact_phone', 20)->nullable()->after('admin_notes');
            $table->string('ip_address', 45)->nullable()->after('contact_phone');
            $table->text('user_agent')->nullable()->after('ip_address');
        });
    }

    public function down(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->dropColumn(['report_id', 'contact_phone', 'ip_address', 'user_agent']);
        });
    }
};

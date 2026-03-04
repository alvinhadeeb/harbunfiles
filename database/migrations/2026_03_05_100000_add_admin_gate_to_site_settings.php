<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->boolean('admin_gate_enabled')->default(false)->after('sidebar_logo');
            $table->string('admin_gate_code', 100)->default('1234')->after('admin_gate_enabled');
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn(['admin_gate_enabled', 'admin_gate_code']);
        });
    }
};

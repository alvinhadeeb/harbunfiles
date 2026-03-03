<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('admin_roles', function (Blueprint $table) {
            $table->json('allowed_lembaga')->nullable()->after('permissions');
            // null = semua lembaga, [] = tidak ada, [1,2] = hanya lembaga ID 1 dan 2
        });
    }

    public function down(): void
    {
        Schema::table('admin_roles', function (Blueprint $table) {
            $table->dropColumn('allowed_lembaga');
        });
    }
};

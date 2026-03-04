<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('admin_roles', function (Blueprint $table) {
            $table->string('sidebar_color', 30)->nullable()->after('allowed_lembaga');
        });
    }

    public function down(): void
    {
        Schema::table('admin_roles', function (Blueprint $table) {
            $table->dropColumn('sidebar_color');
        });
    }
};

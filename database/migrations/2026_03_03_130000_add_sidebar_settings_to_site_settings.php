<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->string('sidebar_title')->default('Admin Panel')->after('secret_register_url');
            $table->string('sidebar_subtitle')->default('Harapan Bunda')->after('sidebar_title');
            $table->string('sidebar_logo')->nullable()->after('sidebar_subtitle');
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn(['sidebar_title', 'sidebar_subtitle', 'sidebar_logo']);
        });
    }
};

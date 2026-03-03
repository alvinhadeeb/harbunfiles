<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->string('admin_prefix')->default('minda')->after('secret_register_enabled');
            $table->string('secret_register_url')->default('mendoan')->after('admin_prefix');
        });

        // Update existing row
        DB::table('site_settings')->where('id', 1)->update([
            'admin_prefix' => 'minda',
            'secret_register_url' => 'mendoan',
        ]);
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn(['admin_prefix', 'secret_register_url']);
        });
    }
};

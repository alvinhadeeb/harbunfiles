<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('lembaga', function (Blueprint $table) {
            $table->string('banner_judul')->nullable()->after('banner');
            $table->string('banner_subjudul')->nullable()->after('banner_judul');
            $table->text('banner_kutipan')->nullable()->after('banner_subjudul');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lembaga', function (Blueprint $table) {
            $table->dropColumn(['banner_judul', 'banner_subjudul', 'banner_kutipan']);
        });
    }
};

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
            $table->string('footer_telepon')->nullable()->after('footer');
            $table->string('footer_email')->nullable()->after('footer_telepon');
            $table->text('footer_alamat')->nullable()->after('footer_email');
            $table->string('footer_whatsapp')->nullable()->after('footer_alamat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lembaga', function (Blueprint $table) {
            $table->dropColumn(['footer_telepon', 'footer_email', 'footer_alamat', 'footer_whatsapp']);
        });
    }
};

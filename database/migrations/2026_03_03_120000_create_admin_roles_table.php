<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admin_roles', function (Blueprint $table) {
            $table->id();
            $table->string('name');         // e.g. "Admin LPIT", "Admin SD 2"
            $table->text('description')->nullable();
            $table->json('permissions');     // e.g. ["berita","galeri","banner"]
            $table->timestamps();
        });

        // Tambah kolom admin_role_id di tabel admins
        Schema::table('admins', function (Blueprint $table) {
            $table->foreignId('admin_role_id')->nullable()->after('role')
                ->constrained('admin_roles')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->dropForeign(['admin_role_id']);
            $table->dropColumn('admin_role_id');
        });

        Schema::dropIfExists('admin_roles');
    }
};

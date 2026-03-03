<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Buat pivot table
        Schema::create('berita_lembaga', function (Blueprint $table) {
            $table->id();
            $table->foreignId('berita_id')->constrained('berita')->onDelete('cascade');
            $table->foreignId('lembaga_id')->constrained('lembaga')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['berita_id', 'lembaga_id']);
        });

        // 2. Migrasi data lama dari kolom lembaga_id ke pivot table
        $beritas = DB::table('berita')->whereNotNull('lembaga_id')->get();
        foreach ($beritas as $berita) {
            DB::table('berita_lembaga')->insert([
                'berita_id' => $berita->id,
                'lembaga_id' => $berita->lembaga_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 3. Hapus kolom lembaga_id lama
        Schema::table('berita', function (Blueprint $table) {
            $table->dropForeign(['lembaga_id']);
            $table->dropColumn('lembaga_id');
        });
    }

    public function down(): void
    {
        // Tambahkan kembali kolom lembaga_id
        Schema::table('berita', function (Blueprint $table) {
            $table->foreignId('lembaga_id')->nullable()->after('status')->constrained('lembaga')->nullOnDelete();
        });

        // Migrasi data kembali (ambil 1 lembaga pertama per berita)
        $pivotData = DB::table('berita_lembaga')
            ->select('berita_id', DB::raw('MIN(lembaga_id) as lembaga_id'))
            ->groupBy('berita_id')
            ->get();

        foreach ($pivotData as $row) {
            DB::table('berita')->where('id', $row->berita_id)->update([
                'lembaga_id' => $row->lembaga_id,
            ]);
        }

        Schema::dropIfExists('berita_lembaga');
    }
};

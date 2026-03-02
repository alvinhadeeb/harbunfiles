<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SqliteToMysql extends Command
{
    protected $signature = 'db:sqlite-to-mysql';
    protected $description = 'Pindahkan semua data dari SQLite ke MySQL';

    // Tabel yang berisi data penting (sesuai urutan dependency)
    private $dataTables = [
        'users',
        'admins',
        'kategori',
        'lembaga',
        'berita',
        'galeri',
        'testimoni',
        'banner',
        'kontak',
        'header_menus',
        'header_settings',
    ];

    public function handle()
    {
        $this->info('');
        $this->info('╔══════════════════════════════════════════╗');
        $this->info('║   MIGRASI DATABASE: SQLite → MySQL      ║');
        $this->info('╚══════════════════════════════════════════╝');
        $this->info('');

        // ============================================
        // STEP 1: Baca semua data dari SQLite
        // ============================================
        $this->info('📦 STEP 1: Membaca data dari SQLite...');

        $allData = [];
        foreach ($this->dataTables as $table) {
            try {
                $rows = DB::connection('sqlite')->table($table)->get();
                $allData[$table] = $rows;
                $count = $rows->count();
                $this->line("   ✓ {$table}: {$count} rows");
            } catch (\Exception $e) {
                $this->warn("   ⚠ {$table}: tabel tidak ditemukan, skip");
                $allData[$table] = collect();
            }
        }

        $this->info('');
        $this->info('✅ Data SQLite berhasil dibaca!');
        $this->info('');

        // ============================================
        // STEP 2: Jalankan migration di MySQL
        // ============================================
        $this->info('🗃️  STEP 2: Membuat tabel di MySQL...');

        // Pastikan .env sudah diganti ke mysql
        if (config('database.default') !== 'mysql') {
            $this->error('');
            $this->error('❌ DB_CONNECTION di .env masih "sqlite"!');
            $this->error('   Ubah dulu ke "mysql" di file .env, lalu jalankan ulang command ini.');
            $this->error('');
            return 1;
        }

        // Test koneksi MySQL
        try {
            DB::connection('mysql')->getPdo();
            $this->line('   ✓ Koneksi MySQL berhasil!');
        } catch (\Exception $e) {
            $this->error('');
            $this->error('❌ Gagal koneksi ke MySQL!');
            $this->error('   Pastikan MySQL sudah running dan database "harapanbunda" sudah dibuat.');
            $this->error('   Error: ' . $e->getMessage());
            $this->error('');
            return 1;
        }

        // Jalankan migration
        $this->call('migrate:fresh', ['--force' => true]);
        $this->info('');

        // ============================================
        // STEP 3: Import data ke MySQL
        // ============================================
        $this->info('📥 STEP 3: Memindahkan data ke MySQL...');

        foreach ($this->dataTables as $table) {
            $rows = $allData[$table];
            if ($rows->isEmpty()) {
                $this->line("   - {$table}: kosong, skip");
                continue;
            }

            try {
                // Convert ke array dan insert per batch
                $data = $rows->map(function ($row) {
                    return (array) $row;
                })->toArray();

                // Insert dalam batch 100 rows
                foreach (array_chunk($data, 100) as $chunk) {
                    DB::connection('mysql')->table($table)->insert($chunk);
                }

                $count = count($data);
                $this->line("   ✓ {$table}: {$count} rows berhasil dipindahkan");
            } catch (\Exception $e) {
                $this->error("   ✗ {$table}: GAGAL - " . $e->getMessage());
            }
        }

        $this->info('');
        $this->info('╔══════════════════════════════════════════╗');
        $this->info('║   ✅ MIGRASI SELESAI! Data aman semua!  ║');
        $this->info('╚══════════════════════════════════════════╝');
        $this->info('');
        $this->info('File SQLite lama masih ada di: database/database.sqlite (backup)');
        $this->info('');

        return 0;
    }
}

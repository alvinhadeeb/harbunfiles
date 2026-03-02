<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $kategoriList = [
            'Informasi Umum',
            'Prestasi',
            'Agenda Sekolah',
            'Pengumuman Siswa',
            'Pengumuman Pegawai',
            'Pengumuman Orang Tua Siswa',
            'Karya Siswa',
        ];

        foreach ($kategoriList as $nama) {
            Kategori::firstOrCreate(['nama' => $nama]);
        }
    }
}

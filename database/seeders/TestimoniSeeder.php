<?php

namespace Database\Seeders;

use App\Models\Testimoni;
use Illuminate\Database\Seeder;

class TestimoniSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'nama' => 'Budi Santoso',
                'jabatan' => 'Orang Tua Siswa',
                'isi' => 'Alhamdulillah, anak saya sangat senang bersekolah di LPIT Harapan Bunda. Pendidikan karakter dan agamanya sangat baik. Guru-gurunya ramah dan perhatian terhadap perkembangan setiap anak.',
                'aktif' => true,
                'urutan' => 1,
            ],
            [
                'nama' => 'Siti Nurhaliza',
                'jabatan' => 'Orang Tua Siswa',
                'isi' => 'Sejak masuk di Harapan Bunda, anak saya jadi lebih mandiri dan percaya diri. Program tahfidz dan kegiatan ekstrakulikulernya sangat mendukung tumbuh kembang anak secara menyeluruh.',
                'aktif' => true,
                'urutan' => 2,
            ],
            [
                'nama' => 'Ahmad Fauzi',
                'jabatan' => 'Alumni',
                'isi' => 'Saya bangga pernah menjadi bagian dari Harapan Bunda. Ilmu agama dan akademik yang saya dapatkan menjadi bekal yang sangat berharga untuk melanjutkan pendidikan ke jenjang selanjutnya.',
                'aktif' => true,
                'urutan' => 3,
            ],
        ];

        foreach ($data as $item) {
            Testimoni::firstOrCreate(['nama' => $item['nama']], $item);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Berita;

class BeritaSeeder extends Seeder
{
    public function run(): void
    {
        $beritaData = [
            [
                'judul' => 'Puskesmas Purwokerto Selatan Perkuat Program Kesehatan Anak di SDIT Harapan Bunda Purwokerto',
                'slug' => 'puskesmas-purwokerto-selatan-perkuat-program-kesehatan-anak',
                'konten' => "Puskesmas Purwokerto Selatan melaksanakan kegiatan pembagian obat cacing kepada siswa-siswi SDIT Harapan Bunda Purwokerto pada Senin, 2 Februari 2026. Kegiatan tersebut disertai dengan sosialisasi kesehatan sebagai bagian dari upaya mendukung program peningkatan kesehatan anak usia sekolah. Dalam kegiatan ini, petugas kesehatan Puskesmas Purwokerto Selatan memberikan edukasi terkait penggunaan obat cacing, manfaatnya bagi kesehatan, serta dampak yang ditimbulkan jika tidak dilakukan pencegahan.\n\nSelain itu, siswa juga diberikan pemahaman mengenai pentingnya penerapan perilaku hidup bersih dan sehat, seperti mencuci tangan sebelum dan sesudah beraktivitas, menjaga kebersihan makanan, serta menjaga kebersihan lingkungan sekolah dan rumah.\n\nPihak SDIT Harapan Bunda Purwokerto menyampaikan apresiasi atas pelaksanaan kegiatan tersebut dan menilai bahwa program pembagian obat cacing yang disertai sosialisasi kesehatan ini memberikan manfaat nyata bagi peserta didik. Kegiatan ini juga dinilai selaras dengan upaya sekolah dalam menciptakan lingkungan pendidikan yang sehat dan mendukung perkembangan anak secara optimal.\n\nMelalui kegiatan ini, diharapkan para siswa memiliki pemahaman yang lebih baik mengenai pentingnya menjaga kesehatan sejak dini, sehingga dapat menunjang tumbuh kembang yang optimal serta meningkatkan kualitas proses belajar di sekolah.",
                'kategori' => 'Informasi Umum',
                'status' => 'published',
                'created_at' => '2026-01-30 10:00:00',
                'updated_at' => '2026-01-30 10:00:00',
            ],
            [
                'judul' => 'Komite SDIT Harapan Bunda Purwokerto Gelar Bakti Sosial',
                'slug' => 'komite-sdit-harapan-bunda-purwokerto-gelar-bakti-sosial',
                'konten' => "Komite SDIT Harapan Bunda Purwokerto menggelar kegiatan bakti sosial yang melibatkan seluruh elemen sekolah. Kegiatan ini dilaksanakan sebagai wujud kepedulian terhadap masyarakat sekitar dan memberikan edukasi kepada siswa tentang pentingnya berbagi.\n\nKegiatan bakti sosial ini meliputi pembagian sembako kepada warga kurang mampu di sekitar lingkungan sekolah, serta pembersihan lingkungan bersama. Para siswa turut antusias berpartisipasi dalam kegiatan ini.\n\nKepala SDIT Harapan Bunda Purwokerto menyampaikan bahwa kegiatan ini merupakan bagian dari program pembentukan karakter siswa yang peduli terhadap lingkungan dan sesama.",
                'kategori' => 'Agenda Sekolah',
                'status' => 'published',
                'created_at' => '2026-01-28 09:00:00',
                'updated_at' => '2026-01-28 09:00:00',
            ],
            [
                'judul' => 'Siswa TK IT Harapan Bunda Raih Juara Lomba Mewarnai Tingkat Kabupaten',
                'slug' => 'siswa-tk-it-harapan-bunda-raih-juara-lomba-mewarnai',
                'konten' => "Siswa TK IT Harapan Bunda Purwokerto berhasil meraih juara dalam Lomba Mewarnai Tingkat Kabupaten Banyumas yang diselenggarakan pada hari Sabtu, 25 Januari 2026. Prestasi ini menunjukkan kualitas pendidikan seni di TK IT Harapan Bunda.\n\nLomba yang diikuti oleh ratusan peserta dari berbagai sekolah di Kabupaten Banyumas ini mengangkat tema 'Alam Indonesia'. Para siswa menunjukkan kreativitas dan kemampuan mereka dalam mengolah warna.\n\nGuru pendamping menyampaikan rasa bangga atas pencapaian ini dan berharap dapat menjadi motivasi bagi siswa lainnya untuk terus berkarya dan berprestasi.",
                'kategori' => 'Prestasi',
                'status' => 'published',
                'created_at' => '2026-01-25 14:00:00',
                'updated_at' => '2026-01-25 14:00:00',
            ],
            [
                'judul' => 'Pengumuman Jadwal Ujian Akhir Semester Genap 2025/2026',
                'slug' => 'pengumuman-jadwal-ujian-akhir-semester-genap-2025-2026',
                'konten' => "Diinformasikan kepada seluruh siswa dan orang tua/wali murid bahwa Ujian Akhir Semester Genap Tahun Pelajaran 2025/2026 akan dilaksanakan pada:\n\nTanggal: 15-20 Juni 2026\nWaktu: 07.30 - 11.00 WIB\nTempat: Ruang kelas masing-masing\n\nDimohon kepada seluruh siswa untuk mempersiapkan diri dengan baik. Jadwal lengkap per mata pelajaran dapat dilihat di papan pengumuman sekolah atau menghubungi wali kelas masing-masing.\n\nSemoga seluruh siswa dapat mengikuti ujian dengan lancar dan meraih hasil yang terbaik.",
                'kategori' => 'Pengumuman Siswa',
                'status' => 'published',
                'created_at' => '2026-01-20 08:00:00',
                'updated_at' => '2026-01-20 08:00:00',
            ],
            [
                'judul' => 'SD IT Harapan Bunda 01 Gelar Peringatan Isra Miraj Nabi Muhammad SAW',
                'slug' => 'sd-it-harapan-bunda-01-gelar-peringatan-isra-miraj',
                'konten' => "SD IT Harapan Bunda 01 Purwokerto menggelar peringatan Isra Miraj Nabi Muhammad SAW 1447 H yang dihadiri oleh seluruh siswa, guru, dan tenaga kependidikan. Acara ini diisi dengan ceramah agama oleh ustadz setempat serta pertunjukan seni islami dari para siswa.\n\nDalam sambutannya, Kepala Sekolah mengajak seluruh warga sekolah untuk meneladani perjalanan Rasulullah SAW dan meningkatkan ketakwaan kepada Allah SWT. Para siswa juga antusias mengikuti kuis tentang sejarah Isra Miraj.\n\nAcara diakhiri dengan doa bersama dan makan bersama yang mempererat silaturahmi antar warga sekolah.",
                'kategori' => 'Agenda Sekolah',
                'status' => 'published',
                'created_at' => '2026-01-18 10:00:00',
                'updated_at' => '2026-01-18 10:00:00',
            ],
        ];

        foreach ($beritaData as $data) {
            Berita::updateOrCreate(
                ['slug' => $data['slug']],
                $data
            );
        }
    }
}

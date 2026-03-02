<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Lembaga;

class LembagaSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'nama' => 'Yayasan Permata Hati',
                'slug' => 'yayasan-permata-hati',
                'singkatan' => 'YPH',
                'warna_bg' => 'bg-blue-600',
                'logo' => 'images/logo-PermataHati.png',
                'banner' => 'images/banner-yph.jpg',
                'deskripsi' => 'Yayasan Permata Hati Purwokerto Awalnya bernama Yayasan Permata Hati yang didirikan pada tanggal 9 Agustus 1997. Sejak tahun 2000, Yayasan Permata Hati mampu mengelola SDLB, SLTP LB, dan SMU LB sebagai kompensasi atas tidak ada sekolah pendidikan khusus negeri pada masa itu. Karena banyak permasalahan sosial serta kesulitan yang berkaitan dengan isu Cari anak. Sedangkan dalam bidang pendidikan, Yayasan Permata Hati menggunakan metode pengembangan kepribadian yang terencana. Mereka didakwa mampu menjadi pencerita yang baik di luar negeri dengan nilai akademik. Kemudian, Kelompok Bermain "Harapan Bunda" (1997) dan Taman Kanak-Kanak Islam Terpadu Harapan Bunda (2002), disusul kemudian dengan berdirinya Sekolah Dasar Islam Terpadu dan Yayasan Permata Hati hingga kepada mayarakat.',
                'visi' => 'Peningkatan kualitas sumber daya manusia melalui pendidikan dasar yang berwawasan dan berkesinambungan dengan potensi masyarakat',
                'misi' => json_encode([
                    'Meningkatkan kualitas pendidikan usia dini dengan cara menyelenggerakan pendidikan formal dan non formal',
                    'Melaksanakan program kegiatan yang memberikan keberpengaruhan semangat ibadah dan ta\'aruf serta berpasaling prasa terhadap agama, bangsa, dan negara',
                    'Menumbuhkan karakter anak yang berlandaskan dengan nilai "ilmu Islam dan nilai ilmu Pancasila"',
                    'Membentuk etos pelajaran yang dan orang tua anak yang jenang manajemen yang berorientasi islam menjuru musilim yang berpengetahuan dan bermartabatan'
                ]),
                'aktif' => true,
                'urutan' => 1,
            ],
            [
                'nama' => 'LPIT Harapan Bunda',
                'slug' => 'lpit-harapan-bunda',
                'singkatan' => 'LPIT',
                'warna_bg' => 'bg-blue-600',
                'logo' => 'images/logo-lpit.png',
                'banner' => 'images/banner-lpit.jpg',
                'deskripsi' => 'LPIT Harapan Bunda adalah lembaga pendidikan Islam terpadu yang mengintegrasikan nilai-nilai Islam dalam setiap aspek pembelajaran. Dengan kurikulum yang komprehensif, LPIT Harapan Bunda berkomitmen untuk mencetak generasi Qurani yang berakhlak mulia.',
                'visi' => 'Menjadi lembaga pendidikan Islam terpadu yang unggul dalam prestasi dan berakhlakul karimah',
                'misi' => json_encode([
                    'Menyelenggarakan pendidikan yang mengintegrasikan ilmu pengetahuan dan nilai-nilai Islam',
                    'Membentuk karakter siswa yang berakhlak mulia dan bertaqwa kepada Allah SWT',
                    'Mengembangkan potensi siswa secara optimal dalam bidang akademik dan non-akademik',
                    'Menciptakan lingkungan belajar yang kondusif dan Islami'
                ]),
                'aktif' => true,
                'urutan' => 2,
            ],
            [
                'nama' => 'Sukses Multi Sarana',
                'slug' => 'sukses-multi-sarana',
                'singkatan' => 'SMS',
                'warna_bg' => 'bg-red-600',
                'logo' => 'images/logo-sms.png',
                'banner' => 'images/banner-sms.jpg',
                'deskripsi' => 'Sukses Multi Sarana adalah unit usaha yang mendukung operasional lembaga pendidikan di bawah naungan Yayasan Permata Hati. SMS berkomitmen untuk menyediakan sarana dan prasarana pendidikan yang berkualitas.',
                'visi' => 'Menjadi penyedia sarana dan prasarana pendidikan yang profesional dan terpercaya',
                'misi' => json_encode([
                    'Menyediakan sarana dan prasarana pendidikan berkualitas',
                    'Mendukung operasional lembaga pendidikan dengan layanan terbaik',
                    'Mengembangkan inovasi dalam penyediaan fasilitas pendidikan',
                    'Membangun kemitraan yang saling menguntungkan'
                ]),
                'aktif' => true,
                'urutan' => 3,
            ],
            [
                'nama' => 'TPA Baby Class Harapan Bunda',
                'slug' => 'tpa-baby-class-harapan-bunda',
                'singkatan' => 'TPA',
                'warna_bg' => 'bg-red-500',
                'logo' => 'images/logo-tpa.png',
                'banner' => 'images/banner-tpa.jpg',
                'deskripsi' => 'TPA Baby Class Harapan Bunda adalah tempat penitipan anak yang memberikan layanan pengasuhan dan pendidikan anak usia dini dengan pendekatan Islami. Dengan tenaga pengasuh yang profesional dan berpengalaman.',
                'visi' => 'Menjadi tempat penitipan anak terpercaya yang mengutamakan perkembangan optimal anak',
                'misi' => json_encode([
                    'Memberikan layanan pengasuhan yang profesional dan Islami',
                    'Menstimulasi perkembangan anak sesuai dengan tahapan usianya',
                    'Menciptakan lingkungan yang aman, nyaman, dan menyenangkan',
                    'Membangun kerjasama yang baik dengan orang tua'
                ]),
                'aktif' => true,
                'urutan' => 4,
            ],
            [
                'nama' => 'KB Harapan Bunda',
                'slug' => 'kb-harapan-bunda',
                'singkatan' => 'KB',
                'warna_bg' => 'bg-orange-500',
                'logo' => 'images/logo-kb.png',
                'banner' => 'images/banner-kb.jpg',
                'deskripsi' => 'Kelompok Bermain Harapan Bunda adalah lembaga pendidikan anak usia dini yang fokus pada pengembangan karakter dan keterampilan dasar anak melalui bermain. Dengan metode pembelajaran yang menyenangkan.',
                'visi' => 'Menjadi kelompok bermain yang unggul dalam pengembangan karakter anak usia dini',
                'misi' => json_encode([
                    'Mengembangkan potensi anak melalui metode bermain yang edukatif',
                    'Membentuk karakter anak yang mandiri dan percaya diri',
                    'Menstimulasi kreativitas dan imajinasi anak',
                    'Mempersiapkan anak untuk jenjang pendidikan selanjutnya'
                ]),
                'aktif' => true,
                'urutan' => 5,
            ],
            [
                'nama' => 'TK IT Harapan Bunda',
                'slug' => 'tk-it-harapan-bunda',
                'singkatan' => 'TK',
                'warna_bg' => 'bg-green-600',
                'logo' => 'images/logo-tk.png',
                'banner' => 'images/banner-tk.jpg',
                'deskripsi' => 'Taman Kanak-Kanak Islam Terpadu Harapan Bunda menyelenggarakan pendidikan dengan mengintegrasikan nilai-nilai Islam dalam setiap kegiatan pembelajaran. Dengan fasilitas yang lengkap dan tenaga pendidik yang berkualitas.',
                'visi' => 'Menjadi TK Islam Terpadu yang unggul dalam membentuk generasi Qurani',
                'misi' => json_encode([
                    'Menyelenggarakan pendidikan yang mengintegrasikan nilai-nilai Islam',
                    'Mengembangkan seluruh aspek perkembangan anak secara optimal',
                    'Membentuk karakter anak yang berakhlak mulia',
                    'Mempersiapkan anak untuk jenjang pendidikan dasar'
                ]),
                'aktif' => true,
                'urutan' => 6,
            ],
            [
                'nama' => 'SD IT Harapan Bunda 01',
                'slug' => 'sd-it-harapan-bunda-01',
                'singkatan' => 'SD1',
                'warna_bg' => 'bg-red-600',
                'logo' => 'images/logo-sd1.png',
                'banner' => 'images/banner-sd1.jpg',
                'deskripsi' => 'Sekolah Dasar Islam Terpadu Harapan Bunda 01 adalah lembaga pendidikan dasar yang mengintegrasikan kurikulum nasional dengan kurikulum Islam. Dengan tenaga pengajar yang profesional dan berpengalaman.',
                'visi' => 'Menjadi sekolah dasar Islam terpadu yang unggul dalam prestasi dan akhlak',
                'misi' => json_encode([
                    'Menyelenggarakan pendidikan yang berkualitas dengan pendekatan Islami',
                    'Mengembangkan potensi akademik dan non-akademik siswa',
                    'Membentuk karakter siswa yang berakhlakul karimah',
                    'Menciptakan lingkungan belajar yang kondusif dan Islami'
                ]),
                'aktif' => true,
                'urutan' => 7,
            ],
            [
                'nama' => 'SD IT Harapan Bunda 02',
                'slug' => 'sd-it-harapan-bunda-02',
                'singkatan' => 'SD2',
                'warna_bg' => 'bg-green-600',
                'logo' => 'images/logo-sd2.png',
                'banner' => 'images/banner-sd2.jpg',
                'deskripsi' => 'Sekolah Dasar Islam Terpadu Harapan Bunda 02 merupakan pengembangan dari SD IT Harapan Bunda 01 untuk melayani kebutuhan pendidikan yang semakin meningkat. Dengan fasilitas yang modern dan nyaman.',
                'visi' => 'Menjadi sekolah dasar Islam terpadu yang unggul dan berprestasi',
                'misi' => json_encode([
                    'Menyelenggarakan pendidikan berkualitas dengan pendekatan Islami',
                    'Mengoptimalkan potensi siswa dalam bidang akademik dan non-akademik',
                    'Membentuk siswa yang beriman, bertaqwa, dan berakhlak mulia',
                    'Membangun kerjasama yang baik dengan orang tua dan masyarakat'
                ]),
                'aktif' => true,
                'urutan' => 8,
            ],
            [
                'nama' => 'SMP IT Harapan Bunda',
                'slug' => 'smp-it-harapan-bunda',
                'singkatan' => 'SMP',
                'warna_bg' => 'bg-blue-600',
                'logo' => 'images/logo-smp.png',
                'banner' => 'images/banner-smp.jpg',
                'deskripsi' => 'Sekolah Menengah Pertama Islam Terpadu Harapan Bunda adalah jenjang pendidikan lanjutan yang tetap mempertahankan nilai-nilai Islam dalam setiap aspek pembelajaran. Dengan program unggulan yang mendukung prestasi siswa.',
                'visi' => 'Menjadi SMP Islam Terpadu yang unggul dalam prestasi dan berakhlakul karimah',
                'misi' => json_encode([
                    'Menyelenggarakan pendidikan yang berkualitas dengan pendekatan Islami',
                    'Mengembangkan potensi siswa secara optimal',
                    'Membentuk karakter siswa yang beriman, bertaqwa, dan berprestasi',
                    'Mempersiapkan siswa untuk melanjutkan ke jenjang pendidikan yang lebih tinggi'
                ]),
                'aktif' => true,
                'urutan' => 9,
            ],
        ];

        foreach ($data as $item) {
            Lembaga::updateOrCreate(
                ['slug' => $item['slug']],
                $item
            );
        }
    }
}

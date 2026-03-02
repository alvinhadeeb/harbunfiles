<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kontak;

class KontakSeeder extends Seeder
{
    public function run(): void
    {
        Kontak::updateOrCreate(
            ['id' => 1],
            [
                'tentang_deskripsi' => 'Yayasan Permata Hati Purwokerto awalnya bernama Yayasan Permata Ikat yang diubah pada tanggal 9 Agustus 1991. Sejak berdirinya, Yayasan Permata Hati memiliki kepatuhan dalam bidang pendidikan dan sosial kemasyarakatan',
                'telepon' => '0281523668',
                'email' => 'admin@lpiharapanbunda@gmail.com',
                'alamat' => 'Jl. KH. Wahid Hasyim Gang Pesantren, RT.04/RW.01, Windusara, Karanglesesm, Kec. Purwokerto Sel, Kabupaten Banyumas, Jawa Tengah 53144',
                'facebook_url' => '#',
                'instagram_url' => '#',
                'youtube_url' => '#',
                'whatsapp' => '088293841239',
            ]
        );
    }
}

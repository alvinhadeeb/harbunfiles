<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    public function run(): void
    {
        $banners = [
            ['judul' => 'News 1', 'gambar' => 'images/news1.png', 'urutan' => 1],
            ['judul' => 'News 2', 'gambar' => 'images/news2.png', 'urutan' => 2],
            ['judul' => 'News 3', 'gambar' => 'images/news3.png', 'urutan' => 3],
            ['judul' => 'News 4', 'gambar' => 'images/news4.png', 'urutan' => 4],
            ['judul' => 'News 5', 'gambar' => 'images/news5.png', 'urutan' => 5],
            ['judul' => 'News 6', 'gambar' => 'images/news6.png', 'urutan' => 6],
            ['judul' => 'News 7', 'gambar' => 'images/news7.jpeg', 'urutan' => 7],
        ];

        foreach ($banners as $data) {
            Banner::firstOrCreate(
                ['gambar' => $data['gambar']],
                array_merge($data, ['aktif' => true])
            );
        }
    }
}

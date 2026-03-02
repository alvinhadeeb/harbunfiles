<?php

namespace Database\Seeders;

use App\Models\Galeri;
use Illuminate\Database\Seeder;

class GaleriSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['judul' => 'Galeri 1', 'gambar' => 'images/news1.png', 'urutan' => 1],
            ['judul' => 'Galeri 2', 'gambar' => 'images/news2.png', 'urutan' => 2],
            ['judul' => 'Galeri 3', 'gambar' => 'images/news3.png', 'urutan' => 3],
            ['judul' => 'Galeri 4', 'gambar' => 'images/news4.png', 'urutan' => 4],
            ['judul' => 'Galeri 5', 'gambar' => 'images/news5.png', 'urutan' => 5],
            ['judul' => 'Galeri 6', 'gambar' => 'images/news6.png', 'urutan' => 6],
            ['judul' => 'Galeri 7', 'gambar' => 'images/news7.jpeg', 'urutan' => 7],
        ];

        foreach ($items as $data) {
            Galeri::firstOrCreate(
                ['gambar' => $data['gambar']],
                array_merge($data, ['aktif' => true])
            );
        }
    }
}

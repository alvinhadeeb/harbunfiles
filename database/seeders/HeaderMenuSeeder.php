<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HeaderMenu;

class HeaderMenuSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['label' => 'BERANDA', 'url' => '/', 'type' => 'link', 'is_new_tab' => false, 'aktif' => true, 'urutan' => 1],
            ['label' => 'PROFIL', 'url' => null, 'type' => 'dropdown_profil', 'is_new_tab' => false, 'aktif' => true, 'urutan' => 2],
            ['label' => 'PPDB', 'url' => 'https://ppdb.harbundpurwokerto.sch.id/', 'type' => 'link', 'is_new_tab' => true, 'aktif' => true, 'urutan' => 3],
            ['label' => 'KONTAK KAMI', 'url' => '/kontak', 'type' => 'link', 'is_new_tab' => false, 'aktif' => true, 'urutan' => 4],
        ];

        foreach ($items as $item) {
            HeaderMenu::updateOrCreate(
                ['label' => $item['label'], 'type' => $item['type']],
                $item
            );
        }
    }
}

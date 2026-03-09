<?php

namespace App\Http\Controllers;

use App\Models\Kontak;
use App\Models\Lembaga;
use Illuminate\Http\Request;

class KontakController extends Controller
{
    public function index()
    {
        // Ambil semua lembaga yang aktif dari database
        $lembagaRaw = Lembaga::where('aktif', true)
            ->orderBy('urutan')
            ->orderBy('nama')
            ->get();

        $lembagaList = $lembagaRaw->map(function($lembaga) {
                // Format data untuk compatibility dengan view
                $logoPath = $lembaga->logo
                    ? (str_starts_with($lembaga->logo, 'images/') 
                        ? '/' . $lembaga->logo 
                        : '/storage/' . $lembaga->logo)
                    : null;
                
                return [
                    'id' => $lembaga->id,
                    'name' => $lembaga->nama,
                    'slug' => $lembaga->slug,
                    'logo' => $logoPath,
                    'icon_color' => $lembaga->warna_bg ?? 'bg-blue-600',
                    'address' => $lembaga->footer_alamat ?? 'Jl. KH. Wahid Hasyim Gang Pesantren, RT.04/RW.01, Windusara, Karanglesesm, Kec. Purwokerto Sel, Kabupaten Banyumas, Jawa Tengah 53144',
                    'phone' => $lembaga->footer_telepon ?? '082929841239',
                    'linktree' => $lembaga->linktree,
                ];
            });
        
        $kontak = Kontak::first();
        $footerLembaga = $lembagaRaw;
        
        return view('kontak', compact('lembagaList', 'kontak', 'footerLembaga'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Berita;
use App\Models\Kategori;
use App\Models\Lembaga;

class LembagaController extends Controller
{
    public function show($slug)
    {
        $lembaga = Lembaga::where('slug', $slug)->firstOrFail();

        // Ambil berita terbaru milik lembaga ini (many-to-many)
        $beritaTerbaru = Berita::where('status', 'published')
            ->whereHas('lembagas', function ($q) use ($lembaga) {
                $q->where('lembaga.id', $lembaga->id);
            })
            ->orderByDesc('tanggal')
            ->take(5)
            ->get();

        // Kategori berita
        $kategoriList = Kategori::orderBy('nama')->pluck('nama');

        return view('lembaga.show', compact('lembaga', 'beritaTerbaru', 'kategoriList'));
    }
}


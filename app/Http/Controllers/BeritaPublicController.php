<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Berita;
use App\Models\Kategori;
use App\Models\Lembaga;

class BeritaPublicController extends Controller
{
    public function index(Request $request)
    {
        $query = Berita::where('status', 'published');

        // Filter by kategori if provided
        if ($request->has('kategori') && $request->kategori) {
            $query->where('kategori', $request->kategori);
        }

        // Filter by lembaga if provided
        $lembagaFilter = null;
        if ($request->has('lembaga') && $request->lembaga) {
            $lembagaFilter = Lembaga::find($request->lembaga);
            if ($lembagaFilter) {
                $query->whereHas('lembagas', function ($q) use ($lembagaFilter) {
                    $q->where('lembaga.id', $lembagaFilter->id);
                });
            }
        }

        $berita = $query->orderByDesc('tanggal')->paginate(6)->withQueryString();

        // Get all categories from database for sidebar
        $kategoriList = Kategori::orderBy('nama')->pluck('nama');

        // Get latest 5 berita for sidebar "Informasi Terbaru"
        $beritaTerbaru = Berita::where('status', 'published')
            ->orderByDesc('tanggal')
            ->take(5)
            ->get();

        return view('berita.index', compact('berita', 'kategoriList', 'beritaTerbaru', 'lembagaFilter'));
    }

    public function show($slug)
    {
        $berita = Berita::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        // Get latest 5 berita for sidebar
        $beritaTerbaru = Berita::where('status', 'published')
            ->where('id', '!=', $berita->id)
            ->orderByDesc('tanggal')
            ->take(5)
            ->get();

        $kategoriList = Kategori::orderBy('nama')->pluck('nama');

        return view('berita.show', compact('berita', 'beritaTerbaru', 'kategoriList'));
    }
}

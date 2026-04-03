<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Berita;
use App\Models\Kategori;
use App\Models\Lembaga;
use App\Models\Banner;

class BeritaPublicController extends Controller
{
    public function index(Request $request)
    {
        $query = Berita::with('admin')->where('status', 'published');

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
        $beritaTerbaru = Berita::with('admin')
            ->where('status', 'published')
            ->orderByDesc('tanggal')
            ->take(5)
            ->get();

        return view('berita.index', compact('berita', 'kategoriList', 'beritaTerbaru', 'lembagaFilter'));
    }

    public function show($slug)
    {
        $berita = Berita::with('admin')
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        $bannerFallback = Banner::where('aktif', true)->orderBy('urutan')->first();
        $bannerFallbackImage = $bannerFallback && $bannerFallback->gambar
            ? (str_starts_with($bannerFallback->gambar, 'images/') ? asset($bannerFallback->gambar) : asset('storage/' . $bannerFallback->gambar))
            : asset('images/logo-hb.png');

        // Get latest 5 berita for sidebar
        $beritaTerbaru = Berita::with('admin')
            ->where('status', 'published')
            ->where('id', '!=', $berita->id)
            ->orderByDesc('tanggal')
            ->take(5)
            ->get();

        $kategoriList = Kategori::orderBy('nama')->pluck('nama');

        return view('berita.show', compact('berita', 'beritaTerbaru', 'kategoriList', 'bannerFallbackImage'));
    }
}

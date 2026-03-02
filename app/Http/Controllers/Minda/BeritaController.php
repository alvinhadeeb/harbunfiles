<?php

namespace App\Http\Controllers\Minda;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Berita;
use App\Models\Kategori;
use App\Models\Lembaga;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BeritaController extends Controller
{
    public function index()
    {
        $berita = Berita::with('lembaga')->orderByDesc('tanggal')->paginate(10);
        return view('minda.berita.index', compact('berita'));
    }

    public function create()
    {
        $kategoriList = Kategori::orderBy('nama')->get();
        $lembagaList = Lembaga::where('aktif', true)->orderBy('urutan')->get();
        return view('minda.berita.create', compact('kategoriList', 'lembagaList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|max:255',
            'konten' => 'required',
            'kategori' => 'required',
            'gambar' => 'nullable|image|max:2048',
            'status' => 'required|in:draft,published',
            'lembaga_id' => 'nullable|exists:lembaga,id',
            'tanggal' => 'nullable|date',
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('berita', 'public');
        }

        $validated['slug'] = Str::slug($validated['judul']);
        $validated['lembaga_id'] = $request->lembaga_id ?: null;

        Berita::create($validated);

        return redirect()->route('minda.berita.index')->with('success', 'Berita berhasil ditambahkan');
    }

    public function edit(string $id)
    {
        $berita = Berita::findOrFail($id);
        $kategoriList = Kategori::orderBy('nama')->get();
        $lembagaList = Lembaga::where('aktif', true)->orderBy('urutan')->get();
        return view('minda.berita.edit', compact('berita', 'kategoriList', 'lembagaList'));
    }

    public function update(Request $request, string $id)
    {
        $berita = Berita::findOrFail($id);
        
        $validated = $request->validate([
            'judul' => 'required|max:255',
            'konten' => 'required',
            'kategori' => 'required',
            'gambar' => 'nullable|image|max:2048',
            'status' => 'required|in:draft,published',
            'lembaga_id' => 'nullable|exists:lembaga,id',
            'tanggal' => 'nullable|date',
        ]);

        if ($request->hasFile('gambar')) {
            if ($berita->gambar) {
                Storage::disk('public')->delete($berita->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('berita', 'public');
        }

        $validated['slug'] = Str::slug($validated['judul']);
        $validated['lembaga_id'] = $request->lembaga_id ?: null;

        $berita->update($validated);

        return redirect()->route('minda.berita.index')->with('success', 'Berita berhasil diupdate');
    }

    public function destroy(string $id)
    {
        $berita = Berita::findOrFail($id);
        
        if ($berita->gambar) {
            Storage::disk('public')->delete($berita->gambar);
        }
        
        $berita->delete();

        return redirect()->route('minda.berita.index')->with('success', 'Berita berhasil dihapus');
    }
}

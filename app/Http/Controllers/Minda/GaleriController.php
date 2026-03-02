<?php

namespace App\Http\Controllers\Minda;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GaleriController extends Controller
{
    public function index()
    {
        $galeri = Galeri::orderBy('urutan')->orderBy('created_at', 'desc')->get();
        return view('minda.galeri.index', compact('galeri'));
    }

    public function create()
    {
        return view('minda.galeri.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'gambar' => 'required|image|max:5120',
            'aktif' => 'nullable',
            'urutan' => 'nullable|integer',
        ]);

        $validated['gambar'] = $request->file('gambar')->store('galeri', 'public');
        $validated['aktif'] = $request->has('aktif');
        $validated['urutan'] = $validated['urutan'] ?? 0;
        $validated['judul'] = 'Galeri';

        Galeri::create($validated);

        return redirect()->route('minda.galeri.index')->with('success', 'Foto galeri berhasil ditambahkan');
    }

    public function edit(string $id)
    {
        $galeri = Galeri::findOrFail($id);
        return view('minda.galeri.edit', compact('galeri'));
    }

    public function update(Request $request, string $id)
    {
        $galeri = Galeri::findOrFail($id);

        $validated = $request->validate([
            'gambar' => 'nullable|image|max:5120',
            'aktif' => 'nullable',
            'urutan' => 'nullable|integer',
        ]);

        if ($request->hasFile('gambar')) {
            if ($galeri->gambar && !str_starts_with($galeri->gambar, 'images/')) {
                Storage::disk('public')->delete($galeri->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('galeri', 'public');
        } else {
            unset($validated['gambar']);
        }

        $validated['aktif'] = $request->has('aktif');
        $validated['urutan'] = $validated['urutan'] ?? 0;

        $galeri->update($validated);

        return redirect()->route('minda.galeri.index')->with('success', 'Foto galeri berhasil diupdate');
    }

    public function destroy(string $id)
    {
        $galeri = Galeri::findOrFail($id);

        if ($galeri->gambar && !str_starts_with($galeri->gambar, 'images/')) {
            Storage::disk('public')->delete($galeri->gambar);
        }

        $galeri->delete();

        return redirect()->route('minda.galeri.index')->with('success', 'Foto galeri berhasil dihapus');
    }
}

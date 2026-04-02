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
    /**
     * Ambil daftar lembaga yang boleh diakses admin saat ini
     */
    private function getAllowedLembagaIds(): ?array
    {
        $admin = auth()->guard('admin')->user();
        return $admin ? $admin->getAllowedLembagaIds() : null;
    }

    public function index(Request $request)
    {
        $allowedLembaga = $this->getAllowedLembagaIds();

        $query = Berita::with(['lembagas', 'admin'])->orderByDesc('tanggal');

        // Filter berita berdasarkan lembaga yang diizinkan
        if ($allowedLembaga !== null) {
            $query->whereHas('lembagas', function ($sub) use ($allowedLembaga) {
                $sub->whereIn('lembaga.id', $allowedLembaga);
            });
        }

        $berita = $query->paginate(10);
        // Simpan halaman terakhir di session
        session(['berita_last_page' => $request->get('page', 1)]);
        return view('minda.berita.index', compact('berita'));
    }

    public function create()
    {
        $kategoriList = Kategori::orderBy('nama')->get();
        $allowedLembaga = $this->getAllowedLembagaIds();
        $lembagaList = Lembaga::where('aktif', true)->orderBy('urutan')
            ->when($allowedLembaga, fn($q) => $q->whereIn('id', $allowedLembaga))
            ->get();
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
            'lembaga_ids' => 'nullable|array',
            'lembaga_ids.*' => 'exists:lembaga,id',
            'tanggal' => 'nullable|date',
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('berita', 'public');
        }

        $validated['slug'] = Str::slug($validated['judul']);
        $validated['admin_id'] = auth()->guard('admin')->id();
        
        // Hapus lembaga_ids dari validated (bukan kolom di tabel berita)
        $lembagaIds = $request->input('lembaga_ids', []);
        unset($validated['lembaga_ids']);

        $berita = Berita::create($validated);
        
        // Sync lembaga (many-to-many)
        $berita->lembagas()->sync($lembagaIds);

        return redirect()->route('minda.berita.index', ['page' => session('berita_last_page', 1)])->with('success', 'Berita berhasil ditambahkan');
    }

    public function edit(string $id)
    {
        $berita = Berita::with(['lembagas', 'admin'])->findOrFail($id);
        $kategoriList = Kategori::orderBy('nama')->get();
        $allowedLembaga = $this->getAllowedLembagaIds();
        $lembagaList = Lembaga::where('aktif', true)->orderBy('urutan')
            ->when($allowedLembaga, fn($q) => $q->whereIn('id', $allowedLembaga))
            ->get();
        $selectedLembagas = $berita->lembagas->pluck('id')->toArray();
        return view('minda.berita.edit', compact('berita', 'kategoriList', 'lembagaList', 'selectedLembagas'));
    }

    public function update(Request $request, string $id)
    {
        $berita = Berita::with('admin')->findOrFail($id);
        
        $validated = $request->validate([
            'judul' => 'required|max:255',
            'konten' => 'required',
            'kategori' => 'required',
            'gambar' => 'nullable|image|max:2048',
            'status' => 'required|in:draft,published',
            'lembaga_ids' => 'nullable|array',
            'lembaga_ids.*' => 'exists:lembaga,id',
            'tanggal' => 'nullable|date',
        ]);

        if ($request->hasFile('gambar')) {
            if ($berita->gambar) {
                Storage::disk('public')->delete($berita->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('berita', 'public');
        }

        $validated['slug'] = Str::slug($validated['judul']);
        
        // Hapus lembaga_ids dari validated (bukan kolom di tabel berita)
        $lembagaIds = $request->input('lembaga_ids', []);
        unset($validated['lembaga_ids']);

        $berita->update($validated);
        
        // Sync lembaga (many-to-many)
        $berita->lembagas()->sync($lembagaIds);

        return redirect()->route('minda.berita.index', ['page' => session('berita_last_page', 1)])->with('success', 'Berita berhasil diupdate');
    }

    public function destroy(string $id)
    {
        $berita = Berita::findOrFail($id);
        
        if ($berita->gambar) {
            Storage::disk('public')->delete($berita->gambar);
        }
        
        $berita->delete();

        return redirect()->route('minda.berita.index', ['page' => session('berita_last_page', 1)])->with('success', 'Berita berhasil dihapus');
    }
}

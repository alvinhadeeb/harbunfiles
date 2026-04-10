<?php

namespace App\Http\Controllers\Minda;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Berita;
use App\Models\Kategori;
use App\Models\Lembaga;
use App\Support\FileUpload;
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
            'gambar' => 'nullable|file|extensions:jpg,jpeg,png,gif,webp,avif,svg|max:2048',
            'inline_images' => 'nullable|array|max:3',
            'inline_images.*' => 'file|extensions:jpg,jpeg,png,gif,webp,avif,svg|max:4096',
            'status' => 'required|in:draft,published',
            'lembaga_ids' => 'nullable|array',
            'lembaga_ids.*' => 'exists:lembaga,id',
            'tanggal' => 'nullable|date',
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = FileUpload::storePublic($request->file('gambar'), 'berita');
        }

        $validated['slug'] = Str::slug($validated['judul']);
        $validated['admin_id'] = auth()->guard('admin')->id();
        
        // Hapus lembaga_ids dari validated (bukan kolom di tabel berita)
        $lembagaIds = $request->input('lembaga_ids', []);
        unset($validated['lembaga_ids']);
        unset($validated['inline_images']);

        $berita = Berita::create($validated);
        
        // Sync lembaga (many-to-many)
        $berita->lembagas()->sync($lembagaIds);

        // Simpan foto-foto sisipan (jika ada)
        $this->storeInlineImages($berita, $request->file('inline_images', []));

        return redirect()->route('minda.berita.index', ['page' => session('berita_last_page', 1)])->with('success', 'Berita berhasil ditambahkan');
    }

    public function edit(string $id)
    {
        $berita = Berita::with(['lembagas', 'admin', 'inlineImages'])->findOrFail($id);
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
            'gambar' => 'nullable|file|extensions:jpg,jpeg,png,gif,webp,avif,svg|max:2048',
            'inline_images' => 'nullable|array|max:3',
            'inline_images.*' => 'file|extensions:jpg,jpeg,png,gif,webp,avif,svg|max:4096',
            'inline_image_order' => 'nullable|array',
            'inline_image_order.*' => 'integer',
            'remove_inline_image_ids' => 'nullable|array',
            'remove_inline_image_ids.*' => 'integer',
            'status' => 'required|in:draft,published',
            'lembaga_ids' => 'nullable|array',
            'lembaga_ids.*' => 'exists:lembaga,id',
            'tanggal' => 'nullable|date',
        ]);

        if ($request->hasFile('gambar')) {
            if ($berita->gambar) {
                Storage::disk('public')->delete($berita->gambar);
            }
            $validated['gambar'] = FileUpload::storePublic($request->file('gambar'), 'berita');
        }

        $validated['slug'] = Str::slug($validated['judul']);
        
        // Hapus lembaga_ids dari validated (bukan kolom di tabel berita)
        $lembagaIds = $request->input('lembaga_ids', []);
        unset($validated['lembaga_ids']);
        unset($validated['inline_images']);
        unset($validated['inline_image_order']);
        unset($validated['remove_inline_image_ids']);

        $berita->update($validated);
        
        // Sync lembaga (many-to-many)
        $berita->lembagas()->sync($lembagaIds);

        // Hapus foto sisipan yang dipilih
        $removeIds = collect($request->input('remove_inline_image_ids', []))
            ->map(fn ($id) => (int) $id)
            ->filter()
            ->values();

        if ($removeIds->isNotEmpty()) {
            $imagesToDelete = $berita->inlineImages()->whereIn('id', $removeIds)->get();
            foreach ($imagesToDelete as $inlineImage) {
                Storage::disk('public')->delete($inlineImage->path);
                $inlineImage->delete();
            }
            // Refresh relationship cache after deletion
            $berita->load('inlineImages');
        }

        // Simpan urutan foto sisipan manual dari admin
        $orderedIds = collect($request->input('inline_image_order', []))
            ->map(fn ($id) => (int) $id)
            ->filter()
            ->values();

        if ($orderedIds->isNotEmpty()) {
            $existingIds = $berita->inlineImages()->pluck('id');
            $filteredOrder = $orderedIds->filter(fn ($id) => $existingIds->contains($id))->values();

            foreach ($filteredOrder as $index => $imageId) {
                $berita->inlineImages()->where('id', $imageId)->update(['urutan' => $index + 1]);
            }
        }

        // Tambah foto sisipan baru
        $allInlineImages = $request->file('inline_images') ?? [];
        if (is_array($allInlineImages)) {
            $this->storeInlineImages($berita, $allInlineImages);
        }

        return redirect()->route('minda.berita.edit', $berita->id)->with('success', 'Berita berhasil diupdate');
    }

    public function destroy(string $id)
    {
        $berita = Berita::with('inlineImages')->findOrFail($id);
        
        if ($berita->gambar) {
            Storage::disk('public')->delete($berita->gambar);
        }

        foreach ($berita->inlineImages as $inlineImage) {
            Storage::disk('public')->delete($inlineImage->path);
        }
        
        $berita->delete();

        return redirect()->route('minda.berita.index', ['page' => session('berita_last_page', 1)])->with('success', 'Berita berhasil dihapus');
    }

    /**
     * Simpan foto-foto sisipan berita dengan urutan berlanjut.
     */
    private function storeInlineImages(Berita $berita, array $inlineImages): void
    {
        // Filter out null/empty values dari array
        $validImages = array_filter($inlineImages, fn($img) => $img !== null && $img !== false);
        
        if (empty($validImages)) {
            return;
        }

        // Hitung urutan mulai dari existing images
        $maxOrder = $berita->inlineImages()->max('urutan');
        $nextOrder = ($maxOrder ? (int) $maxOrder : 0) + 1;

        foreach ($validImages as $inlineImage) {
            if (!$inlineImage) {
                continue;
            }

            $path = FileUpload::storePublic($inlineImage, 'berita/inline');
            $berita->inlineImages()->create([
                'path' => $path,
                'urutan' => $nextOrder,
            ]);
            $nextOrder++;
        }
    }
}

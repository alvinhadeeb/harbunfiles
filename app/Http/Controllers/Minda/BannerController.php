<?php

namespace App\Http\Controllers\Minda;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::orderBy('urutan')->orderBy('created_at', 'desc')->get();
        return view('minda.banner.index', compact('banners'));
    }

    public function create()
    {
        return view('minda.banner.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'nullable|max:255',
            'gambar' => 'required|image|max:5120',
            'aktif' => 'nullable',
            'urutan' => 'nullable|integer',
        ]);

        $validated['gambar'] = $request->file('gambar')->store('banner', 'public');
        $validated['aktif'] = $request->has('aktif');
        $validated['urutan'] = $validated['urutan'] ?? 0;

        Banner::create($validated);

        return redirect()->route('minda.banner.index')->with('success', 'Banner berhasil ditambahkan');
    }

    public function edit(string $id)
    {
        $banner = Banner::findOrFail($id);
        return view('minda.banner.edit', compact('banner'));
    }

    public function update(Request $request, string $id)
    {
        $banner = Banner::findOrFail($id);

        $validated = $request->validate([
            'judul' => 'nullable|max:255',
            'gambar' => 'nullable|image|max:5120',
            'aktif' => 'nullable',
            'urutan' => 'nullable|integer',
        ]);

        if ($request->hasFile('gambar')) {
            // Delete old image if it's stored in storage (not public/images)
            if ($banner->gambar && !str_starts_with($banner->gambar, 'images/')) {
                Storage::disk('public')->delete($banner->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('banner', 'public');
        } else {
            unset($validated['gambar']);
        }

        $validated['aktif'] = $request->has('aktif');
        $validated['urutan'] = $validated['urutan'] ?? 0;

        $banner->update($validated);

        return redirect()->route('minda.banner.index')->with('success', 'Banner berhasil diupdate');
    }

    public function destroy(string $id)
    {
        $banner = Banner::findOrFail($id);

        if ($banner->gambar && !str_starts_with($banner->gambar, 'images/')) {
            Storage::disk('public')->delete($banner->gambar);
        }

        $banner->delete();

        return redirect()->route('minda.banner.index')->with('success', 'Banner berhasil dihapus');
    }
}

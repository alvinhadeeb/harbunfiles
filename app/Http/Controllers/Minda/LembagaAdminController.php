<?php

namespace App\Http\Controllers\Minda;

use App\Http\Controllers\Controller;
use App\Models\Lembaga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LembagaAdminController extends Controller
{
    public function index()
    {
        $lembaga = Lembaga::orderBy('urutan')->orderBy('nama')->get();
        return view('minda.lembaga.index', compact('lembaga'));
    }

    public function create()
    {
        return view('minda.lembaga.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|max:255',
            'logo' => 'nullable|image|max:2048',
            'banner' => 'nullable|image|max:5120',
            'banner_rasio' => 'nullable|in:3:1,16:9,2:1,bebas',
            'banner_judul' => 'nullable|max:255',
            'banner_subjudul' => 'nullable|max:255',
            'banner_kutipan' => 'nullable',
            'deskripsi' => 'nullable',
            'visi' => 'nullable',
            'misi' => 'nullable',
            'aktif' => 'nullable',
            'instagram' => 'nullable|max:255',
            'facebook' => 'nullable|max:255',
            'youtube' => 'nullable|max:255',
            'tiktok' => 'nullable|max:255',
            'website' => 'nullable|max:255',
            'linktree' => 'nullable|url|max:255',
            'footer' => 'nullable',
            'footer_telepon' => 'nullable|max:255',
            'footer_email' => 'nullable|email|max:255',
            'footer_alamat' => 'nullable',
            'footer_whatsapp' => 'nullable|max:255',
        ]);

        $validated['slug'] = Str::slug($validated['nama']);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('lembaga/logo', 'public');
        }
        if ($request->hasFile('banner')) {
            $validated['banner'] = $request->file('banner')->store('lembaga/banner', 'public');
        }

        // Parse misi from textarea (one per line)
        if (!empty($validated['misi'])) {
            $validated['misi'] = array_filter(array_map('trim', explode("\n", $validated['misi'])));
        }

        $validated['aktif'] = $request->has('aktif');

        Lembaga::create($validated);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'redirect' => route('minda.lembaga.index')]);
        }
        return redirect()->route('minda.lembaga.index')->with('success', 'Lembaga berhasil ditambahkan');
    }

    public function edit(string $id)
    {
        $lembaga = Lembaga::findOrFail($id);
        return view('minda.lembaga.edit', compact('lembaga'));
    }

    public function update(Request $request, string $id)
    {
        $lembaga = Lembaga::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|max:255',
            'logo' => 'nullable|image|max:2048',
            'banner' => 'nullable|image|max:5120',
            'banner_rasio' => 'nullable|in:3:1,16:9,2:1,bebas',
            'banner_judul' => 'nullable|max:255',
            'banner_subjudul' => 'nullable|max:255',
            'banner_kutipan' => 'nullable',
            'deskripsi' => 'nullable',
            'visi' => 'nullable',
            'misi' => 'nullable',
            'aktif' => 'nullable',
            'instagram' => 'nullable|max:255',
            'facebook' => 'nullable|max:255',
            'youtube' => 'nullable|max:255',
            'tiktok' => 'nullable|max:255',
            'website' => 'nullable|max:255',
            'linktree' => 'nullable|url|max:255',
            'footer' => 'nullable',
            'footer_telepon' => 'nullable|max:255',
            'footer_email' => 'nullable|email|max:255',
            'footer_alamat' => 'nullable',
            'footer_whatsapp' => 'nullable|max:255',
        ]);

        if ($request->hasFile('logo')) {
            if ($lembaga->logo && !str_starts_with($lembaga->logo, 'images/')) {
                Storage::disk('public')->delete($lembaga->logo);
            }
            $validated['logo'] = $request->file('logo')->store('lembaga/logo', 'public');
        } else {
            unset($validated['logo']);
        }

        if ($request->hasFile('banner')) {
            if ($lembaga->banner && !str_starts_with($lembaga->banner, 'images/')) {
                Storage::disk('public')->delete($lembaga->banner);
            }
            $validated['banner'] = $request->file('banner')->store('lembaga/banner', 'public');
        } else {
            unset($validated['banner']);
        }

        // Parse misi from textarea (one per line)
        if (!empty($validated['misi'])) {
            $validated['misi'] = array_filter(array_map('trim', explode("\n", $validated['misi'])));
        } else {
            $validated['misi'] = [];
        }

        $validated['aktif'] = $request->has('aktif');

        $lembaga->update($validated);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'redirect' => route('minda.lembaga.edit', $lembaga->id)]);
        }
        return redirect()->route('minda.lembaga.edit', $lembaga->id)->with('success', 'Lembaga berhasil diupdate');
    }

    public function reorder(Request $request)
    {
        $order = $request->input('order', []);
        foreach ($order as $index => $id) {
            Lembaga::where('id', $id)->update(['urutan' => $index + 1]);
        }
        return response()->json(['success' => true]);
    }

    public function destroy(string $id)
    {
        $lembaga = Lembaga::findOrFail($id);

        if ($lembaga->logo && !str_starts_with($lembaga->logo, 'images/')) {
            Storage::disk('public')->delete($lembaga->logo);
        }
        if ($lembaga->banner && !str_starts_with($lembaga->banner, 'images/')) {
            Storage::disk('public')->delete($lembaga->banner);
        }

        $lembaga->delete();

        return redirect()->route('minda.lembaga.index')->with('success', 'Lembaga berhasil dihapus');
    }
}

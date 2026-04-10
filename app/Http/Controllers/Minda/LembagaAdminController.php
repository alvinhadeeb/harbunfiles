<?php

namespace App\Http\Controllers\Minda;

use App\Http\Controllers\Controller;
use App\Models\Lembaga;
use App\Support\FileUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LembagaAdminController extends Controller
{
    /**
     * Ambil daftar lembaga yang boleh diakses admin saat ini
     */
    private function getAllowedLembagaQuery()
    {
        $admin = auth()->guard('admin')->user();
        $allowedIds = $admin->getAllowedLembagaIds();

        $query = Lembaga::orderBy('urutan')->orderBy('nama');
        if ($allowedIds !== null) {
            $query->whereIn('id', $allowedIds);
        }
        return $query;
    }

    /**
     * Cek apakah admin boleh akses lembaga tertentu
     */
    private function checkAccess(Lembaga $lembaga): void
    {
        $admin = auth()->guard('admin')->user();
        if (!$admin->canAccessLembaga($lembaga->id)) {
            abort(403, 'Anda tidak memiliki akses ke lembaga ini.');
        }
    }

    public function index()
    {
        $admin = auth()->guard('admin')->user();
        $lembaga = $this->getAllowedLembagaQuery()->get();
        $isRestricted = $admin->getAllowedLembagaIds() !== null;
        return view('minda.lembaga.index', compact('lembaga', 'isRestricted'));
    }

    public function create()
    {
        $admin = auth()->guard('admin')->user();
        // Admin yang dibatasi lembaga-nya tidak boleh membuat lembaga baru
        if ($admin->getAllowedLembagaIds() !== null) {
            abort(403, 'Anda tidak memiliki akses untuk menambah lembaga baru.');
        }
        return view('minda.lembaga.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|max:255',
            'logo' => 'nullable|file|extensions:jpg,jpeg,png,gif,webp,avif,svg|max:2048',
            'banner' => 'nullable|file|extensions:jpg,jpeg,png,gif,webp,avif,svg|max:5120',
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
            $validated['logo'] = FileUpload::storePublic($request->file('logo'), 'lembaga/logo');
        }
        if ($request->hasFile('banner')) {
            $validated['banner'] = FileUpload::storePublic($request->file('banner'), 'lembaga/banner');
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
        $this->checkAccess($lembaga);
        return view('minda.lembaga.edit', compact('lembaga'));
    }

    public function update(Request $request, string $id)
    {
        $lembaga = Lembaga::findOrFail($id);
        $this->checkAccess($lembaga);

        $validated = $request->validate([
            'nama' => 'required|max:255',
            'logo' => 'nullable|file|extensions:jpg,jpeg,png,gif,webp,avif,svg|max:2048',
            'banner' => 'nullable|file|extensions:jpg,jpeg,png,gif,webp,avif,svg|max:5120',
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
            $validated['logo'] = FileUpload::storePublic($request->file('logo'), 'lembaga/logo');
        } else {
            unset($validated['logo']);
        }

        if ($request->hasFile('banner')) {
            if ($lembaga->banner && !str_starts_with($lembaga->banner, 'images/')) {
                Storage::disk('public')->delete($lembaga->banner);
            }
            $validated['banner'] = FileUpload::storePublic($request->file('banner'), 'lembaga/banner');
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
        $this->checkAccess($lembaga);

        // Admin yang dibatasi tidak boleh hapus lembaga
        $admin = auth()->guard('admin')->user();
        if ($admin->getAllowedLembagaIds() !== null) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus lembaga.');
        }

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

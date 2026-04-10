<?php

namespace App\Http\Controllers\Minda;

use App\Http\Controllers\Controller;
use App\Models\Testimoni;
use App\Support\FileUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimoniController extends Controller
{
    public function index()
    {
        $testimoni = Testimoni::orderBy('urutan')->orderBy('created_at', 'desc')->get();
        return view('minda.testimoni.index', compact('testimoni'));
    }

    public function create()
    {
        return view('minda.testimoni.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|max:255',
            'jabatan' => 'nullable|max:255',
            'isi' => 'required',
            'foto' => 'nullable|file|extensions:jpg,jpeg,png,gif,webp,avif,svg|max:2048',
            'aktif' => 'nullable',
            'urutan' => 'nullable|integer',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = FileUpload::storePublic($request->file('foto'), 'testimoni');
        }

        $validated['aktif'] = $request->has('aktif');
        $validated['urutan'] = $validated['urutan'] ?? 0;

        Testimoni::create($validated);

        return redirect()->route('minda.testimoni.index')->with('success', 'Testimoni berhasil ditambahkan');
    }

    public function edit(string $id)
    {
        $testimoni = Testimoni::findOrFail($id);
        return view('minda.testimoni.edit', compact('testimoni'));
    }

    public function update(Request $request, string $id)
    {
        $testimoni = Testimoni::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|max:255',
            'jabatan' => 'nullable|max:255',
            'isi' => 'required',
            'foto' => 'nullable|file|extensions:jpg,jpeg,png,gif,webp,avif,svg|max:2048',
            'aktif' => 'nullable',
            'urutan' => 'nullable|integer',
        ]);

        if ($request->hasFile('foto')) {
            if ($testimoni->foto) {
                Storage::disk('public')->delete($testimoni->foto);
            }
            $validated['foto'] = FileUpload::storePublic($request->file('foto'), 'testimoni');
        }

        $validated['aktif'] = $request->has('aktif');
        $validated['urutan'] = $validated['urutan'] ?? 0;

        $testimoni->update($validated);

        return redirect()->route('minda.testimoni.index')->with('success', 'Testimoni berhasil diupdate');
    }

    public function destroy(string $id)
    {
        $testimoni = Testimoni::findOrFail($id);

        if ($testimoni->foto) {
            Storage::disk('public')->delete($testimoni->foto);
        }

        $testimoni->delete();

        return redirect()->route('minda.testimoni.index')->with('success', 'Testimoni berhasil dihapus');
    }
}

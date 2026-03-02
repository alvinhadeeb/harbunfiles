<?php

namespace App\Http\Controllers\Minda;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        $faq = Faq::orderBy('urutan')->orderBy('created_at', 'desc')->get();
        return view('minda.faq.index', compact('faq'));
    }

    public function create()
    {
        return view('minda.faq.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pertanyaan' => 'required|max:500',
            'jawaban' => 'required',
            'aktif' => 'nullable',
            'urutan' => 'nullable|integer',
        ]);

        $validated['aktif'] = $request->has('aktif');
        $validated['urutan'] = $validated['urutan'] ?? 0;

        Faq::create($validated);

        return redirect()->route('minda.faq.index')->with('success', 'FAQ berhasil ditambahkan');
    }

    public function edit(string $id)
    {
        $faq = Faq::findOrFail($id);
        return view('minda.faq.edit', compact('faq'));
    }

    public function update(Request $request, string $id)
    {
        $faq = Faq::findOrFail($id);

        $validated = $request->validate([
            'pertanyaan' => 'required|max:500',
            'jawaban' => 'required',
            'aktif' => 'nullable',
            'urutan' => 'nullable|integer',
        ]);

        $validated['aktif'] = $request->has('aktif');
        $validated['urutan'] = $validated['urutan'] ?? 0;

        $faq->update($validated);

        return redirect()->route('minda.faq.index')->with('success', 'FAQ berhasil diupdate');
    }

    public function destroy(string $id)
    {
        $faq = Faq::findOrFail($id);
        $faq->delete();

        return redirect()->route('minda.faq.index')->with('success', 'FAQ berhasil dihapus');
    }
}

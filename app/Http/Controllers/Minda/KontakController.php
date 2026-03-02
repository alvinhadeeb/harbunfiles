<?php

namespace App\Http\Controllers\Minda;

use App\Http\Controllers\Controller;
use App\Models\Kontak;
use Illuminate\Http\Request;

class KontakController extends Controller
{
    public function edit()
    {
        $kontak = Kontak::getInstance();
        return view('minda.kontak.edit', compact('kontak'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'tentang_deskripsi' => 'required|string',
            'telepon' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'alamat' => 'required|string',
            'facebook_url' => 'nullable|url|max:255',
            'instagram_url' => 'nullable|url|max:255',
            'youtube_url' => 'nullable|url|max:255',
            'whatsapp' => 'nullable|string|max:20',
        ]);

        $kontak = Kontak::getInstance();
        $kontak->update($validated);

        return redirect()->route('minda.kontak.edit')->with('success', 'Informasi kontak berhasil diperbarui!');
    }
}

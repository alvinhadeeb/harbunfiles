<?php

namespace App\Http\Controllers\Minda;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\HeaderMenu;
use App\Models\HeaderSetting;

class HeaderMenuController extends Controller
{
    public function index()
    {
        $menus = HeaderMenu::orderBy('urutan')->get();
        $headerSetting = HeaderSetting::getInstance();
        return view('minda.header.index', compact('menus', 'headerSetting'));
    }

    public function updateLogo(Request $request)
    {
        $request->validate([
            'logo' => 'required|image|max:2048',
        ]);

        $setting = HeaderSetting::getInstance();
        if ($setting->logo) {
            Storage::disk('public')->delete($setting->logo);
        }
        $path = $request->file('logo')->store('header', 'public');
        $setting->update(['logo' => $path]);

        return redirect()->route('minda.header.index')->with('success', 'Foto/logo header berhasil diunggah.');
    }

    public function removeLogo()
    {
        $setting = HeaderSetting::getInstance();
        if ($setting->logo) {
            Storage::disk('public')->delete($setting->logo);
            $setting->update(['logo' => null]);
        }
        return redirect()->route('minda.header.index')->with('success', 'Foto/logo header berhasil dihapus.');
    }

    public function create()
    {
        return view('minda.header.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'label' => 'required|max:100',
            'type' => 'required|in:link,dropdown_profil',
            'url' => 'nullable|max:500',
            'is_new_tab' => 'boolean',
            'aktif' => 'boolean',
        ]);

        if (($validated['type'] ?? '') === 'dropdown_profil') {
            $validated['url'] = null;
            $validated['is_new_tab'] = false;
        }

        $validated['is_new_tab'] = $request->boolean('is_new_tab');
        $validated['aktif'] = $request->boolean('aktif');
        $validated['urutan'] = HeaderMenu::max('urutan') + 1;

        HeaderMenu::create($validated);

        return redirect()->route('minda.header.index')->with('success', 'Menu header berhasil ditambahkan');
    }

    public function edit(string $id)
    {
        $menu = HeaderMenu::findOrFail($id);
        return view('minda.header.edit', compact('menu'));
    }

    public function update(Request $request, string $id)
    {
        $menu = HeaderMenu::findOrFail($id);

        $validated = $request->validate([
            'label' => 'required|max:100',
            'type' => 'required|in:link,dropdown_profil',
            'url' => 'nullable|max:500',
            'is_new_tab' => 'boolean',
            'aktif' => 'boolean',
            'urutan' => 'required|integer|min:0',
        ]);

        if (($validated['type'] ?? '') === 'dropdown_profil') {
            $validated['url'] = null;
            $validated['is_new_tab'] = false;
        }

        $validated['is_new_tab'] = $request->boolean('is_new_tab');
        $validated['aktif'] = $request->boolean('aktif');

        $menu->update($validated);

        return redirect()->route('minda.header.index')->with('success', 'Menu header berhasil diupdate');
    }

    public function destroy(string $id)
    {
        $menu = HeaderMenu::findOrFail($id);
        $menu->delete();
        return redirect()->route('minda.header.index')->with('success', 'Menu header berhasil dihapus');
    }
}

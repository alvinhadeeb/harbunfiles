<?php

namespace App\Http\Controllers\Minda;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use App\Support\FileUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SidebarController extends Controller
{
    public function edit()
    {
        $setting = SiteSetting::getInstance();
        return view('minda.sidebar.edit', compact('setting'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'sidebar_title' => 'required|string|max:50',
            'sidebar_subtitle' => 'required|string|max:50',
            'sidebar_logo' => 'nullable|file|extensions:jpg,jpeg,png,gif,webp,avif,svg|max:1024',
        ]);

        $setting = SiteSetting::getInstance();
        $setting->sidebar_title = $validated['sidebar_title'];
        $setting->sidebar_subtitle = $validated['sidebar_subtitle'];

        if ($request->hasFile('sidebar_logo')) {
            // Hapus logo lama
            if ($setting->sidebar_logo) {
                Storage::disk('public')->delete($setting->sidebar_logo);
            }
            $setting->sidebar_logo = FileUpload::storePublic($request->file('sidebar_logo'), 'sidebar');
        }

        $setting->save();

        return redirect()->route('minda.sidebar.edit')->with('success', 'Sidebar berhasil diupdate');
    }

    public function removeLogo()
    {
        $setting = SiteSetting::getInstance();

        if ($setting->sidebar_logo) {
            Storage::disk('public')->delete($setting->sidebar_logo);
            $setting->sidebar_logo = null;
            $setting->save();
        }

        return redirect()->route('minda.sidebar.edit')->with('success', 'Logo sidebar berhasil dihapus');
    }
}

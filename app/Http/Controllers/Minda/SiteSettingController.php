<?php

namespace App\Http\Controllers\Minda;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SiteSettingController extends Controller
{
    /**
     * Halaman pengaturan situs
     */
    public function index()
    {
        $setting = SiteSetting::getInstance();
        return view('minda.site-settings', compact('setting'));
    }

    /**
     * Toggle on/off halaman secret register
     */
    public function toggleSecretRegister(Request $request)
    {
        $setting = SiteSetting::getInstance();
        $setting->secret_register_enabled = !$setting->secret_register_enabled;
        $setting->save();

        $status = $setting->secret_register_enabled ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()->back()->with('success', "Halaman registrasi rahasia berhasil {$status}.");
    }

    /**
     * Update admin URL prefix
     */
    public function updateAdminPrefix(Request $request)
    {
        $validated = $request->validate([
            'admin_prefix' => ['required', 'string', 'min:2', 'max:50', 'regex:/^[a-zA-Z0-9\-]+$/', function ($attribute, $value, $fail) {
                $reserved = ['api', 'login', 'register', 'home', 'berita', 'kontak', 'faq', 'lembaga', 'storage', 'public', 'css', 'js', 'images', 'vendor'];
                if (in_array(strtolower($value), $reserved)) {
                    $fail('URL ini sudah dipakai oleh sistem. Pilih yang lain.');
                }
            }],
        ], [
            'admin_prefix.required' => 'URL admin wajib diisi.',
            'admin_prefix.min' => 'URL admin minimal 2 karakter.',
            'admin_prefix.max' => 'URL admin maksimal 50 karakter.',
            'admin_prefix.regex' => 'URL admin hanya boleh huruf, angka, dan tanda strip (-).',
        ]);

        $setting = SiteSetting::getInstance();
        $setting->admin_prefix = strtolower($validated['admin_prefix']);
        $setting->save();

        // Redirect ke URL baru
        $newUrl = url($setting->admin_prefix . '/pengaturan');
        return redirect($newUrl)->with('success', 'URL admin berhasil diubah menjadi /' . $setting->admin_prefix);
    }

    /**
     * Update secret register URL
     */
    public function updateSecretUrl(Request $request)
    {
        $validated = $request->validate([
            'secret_register_url' => ['required', 'string', 'min:2', 'max:50', 'regex:/^[a-zA-Z0-9\-]+$/', function ($attribute, $value, $fail) {
                $reserved = ['api', 'login', 'register', 'home', 'berita', 'kontak', 'faq', 'lembaga', 'storage', 'public', 'css', 'js', 'images', 'vendor'];
                if (in_array(strtolower($value), $reserved)) {
                    $fail('URL ini sudah dipakai oleh sistem. Pilih yang lain.');
                }
                // Jangan boleh sama dengan admin prefix
                $adminPrefix = SiteSetting::getAdminPrefix();
                if (strtolower($value) === $adminPrefix) {
                    $fail('URL tidak boleh sama dengan URL admin panel.');
                }
            }],
        ], [
            'secret_register_url.required' => 'URL registrasi wajib diisi.',
            'secret_register_url.min' => 'URL registrasi minimal 2 karakter.',
            'secret_register_url.max' => 'URL registrasi maksimal 50 karakter.',
            'secret_register_url.regex' => 'URL hanya boleh huruf, angka, dan tanda strip (-).',
        ]);

        $setting = SiteSetting::getInstance();
        $setting->secret_register_url = strtolower($validated['secret_register_url']);
        $setting->save();

        return redirect()->back()->with('success', 'URL registrasi rahasia berhasil diubah menjadi /' . $setting->secret_register_url);
    }
}

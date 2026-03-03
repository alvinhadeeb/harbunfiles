<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Hash;

class SecretRegisterController extends Controller
{
    /**
     * Tampilkan form registrasi rahasia
     */
    public function showForm()
    {
        $setting = SiteSetting::getInstance();

        if (!$setting->secret_register_enabled) {
            abort(404);
        }

        return view('secret-register');
    }

    /**
     * Proses registrasi admin
     */
    public function register(Request $request)
    {
        $setting = SiteSetting::getInstance();

        if (!$setting->secret_register_enabled) {
            abort(404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|min:8|confirmed',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        Admin::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'role' => 'admin',
        ]);

        return redirect()->back()->with('success', 'Akun admin berhasil dibuat! Silakan login di halaman admin.');
    }
}

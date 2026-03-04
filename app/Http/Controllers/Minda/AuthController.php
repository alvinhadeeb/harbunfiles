<?php

namespace App\Http\Controllers\Minda;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Admin;
use App\Models\SiteSetting;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('minda.dashboard');
        }

        // Paksa gate check — biar tidak bisa bypass
        $setting = SiteSetting::getInstance();
        if ($setting->admin_gate_enabled && !session('admin_gate_passed')) {
            return redirect()->route('minda.gate');
        }

        return view('minda.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::guard('admin')->attempt($credentials, $remember)) {
            $request->session()->regenerate();

            // Log successful login
            Log::info('Admin login sukses', [
                'email' => $request->email,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            return redirect()->intended(route('minda.dashboard'));
        }

        // Log failed login attempt
        Log::warning('Admin login gagal', [
            'email' => $request->email,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Log::info('Admin logout', [
            'email' => Auth::guard('admin')->user()->email ?? 'unknown',
            'ip' => $request->ip(),
        ]);

        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        // Redirect ke gate jika aktif, bukan ke login
        $setting = SiteSetting::getInstance();
        if ($setting->admin_gate_enabled) {
            return redirect()->route('minda.gate');
        }
        return redirect()->route('minda.login');
    }
}

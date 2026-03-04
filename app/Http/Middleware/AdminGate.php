<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\SiteSetting;

class AdminGate
{
    public function handle(Request $request, Closure $next)
    {
        // Skip jika sudah login sebagai admin
        if (auth()->guard('admin')->check()) {
            return $next($request);
        }

        $setting = SiteSetting::getInstance();

        // Skip jika fitur gate tidak aktif
        if (!$setting->admin_gate_enabled) {
            return $next($request);
        }

        // Cek apakah sudah melewati gate (session)
        if ($request->session()->get('admin_gate_passed')) {
            return $next($request);
        }

        // Jika belum, redirect ke halaman gate
        $adminPrefix = $setting->admin_prefix ?? 'minda';
        $gateUrl = url($adminPrefix . '/gate');

        // Jangan redirect jika sudah di halaman gate
        if ($request->is($adminPrefix . '/gate')) {
            return $next($request);
        }

        return redirect($gateUrl);
    }
}

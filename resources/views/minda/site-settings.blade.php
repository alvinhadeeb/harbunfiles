@extends('minda.layout')

@section('title', 'Pengaturan')
@section('page-title', 'Pengaturan Situs')

@section('content')
<div class="max-w-3xl space-y-6">

    {{-- Ganti URL Admin Panel --}}
    <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="flex items-start gap-4 mb-4">
            <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                </svg>
            </div>
            <div>
                <h2 class="text-lg font-bold text-gray-800">URL Admin Panel</h2>
                <p class="text-sm text-gray-500 mt-1">Ganti URL untuk mengakses admin panel. Setelah diganti, Anda akan diarahkan ke URL baru.</p>
            </div>
        </div>

        <form action="{{ route('minda.site-setting.update-admin-prefix') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="flex items-center gap-2 mb-3">
                <span class="text-gray-500 text-lg font-mono">/</span>
                <input type="text" name="admin_prefix" value="{{ old('admin_prefix', $setting->admin_prefix) }}"
                    class="flex-1 px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition font-mono text-lg"
                    placeholder="minda" required minlength="2" maxlength="50" pattern="[a-zA-Z0-9\-]+">
            </div>
            @error('admin_prefix')
                <p class="text-red-500 text-sm mb-3">{{ $message }}</p>
            @enderror
            <div class="flex items-center justify-between">
                <p class="text-xs text-gray-400">Hanya huruf, angka, dan tanda strip (-). Minimal 2 karakter.</p>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition text-sm">
                    Simpan
                </button>
            </div>
        </form>

        <div class="mt-4 p-3 bg-blue-50 rounded-lg">
            <p class="text-sm text-blue-700">
                <span class="font-semibold">URL saat ini:</span> 
                <code class="bg-blue-100 px-2 py-0.5 rounded">{{ url($setting->admin_prefix) }}</code>
            </p>
        </div>
    </div>

    {{-- Ganti URL Registrasi Rahasia --}}
    <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="flex items-start gap-4 mb-4">
            <div class="w-12 h-12 rounded-lg bg-amber-100 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>
            <div>
                <h2 class="text-lg font-bold text-gray-800">URL Registrasi Rahasia</h2>
                <p class="text-sm text-gray-500 mt-1">Ganti URL halaman registrasi admin rahasia. Pastikan hanya Anda yang tahu URL ini.</p>
            </div>
        </div>

        <form action="{{ route('minda.site-setting.update-secret-url') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="flex items-center gap-2 mb-3">
                <span class="text-gray-500 text-lg font-mono">/</span>
                <input type="text" name="secret_register_url" value="{{ old('secret_register_url', $setting->secret_register_url) }}"
                    class="flex-1 px-4 py-3 rounded-lg border border-gray-300 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 transition font-mono text-lg"
                    placeholder="mendoan" required minlength="2" maxlength="50" pattern="[a-zA-Z0-9\-]+">
            </div>
            @error('secret_register_url')
                <p class="text-red-500 text-sm mb-3">{{ $message }}</p>
            @enderror
            <div class="flex items-center justify-between">
                <p class="text-xs text-gray-400">Hanya huruf, angka, dan tanda strip (-). Minimal 2 karakter.</p>
                <button type="submit" class="px-6 py-2 bg-amber-500 text-white rounded-lg font-semibold hover:bg-amber-600 transition text-sm">
                    Simpan
                </button>
            </div>
        </form>

        <div class="mt-4 p-3 bg-amber-50 rounded-lg flex items-center justify-between">
            <div>
                <p class="text-sm text-amber-700">
                    <span class="font-semibold">URL saat ini:</span>
                    <code class="bg-amber-100 px-2 py-0.5 rounded">{{ url($setting->secret_register_url) }}</code>
                </p>
            </div>
            <form action="{{ route('minda.site-setting.toggle-secret-register') }}" method="POST" class="inline-flex items-center gap-2">
                @csrf
                <span class="text-xs font-medium {{ $setting->secret_register_enabled ? 'text-green-600' : 'text-gray-400' }}">
                    {{ $setting->secret_register_enabled ? 'Aktif' : 'Nonaktif' }}
                </span>
                <button type="submit" class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors {{ $setting->secret_register_enabled ? 'bg-green-500' : 'bg-gray-300' }}" title="{{ $setting->secret_register_enabled ? 'Klik untuk nonaktifkan' : 'Klik untuk aktifkan' }}">
                    <span class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform shadow {{ $setting->secret_register_enabled ? 'translate-x-6' : 'translate-x-1' }}"></span>
                </button>
            </form>
        </div>
    </div>

    {{-- Info Penting --}}
    <div class="bg-red-50 border border-red-200 rounded-xl p-6">
        <div class="flex items-start gap-3">
            <svg class="w-6 h-6 text-red-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.832c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/>
            </svg>
            <div>
                <h3 class="font-bold text-red-700 mb-1">Perhatian!</h3>
                <ul class="text-sm text-red-600 space-y-1">
                    <li>• Setelah mengubah URL admin, <strong>bookmark lama tidak akan berfungsi</strong>. Pastikan Anda mengingat URL baru.</li>
                    <li>• Jangan gunakan URL yang mudah ditebak seperti <code class="bg-red-100 px-1 rounded">admin</code>, <code class="bg-red-100 px-1 rounded">dashboard</code>, dll.</li>
                    <li>• URL registrasi rahasia hanya aktif ketika toggle dinyalakan.</li>
                </ul>
            </div>
        </div>
    </div>

</div>
@endsection

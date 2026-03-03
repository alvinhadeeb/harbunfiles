@extends('minda.layout')

@section('title', 'Edit Sidebar')
@section('page-title', 'Edit Sidebar Admin')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-xl shadow-lg p-8">
        {{-- Preview --}}
        <div class="mb-8">
            <h3 class="text-gray-700 font-semibold mb-3">Preview Sidebar</h3>
            <div class="bg-gradient-to-r from-blue-900 to-indigo-900 rounded-xl p-6 inline-flex items-center gap-3">
                @if($setting->sidebar_logo)
                    <img src="{{ asset('storage/' . $setting->sidebar_logo) }}" alt="Logo" class="w-12 h-12 rounded-lg object-cover bg-white">
                @else
                    <div class="w-12 h-12 rounded-lg bg-white flex items-center justify-center">
                        <span class="text-blue-900 font-bold text-lg">{{ strtoupper(substr($setting->sidebar_title, 0, 2)) }}</span>
                    </div>
                @endif
                <div>
                    <h2 class="font-bold text-lg text-white">{{ $setting->sidebar_title }}</h2>
                    <p class="text-xs text-blue-200">{{ $setting->sidebar_subtitle }}</p>
                </div>
            </div>
        </div>

        <form action="{{ route('minda.sidebar.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Judul Sidebar <span class="text-red-500">*</span></label>
                <input type="text" name="sidebar_title" value="{{ old('sidebar_title', $setting->sidebar_title) }}" required maxlength="50"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition @error('sidebar_title') border-red-500 @enderror"
                    placeholder="Contoh: Admin Panel">
                @error('sidebar_title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Subjudul Sidebar <span class="text-red-500">*</span></label>
                <input type="text" name="sidebar_subtitle" value="{{ old('sidebar_subtitle', $setting->sidebar_subtitle) }}" required maxlength="50"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition @error('sidebar_subtitle') border-red-500 @enderror"
                    placeholder="Contoh: Harapan Bunda">
                @error('sidebar_subtitle')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Logo Sidebar</label>
                @if($setting->sidebar_logo)
                    <div class="mb-3 flex items-center gap-4">
                        <img src="{{ asset('storage/' . $setting->sidebar_logo) }}" alt="Logo saat ini" class="w-16 h-16 rounded-lg object-cover border">
                        <a href="#" onclick="event.preventDefault(); showConfirm('Yakin ingin menghapus logo?').then(ok => { if(ok) document.getElementById('remove-logo-form').submit(); });" class="px-3 py-1.5 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition text-sm font-medium cursor-pointer">
                            Hapus Logo
                        </a>
                    </div>
                @else
                    <p class="text-gray-500 text-sm mb-2">Belum ada logo. Jika kosong, akan menampilkan inisial dari judul sidebar.</p>
                @endif
                <input type="file" name="sidebar_logo" accept="image/*"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition @error('sidebar_logo') border-red-500 @enderror">
                <p class="text-gray-500 text-sm mt-1">Format: JPG, PNG. Maksimal 1MB. Ukuran ideal: 48x48 px (persegi).</p>
                @error('sidebar_logo')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-3">
                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg font-semibold hover:from-blue-700 hover:to-indigo-700 transition shadow-lg">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Form hapus logo (di luar form utama) --}}
@if($setting->sidebar_logo)
<form id="remove-logo-form" action="{{ route('minda.sidebar.logo.remove') }}" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>
@endif
@endsection

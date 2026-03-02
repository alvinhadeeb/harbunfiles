@extends('minda.layout')

@section('title', 'Menu Header')
@section('page-title', 'Kelola Menu Header')

@section('content')
<div class="max-w-4xl">
    {{-- Foto/Logo Header --}}
    <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Foto / Logo Header</h3>
        <p class="text-gray-600 text-sm mb-4">Logo ini tampil di bagian kiri header website. Kosongkan untuk memakai logo default.</p>
        <div class="flex flex-wrap items-end gap-6">
            <div class="flex items-center gap-4">
                @if($headerSetting->logo)
                    <img src="{{ asset('storage/' . $headerSetting->logo) }}" alt="Logo Header" class="w-24 h-24 object-contain border border-gray-200 rounded-lg">
                    <form action="{{ route('minda.header.logo.remove') }}" method="POST" class="inline" onsubmit="return confirm('Hapus foto/logo header? Logo default akan dipakai lagi.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-100 text-red-700 rounded-lg font-medium text-sm hover:bg-red-200 transition">Hapus Foto</button>
                    </form>
                @else
                    <div class="w-24 h-24 bg-gray-100 border border-gray-200 rounded-lg flex items-center justify-center text-gray-400 text-xs text-center px-1">Logo default</div>
                @endif
            </div>
            <form action="{{ route('minda.header.logo.update') }}" method="POST" enctype="multipart/form-data" class="flex items-end gap-3">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-gray-700 font-semibold mb-1 text-sm">Unggah foto/logo baru</label>
                    <input type="file" name="logo" accept="image/*" required class="text-sm text-gray-600 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    @error('logo')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <button type="submit" class="px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg font-semibold text-sm hover:from-blue-700 hover:to-indigo-700 transition">Unggah</button>
            </form>
        </div>
    </div>

    {{-- Daftar Menu --}}
    <div class="flex items-center justify-between mb-6">
        <p class="text-gray-600">Atur menu yang tampil di header website. Urutan mengikuti kolom Urutan.</p>
        <a href="{{ route('minda.header.create') }}" class="px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg font-semibold hover:from-blue-700 hover:to-indigo-700 transition shadow-lg">
            + Tambah Menu
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Urutan</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Label</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Tipe</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">URL / Keterangan</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Status</th>
                    <th class="text-right px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($menus as $item)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-gray-600">{{ $item->urutan }}</td>
                    <td class="px-6 py-4 font-medium text-gray-800">{{ $item->label }}</td>
                    <td class="px-6 py-4">
                        @if($item->type === 'dropdown_profil')
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">Dropdown Profil</span>
                        @else
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Link</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">
                        @if($item->type === 'dropdown_profil')
                            <span class="text-gray-400">— Isi dari data Lembaga</span>
                        @else
                            {{ $item->url }}
                            @if($item->is_new_tab)
                                <span class="text-xs text-gray-400">(tab baru)</span>
                            @endif
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        @if($item->aktif)
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Aktif</span>
                        @else
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600">Nonaktif</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('minda.header.edit', $item->id) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium mr-3">Edit</a>
                        <form action="{{ route('minda.header.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus menu ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">Belum ada menu. Klik "Tambah Menu" untuk menambah.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

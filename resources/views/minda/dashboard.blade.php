@extends('minda.layout')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Card Total Berita -->
    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100 text-sm mb-1">Total Berita</p>
                <h3 class="text-3xl font-bold">{{ $totalBerita }}</h3>
            </div>
            <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center">
                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Card Total Galeri -->
    <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-green-100 text-sm mb-1">Total Galeri</p>
                <h3 class="text-3xl font-bold">{{ $totalGaleri }}</h3>
            </div>
            <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center">
                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Card Quick Action -->
    <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-purple-100 text-sm mb-1">Quick Action</p>
                <a href="{{ route('minda.berita.create') }}" class="inline-block mt-2 px-4 py-2 bg-white text-purple-600 rounded-lg font-semibold text-sm hover:bg-purple-50 transition">
                    + Tambah Berita
                </a>
            </div>
            <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center">
                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Storage Usage Bar -->
<div class="bg-white rounded-xl shadow-lg p-6 mb-8">
    <h2 class="text-xl font-bold text-gray-800 mb-2">Penyimpanan Website</h2>
    <p class="text-gray-500 text-sm mb-4">Total ukuran file yang diunggah (gambar berita, galeri, banner, logo, dll.) di <code class="text-xs bg-gray-100 px-1 rounded">storage/app/public</code></p>
    <div class="flex items-center gap-4 flex-wrap">
        <div class="flex-1 min-w-[200px]" style="max-width: 400px;">
            <div class="h-6 bg-gray-200 rounded-full overflow-hidden">
                <div class="h-full bg-gradient-to-r from-amber-500 to-orange-500 rounded-full transition-all duration-500 flex items-center justify-end pr-2" style="width: {{ min($storagePercent, 100) }}%;">
                    @if($storagePercent > 15)
                        <span class="text-xs font-semibold text-white drop-shadow">{{ $storagePercent }}%</span>
                    @endif
                </div>
            </div>
            @if($storagePercent <= 15)
                <span class="text-xs font-semibold text-amber-600 mt-1 inline-block">{{ $storagePercent }}%</span>
            @endif
        </div>
        <div class="text-gray-700 font-semibold">
            <span class="text-2xl text-gray-800">{{ $storageUsedMb }}</span> MB
            <span class="text-gray-400 font-normal text-sm">/ 50 GB</span>
        </div>
    </div>
</div>

<!-- Berita Terbaru -->
<div class="bg-white rounded-xl shadow-lg p-6">
    <h2 class="text-xl font-bold text-gray-800 mb-4">Berita Terbaru</h2>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-200">
                    <th class="text-left py-3 px-4 text-gray-600 font-semibold text-sm">Judul</th>
                    <th class="text-left py-3 px-4 text-gray-600 font-semibold text-sm">Kategori</th>
                    <th class="text-left py-3 px-4 text-gray-600 font-semibold text-sm">Status</th>
                    <th class="text-left py-3 px-4 text-gray-600 font-semibold text-sm">Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($beritaTerbaru as $item)
                    <tr class="border-b border-gray-100 hover:bg-gray-50">
                        <td class="py-3 px-4">{{ $item->judul }}</td>
                        <td class="py-3 px-4">
                            <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-medium">{{ $item->kategori }}</span>
                        </td>
                        <td class="py-3 px-4">
                            <span class="px-3 py-1 {{ $item->status == 'published' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }} rounded-full text-xs font-medium">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-gray-500 text-sm">{{ ($item->tanggal ?? $item->created_at)->format('d M Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="py-8 text-center text-gray-500">Belum ada berita</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($beritaTerbaru->count() > 0)
        <div class="mt-4 text-center">
            <a href="{{ route('minda.berita.index') }}" class="text-blue-600 hover:text-blue-700 font-medium text-sm">
                Lihat Semua Berita →
            </a>
        </div>
    @endif
</div>
@endsection

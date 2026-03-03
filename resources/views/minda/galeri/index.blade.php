@extends('minda.layout')

@section('title', 'Kelola Galeri')
@section('page-title', 'Kelola Galeri')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <p class="text-gray-600">Kelola foto galeri carousel di halaman utama</p>
        <a href="{{ route('minda.galeri.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg font-medium transition flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Foto
        </a>
    </div>

    {{-- Galeri Grid --}}
    @if($galeri->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($galeri as $item)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden {{ !$item->aktif ? 'opacity-50' : '' }}">
                    {{-- Image Preview --}}
                    <div class="relative aspect-[16/9] bg-gray-100">
                        @if(str_starts_with($item->gambar, 'images/'))
                            <img src="{{ asset($item->gambar) }}" alt="{{ $item->judul }}" class="w-full h-full object-cover">
                        @else
                            <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->judul }}" class="w-full h-full object-cover">
                        @endif

                        <span class="absolute top-2 right-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $item->aktif ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">
                            {{ $item->aktif ? 'Aktif' : 'Nonaktif' }}
                        </span>
                        <span class="absolute top-2 left-2 inline-flex items-center justify-center w-7 h-7 rounded-full bg-black/50 text-white text-xs font-bold">
                            {{ $item->urutan }}
                        </span>
                    </div>

                    {{-- Info --}}
                    <div class="p-4">
                        <h3 class="font-semibold text-gray-800 text-sm truncate">{{ $item->judul }}</h3>
                        @if($item->deskripsi)
                            <p class="text-xs text-gray-500 mt-1 line-clamp-2">{{ $item->deskripsi }}</p>
                        @endif
                        <p class="text-xs text-gray-400 mt-1">{{ $item->created_at->format('d M Y') }}</p>
                    </div>

                    {{-- Actions --}}
                    <div class="border-t border-gray-100 px-4 py-3 bg-gray-50 flex items-center justify-end gap-2">
                        <a href="{{ route('minda.galeri.edit', $item->id) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Edit</a>
                        <form action="{{ route('minda.galeri.destroy', $item->id) }}" method="POST" data-confirm="Yakin hapus foto ini?">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">Hapus</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
            <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <p class="text-gray-500 mb-4">Belum ada foto galeri</p>
            <a href="{{ route('minda.galeri.create') }}" class="text-blue-600 hover:text-blue-800 font-medium">+ Tambah foto pertama</a>
        </div>
    @endif
</div>
@endsection

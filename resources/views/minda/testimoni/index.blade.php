@extends('minda.layout')

@section('title', 'Kelola Testimoni')
@section('page-title', 'Kelola Testimoni')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <p class="text-gray-600">Kelola testimoni yang tampil di halaman utama</p>
        <a href="{{ route('minda.testimoni.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg font-medium transition flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Testimoni
        </a>
    </div>

    {{-- Testimoni Cards Grid --}}
    @if($testimoni->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($testimoni as $item)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden {{ !$item->aktif ? 'opacity-50' : '' }}">
                    <div class="p-5">
                        {{-- Avatar & Name --}}
                        <div class="flex items-center gap-3 mb-4">
                            @if($item->foto)
                                <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama }}" class="w-12 h-12 rounded-full object-cover">
                            @else
                                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-blue-400" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                    </svg>
                                </div>
                            @endif
                            <div>
                                <h3 class="font-bold text-gray-800 text-sm">{{ $item->nama }}</h3>
                                @if($item->jabatan)
                                    <p class="text-xs text-gray-500">{{ $item->jabatan }}</p>
                                @endif
                            </div>
                        </div>

                        {{-- Testimoni Text --}}
                        <p class="text-sm text-gray-600 leading-relaxed mb-4">{{ Str::limit($item->isi, 120) }}</p>

                        {{-- Status Badge --}}
                        <div class="flex items-center justify-between">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $item->aktif ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">
                                {{ $item->aktif ? 'Aktif' : 'Nonaktif' }}
                            </span>
                            <span class="text-xs text-gray-400">Urutan: {{ $item->urutan }}</span>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="border-t border-gray-100 px-5 py-3 bg-gray-50 flex items-center justify-end gap-2">
                        <a href="{{ route('minda.testimoni.edit', $item->id) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Edit</a>
                        <form action="{{ route('minda.testimoni.destroy', $item->id) }}" method="POST" data-confirm="Yakin hapus testimoni ini?">
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
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
            </svg>
            <p class="text-gray-500 mb-4">Belum ada testimoni</p>
            <a href="{{ route('minda.testimoni.create') }}" class="text-blue-600 hover:text-blue-800 font-medium">+ Tambah testimoni pertama</a>
        </div>
    @endif
</div>
@endsection

@extends('minda.layout')

@section('title', 'Kelola FAQ')
@section('page-title', 'Kelola FAQ')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <p class="text-gray-600">Kelola pertanyaan yang sering diajukan (FAQ)</p>
        <a href="{{ route('minda.faq.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg font-medium transition flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah FAQ
        </a>
    </div>

    {{-- FAQ List --}}
    @if($faq->count() > 0)
        <div class="space-y-4">
            @foreach($faq as $item)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden {{ !$item->aktif ? 'opacity-50' : '' }}">
                    <div class="p-5">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex-1">
                                <h3 class="font-bold text-gray-800 mb-2">{{ $item->pertanyaan }}</h3>
                                <p class="text-sm text-gray-600 leading-relaxed">{{ Str::limit($item->jawaban, 200) }}</p>
                            </div>
                            <div class="flex items-center gap-2 shrink-0">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $item->aktif ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">
                                    {{ $item->aktif ? 'Aktif' : 'Nonaktif' }}
                                </span>
                                <span class="text-xs text-gray-400">Urutan: {{ $item->urutan }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="border-t border-gray-100 px-5 py-3 bg-gray-50 flex items-center justify-end gap-2">
                        <a href="{{ route('minda.faq.edit', $item->id) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Edit</a>
                        <form action="{{ route('minda.faq.destroy', $item->id) }}" method="POST" data-confirm="Yakin hapus FAQ ini?">
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
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-gray-500 mb-4">Belum ada FAQ</p>
            <a href="{{ route('minda.faq.create') }}" class="text-blue-600 hover:text-blue-800 font-medium">+ Tambah FAQ pertama</a>
        </div>
    @endif
</div>
@endsection

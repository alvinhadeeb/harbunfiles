@extends('minda.layout')

@section('title', 'Kelola Berita')
@section('page-title', 'Kelola Berita')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <p class="text-gray-600">Total: <strong>{{ $berita->total() }}</strong> berita</p>
    </div>
    <a href="{{ route('minda.berita.create') }}" class="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg font-semibold hover:from-blue-700 hover:to-indigo-700 transition shadow-lg">
        + Tambah Berita
    </a>
</div>

<div class="bg-white rounded-xl shadow-lg overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="text-left py-4 px-6 text-gray-600 font-semibold text-sm">Gambar</th>
                    <th class="text-left py-4 px-6 text-gray-600 font-semibold text-sm">Judul</th>
                    <th class="text-left py-4 px-6 text-gray-600 font-semibold text-sm">Lembaga</th>
                    <th class="text-left py-4 px-6 text-gray-600 font-semibold text-sm">Kategori</th>

                    <th class="text-left py-4 px-6 text-gray-600 font-semibold text-sm">Tanggal</th>
                    <th class="text-center py-4 px-6 text-gray-600 font-semibold text-sm">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($berita as $item)
                    <tr class="border-t border-gray-100 hover:bg-gray-50">
                        <td class="py-4 px-6">
                            @if($item->gambar)
                                <img src="{{ asset('storage/'.$item->gambar) }}" alt="{{ $item->judul }}" class="w-16 h-16 object-cover rounded-lg">
                            @else
                                <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/>
                                    </svg>
                                </div>
                            @endif
                        </td>
                        <td class="py-4 px-6">
                            <p class="font-semibold text-gray-800">{{ Str::limit($item->judul, 50) }}</p>
                            <p class="text-xs text-gray-500 mt-1">{{ $item->slug }}</p>
                        </td>
                        <td class="py-4 px-6">
                            @if($item->lembaga)
                                <span class="px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full text-xs font-medium">{{ $item->lembaga->nama }}</span>
                            @else
                                <span class="px-3 py-1 bg-gray-100 text-gray-500 rounded-full text-xs font-medium">Umum</span>
                            @endif
                        </td>
                        <td class="py-4 px-6">
                            <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-medium">{{ $item->kategori }}</span>
                        </td>

                        <td class="py-4 px-6 text-gray-600 text-sm">
                            {{ ($item->tanggal ?? $item->created_at)->format('d M Y') }}
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('minda.berita.edit', $item->id) }}" class="px-3 py-2 bg-yellow-100 text-yellow-700 rounded-lg hover:bg-yellow-200 transition text-sm font-medium">
                                    Edit
                                </a>
                                <form action="{{ route('minda.berita.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus berita ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition text-sm font-medium">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-12 text-center text-gray-500">
                            <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/>
                            </svg>
                            <p class="text-lg font-semibold mb-2">Belum ada berita</p>
                            <p class="mb-4">Tambahkan berita pertama Anda</p>
                            <a href="{{ route('minda.berita.create') }}" class="inline-block px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                + Tambah Berita
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($berita->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $berita->links() }}
        </div>
    @endif
</div>
@endsection

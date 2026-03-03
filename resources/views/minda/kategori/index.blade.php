@extends('minda.layout')

@section('title', 'Kelola Kategori')
@section('page-title', 'Kelola Kategori')

@section('content')
<div class="max-w-4xl">
    {{-- Form Tambah Kategori --}}
    <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Tambah Kategori Baru</h3>
        <form action="{{ route('minda.kategori.store') }}" method="POST" class="flex items-end gap-4">
            @csrf
            <div class="flex-1">
                <label class="block text-gray-700 font-semibold mb-2">Nama Kategori <span class="text-red-500">*</span></label>
                <input type="text" name="nama" value="{{ old('nama') }}" required placeholder="Masukkan nama kategori..."
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition @error('nama') border-red-500 @enderror">
                @error('nama')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg font-semibold hover:from-blue-700 hover:to-indigo-700 transition shadow-lg whitespace-nowrap">
                + Tambah
            </button>
        </form>
    </div>

    {{-- Daftar Kategori --}}
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-bold text-gray-800">Daftar Kategori ({{ $kategori->count() }})</h3>
        </div>
        
        @if($kategori->count() > 0)
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">No</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Nama Kategori</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Jumlah Berita</th>
                    <th class="text-right px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($kategori as $index => $item)
                <tr class="hover:bg-gray-50 transition" id="row-{{ $item->id }}">
                    {{-- Mode Tampil --}}
                    <td class="px-6 py-4 text-gray-600 view-mode-{{ $item->id }}">{{ $index + 1 }}</td>
                    <td class="px-6 py-4 font-medium text-gray-800 view-mode-{{ $item->id }}">{{ $item->nama }}</td>
                    <td class="px-6 py-4 view-mode-{{ $item->id }}">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            {{ \App\Models\Berita::where('kategori', $item->nama)->count() }} berita
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right view-mode-{{ $item->id }}">
                        <button onclick="showEdit({{ $item->id }})" class="text-blue-600 hover:text-blue-800 text-sm font-medium mr-3">Edit</button>
                        <form action="{{ route('minda.kategori.destroy', $item->id) }}" method="POST" class="inline" data-confirm="Yakin hapus kategori ini?">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">Hapus</button>
                        </form>
                    </td>

                    {{-- Mode Edit (hidden by default) --}}
                    <td class="px-6 py-4 text-gray-600 edit-mode-{{ $item->id }}" style="display: none;">{{ $index + 1 }}</td>
                    <td class="px-6 py-4 edit-mode-{{ $item->id }}" style="display: none;" colspan="2">
                        <form action="{{ route('minda.kategori.update', $item->id) }}" method="POST" class="flex items-center gap-3">
                            @csrf
                            @method('PUT')
                            <input type="text" name="nama" value="{{ $item->nama }}" required
                                class="flex-1 px-3 py-2 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 text-sm">
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition">Simpan</button>
                            <button type="button" onclick="hideEdit({{ $item->id }})" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-300 transition">Batal</button>
                        </form>
                    </td>
                    <td class="edit-mode-{{ $item->id }}" style="display: none;"></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="text-center py-12 text-gray-400">
            <p>Belum ada kategori.</p>
        </div>
        @endif
    </div>
</div>

<script>
function showEdit(id) {
    document.querySelectorAll('.view-mode-' + id).forEach(el => el.style.display = 'none');
    document.querySelectorAll('.edit-mode-' + id).forEach(el => el.style.display = '');
}
function hideEdit(id) {
    document.querySelectorAll('.view-mode-' + id).forEach(el => el.style.display = '');
    document.querySelectorAll('.edit-mode-' + id).forEach(el => el.style.display = 'none');
}
</script>
@endsection

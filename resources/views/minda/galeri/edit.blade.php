@extends('minda.layout')

@section('title', 'Edit Foto Galeri')
@section('page-title', 'Edit Foto Galeri')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <form action="{{ route('minda.galeri.update', $galeri->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-5">
                <label class="block text-gray-700 font-semibold mb-2">Foto</label>
                <div class="mb-3">
                    @if(str_starts_with($galeri->gambar, 'images/'))
                        <img src="{{ asset($galeri->gambar) }}" alt="{{ $galeri->judul }}" class="w-full rounded-lg border border-gray-200" style="max-height: 250px; object-fit: cover;">
                    @else
                        <img src="{{ asset('storage/' . $galeri->gambar) }}" alt="{{ $galeri->judul }}" class="w-full rounded-lg border border-gray-200" style="max-height: 250px; object-fit: cover;">
                    @endif
                    <p class="text-xs text-gray-400 mt-1">Foto saat ini</p>
                </div>
                <input type="file" name="gambar" accept="image/*"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition @error('gambar') border-red-500 @enderror"
                    onchange="previewImage(this)">
                <p class="text-xs text-gray-400 mt-1">Kosongkan jika tidak ingin mengubah foto. Maks 5MB.</p>
                @error('gambar')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <div id="preview-container" class="mt-3 hidden">
                    <img id="preview-img" src="" alt="Preview" class="w-full rounded-lg border border-gray-200" style="max-height: 300px; object-fit: cover;">
                    <p class="text-xs text-green-600 mt-1">Foto baru (preview)</p>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-5">
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Urutan</label>
                    <input type="number" name="urutan" value="{{ old('urutan', $galeri->urutan) }}" min="0"
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition">
                    <p class="text-xs text-gray-400 mt-1">Angka kecil tampil duluan</p>
                </div>
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Status</label>
                    <label class="flex items-center gap-3 mt-3 cursor-pointer">
                        <input type="checkbox" name="aktif" value="1" {{ old('aktif', $galeri->aktif) ? 'checked' : '' }}
                            class="w-5 h-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <span class="text-gray-700">Tampilkan di halaman utama</span>
                    </label>
                </div>
            </div>

            <div class="flex items-center gap-3 pt-4 border-t border-gray-200">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg font-medium transition">
                    Update Foto
                </button>
                <a href="{{ route('minda.galeri.index') }}" class="text-gray-600 hover:text-gray-800 px-4 py-2.5 font-medium">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<script>
function previewImage(input) {
    var container = document.getElementById('preview-container');
    var img = document.getElementById('preview-img');
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            img.src = e.target.result;
            container.classList.remove('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection

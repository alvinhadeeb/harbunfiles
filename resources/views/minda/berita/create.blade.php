@extends('minda.layout')

@section('title', 'Tambah Berita')
@section('page-title', 'Tambah Berita Baru')

@section('content')
<div class="max-w-4xl">
    <div class="bg-white rounded-xl shadow-lg p-8">
        <form action="{{ route('minda.berita.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Judul Berita <span class="text-red-500">*</span></label>
                <input type="text" name="judul" value="{{ old('judul') }}" required
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition @error('judul') border-red-500 @enderror">
                @error('judul')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Kategori <span class="text-red-500">*</span></label>
                <select name="kategori" required
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition @error('kategori') border-red-500 @enderror">
                    <option value="">Pilih Kategori</option>
                    @foreach($kategoriList as $kat)
                        <option value="{{ $kat->nama }}" {{ old('kategori') == $kat->nama ? 'selected' : '' }}>{{ $kat->nama }}</option>
                    @endforeach
                </select>
                @error('kategori')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Lembaga</label>
                <p class="text-amber-600 text-sm mb-2">Kosongkan jika berita untuk semua lembaga. Bisa pilih lebih dari 1.</p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-2 p-4 border border-gray-300 rounded-lg bg-gray-50">
                    @foreach($lembagaList as $lembaga)
                        <label class="flex items-center space-x-3 p-2 rounded-lg hover:bg-white cursor-pointer transition">
                            <input 
                                type="checkbox" 
                                name="lembaga_ids[]" 
                                value="{{ $lembaga->id }}"
                                {{ in_array($lembaga->id, old('lembaga_ids', [])) ? 'checked' : '' }}
                                class="w-5 h-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="text-gray-700">{{ $lembaga->nama }}</span>
                        </label>
                    @endforeach
                </div>
                @error('lembaga_ids')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Konten <span class="text-red-500">*</span></label>
                <p class="text-gray-600 text-sm mb-2">Mudahnya: cukup tulis konten biasa, foto sisipan akan ditempatkan otomatis oleh sistem.</p>
                <textarea name="konten" rows="10" required
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition @error('konten') border-red-500 @enderror">{{ old('konten') }}</textarea>
                @error('konten')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Konten Berita</label>
                <input type="file" name="gambar" accept="image/*"
                    id="berita-gambar-input"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition @error('gambar') border-red-500 @enderror">
                <p class="text-gray-500 text-sm mt-1">Format: JPG, PNG. Maksimal 2MB</p>
                <div id="berita-gambar-preview" class="mt-3 hidden"></div>
                @error('gambar')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            
                <input type="file" name="inline_images[]" accept="image/*" multiple
                    id="berita-inline-input"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition @error('inline_images') border-red-500 @enderror @error('inline_images.*') border-red-500 @enderror">
                <p class="text-gray-500 text-sm mt-1">Bisa upload max 3 foto. Opsional: tulis marker <strong>(foto1)</strong>, <strong>(foto2)</strong>, <strong>(foto3)</strong> di konten untuk posisi persis.</p>
                <div id="berita-inline-preview" class="mt-3 grid grid-cols-1 md:grid-cols-2 gap-3 hidden"></div>
                @error('inline_images')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                @error('inline_images.*')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <input type="hidden" name="status" value="published">

            <div class="mt-8 mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Tanggal Berita</label>
                <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition @error('tanggal') border-red-500 @enderror">
                <p class="text-gray-500 text-sm mt-1">Pilih tanggal berita (default: hari ini)</p>
                @error('tanggal')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-3">
                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg font-semibold hover:from-blue-700 hover:to-indigo-700 transition shadow-lg">
                    Simpan Berita
                </button>
                <a href="{{ route('minda.berita.index') }}" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg font-semibold hover:bg-gray-300 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    (function() {
        var gambarInput = document.getElementById('berita-gambar-input');
        var gambarPreview = document.getElementById('berita-gambar-preview');
        var inlineInput = document.getElementById('berita-inline-input');
        var inlinePreview = document.getElementById('berita-inline-preview');

        var gambarInput = document.getElementById('berita-gambar-input');
        var gambarPreview = document.getElementById('berita-gambar-preview');
        var inlineInput = document.getElementById('berita-inline-input');
        var inlinePreview = document.getElementById('berita-inline-preview');

        var renderImagePreview = function(file, target, single) {
            if (!file) return;

            var url = URL.createObjectURL(file);
            var wrapper = document.createElement('div');
            wrapper.className = 'rounded-lg border border-gray-200 bg-gray-50 p-3';
            wrapper.innerHTML = '<div class="text-sm font-medium text-gray-700 mb-2">' + file.name + '</div>' +
                '<img src="' + url + '" alt="Preview" class="w-full ' + (single ? 'max-w-sm' : 'h-32') + ' object-contain rounded bg-white border">';
            target.appendChild(wrapper);
        };

        if (gambarInput && gambarPreview) {
            gambarInput.addEventListener('change', function() {
                gambarPreview.innerHTML = '';
                var file = gambarInput.files && gambarInput.files[0];
                if (!file) {
                    gambarPreview.classList.add('hidden');
                    return;
                }

                gambarPreview.classList.remove('hidden');
                renderImagePreview(file, gambarPreview, true);
            });
        }

        // Handle single inline image input with multiple files
        if (inlineInput && inlinePreview) {
            inlineInput.addEventListener('change', function() {
                inlinePreview.innerHTML = '';
                var files = Array.from(inlineInput.files || []);
                if (!files.length) {
                    inlinePreview.classList.add('hidden');
                    return;
                }

                inlinePreview.classList.remove('hidden');
                files.forEach(function(file, index) {
                    var card = document.createElement('div');
                    card.className = 'rounded-lg border border-gray-200 bg-gray-50 p-3';
                    var url = URL.createObjectURL(file);
                    card.innerHTML = '<div class="flex items-center justify-between gap-2 mb-2">'
                        + '<span class="text-sm font-medium text-gray-700">Foto ' + (index + 1) + '</span>'
                        + '<span class="text-xs text-gray-500 truncate max-w-[180px]" title="' + file.name + '">' + file.name + '</span>'
                        + '</div>'
                        + '<img src="' + url + '" alt="Preview foto sisipan" class="w-full h-40 object-contain rounded bg-white border">';
                    inlinePreview.appendChild(card);
                });
            });
        }
    })();
</script>
@endsection

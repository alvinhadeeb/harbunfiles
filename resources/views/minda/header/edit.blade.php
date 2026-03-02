@extends('minda.layout')

@section('title', 'Edit Menu Header')
@section('page-title', 'Edit Menu Header')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-xl shadow-lg p-6">
        <a href="{{ route('minda.header.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium mb-4 inline-block">← Kembali ke Daftar Menu</a>

        <form action="{{ route('minda.header.update', $menu->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="space-y-4">
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Label (teks di menu) <span class="text-red-500">*</span></label>
                    <input type="text" name="label" value="{{ old('label', $menu->label) }}" required placeholder="Contoh: BERANDA"
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 @error('label') border-red-500 @enderror">
                    @error('label')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Tipe <span class="text-red-500">*</span></label>
                    <select name="type" id="type" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
                        <option value="link" {{ old('type', $menu->type) === 'link' ? 'selected' : '' }}>Link (satu URL)</option>
                        <option value="dropdown_profil" {{ old('type', $menu->type) === 'dropdown_profil' ? 'selected' : '' }}>Dropdown Profil (daftar Lembaga)</option>
                    </select>
                </div>

                <div id="url-wrap">
                    <label class="block text-gray-700 font-semibold mb-2">URL</label>
                    <input type="text" name="url" value="{{ old('url', $menu->url) }}" placeholder="Contoh: /kontak"
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 @error('url') border-red-500 @enderror">
                    @error('url')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div id="new-tab-wrap" class="flex items-center gap-2">
                    <input type="checkbox" name="is_new_tab" id="is_new_tab" value="1" {{ old('is_new_tab', $menu->is_new_tab) ? 'checked' : '' }} class="w-4 h-4 text-blue-600 rounded">
                    <label for="is_new_tab" class="text-gray-700">Buka di tab baru</label>
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Urutan</label>
                    <input type="number" name="urutan" value="{{ old('urutan', $menu->urutan) }}" min="0"
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
                    @error('urutan')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="flex items-center gap-2">
                    <input type="checkbox" name="aktif" id="aktif" value="1" {{ old('aktif', $menu->aktif) ? 'checked' : '' }} class="w-4 h-4 text-blue-600 rounded">
                    <label for="aktif" class="text-gray-700">Aktif (tampilkan di header)</label>
                </div>
            </div>

            <div class="mt-6 flex gap-3">
                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg font-semibold hover:from-blue-700 hover:to-indigo-700 transition shadow-lg">Simpan</button>
                <a href="{{ route('minda.header.index') }}" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg font-semibold hover:bg-gray-300 transition">Batal</a>
            </div>
        </form>
    </div>
</div>
<script>
document.getElementById('type').addEventListener('change', function() {
    var isLink = this.value === 'link';
    document.getElementById('url-wrap').style.display = isLink ? 'block' : 'none';
    document.getElementById('new-tab-wrap').style.display = isLink ? 'flex' : 'none';
});
document.getElementById('type').dispatchEvent(new Event('change'));
</script>
@endsection

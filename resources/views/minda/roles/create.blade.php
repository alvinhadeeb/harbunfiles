@extends('minda.layout')

@section('title', 'Tambah Role')
@section('page-title', 'Tambah Role Baru')

@section('content')
<div class="max-w-3xl">
    <a href="{{ route('minda.roles.index') }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-800 font-medium mb-4 transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Kembali
    </a>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <form action="{{ route('minda.roles.store') }}" method="POST">
            @csrf

            <div class="mb-5">
                <label class="block text-gray-700 font-semibold mb-2">Nama Role <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" required
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition @error('name') border-red-500 @enderror"
                    placeholder="Contoh: Admin LPIT, Admin SD 2">
                @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="mb-5">
                <label class="block text-gray-700 font-semibold mb-2">Deskripsi <span class="text-gray-400 font-normal">(opsional)</span></label>
                <input type="text" name="description" value="{{ old('description') }}"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition"
                    placeholder="Keterangan singkat tentang role ini">
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-3">Fitur yang Bisa Diakses <span class="text-red-500">*</span></label>
                @error('permissions')<p class="text-red-500 text-sm mb-2">{{ $message }}</p>@enderror
                <div class="grid grid-cols-2 gap-3">
                    @foreach($permissions as $key => $perm)
                    <label class="flex items-start gap-3 p-3 rounded-lg border border-gray-200 cursor-pointer hover:bg-gray-50 transition has-[:checked]:border-purple-400 has-[:checked]:bg-purple-50">
                        <input type="checkbox" name="permissions[]" value="{{ $key }}"
                            {{ in_array($key, old('permissions', [])) ? 'checked' : '' }}
                            class="mt-0.5 rounded text-purple-600"
>
                        <div>
                            <span class="font-semibold text-gray-700 text-sm">{{ $perm['label'] }}</span>
                            <p class="text-xs text-gray-500">{{ $perm['description'] }}</p>
                        </div>
                    </label>
                    @endforeach
                </div>
                <div class="mt-3 flex gap-2">
                    <button type="button" onclick="selectAll(true)" class="text-xs text-purple-600 hover:text-purple-800 font-medium">Pilih Semua</button>
                    <span class="text-gray-300">|</span>
                    <button type="button" onclick="selectAll(false)" class="text-xs text-gray-500 hover:text-gray-700 font-medium">Hapus Semua</button>
                </div>
            </div>

            {{-- Pilih Lembaga --}}
            <div id="lembagaSection" class="mb-6">
                <div class="p-4 bg-purple-50 border border-purple-200 rounded-xl">
                    <label class="block text-gray-700 font-semibold mb-1">Batasi Akses Lembaga</label>
                    <p class="text-xs text-gray-500 mb-3">Pilih lembaga mana saja yang bisa dikelola role ini (berita, galeri, dll). Kosongkan jika boleh akses <strong>semua lembaga</strong>.</p>
                    @error('allowed_lembaga')<p class="text-red-500 text-sm mb-2">{{ $message }}</p>@enderror
                    <div class="grid grid-cols-2 gap-2">
                        @foreach($lembagaList as $lmb)
                        <label class="flex items-center gap-2.5 p-2.5 rounded-lg border border-purple-100 bg-white cursor-pointer hover:bg-purple-50 transition has-[:checked]:border-purple-400 has-[:checked]:bg-purple-100">
                            <input type="checkbox" name="allowed_lembaga[]" value="{{ $lmb->id }}"
                                {{ in_array($lmb->id, old('allowed_lembaga', [])) ? 'checked' : '' }}
                                class="rounded text-purple-600">
                            <div class="flex items-center gap-2 min-w-0">
                                @if($lmb->logo)
                                    @php $logoSrc = str_starts_with($lmb->logo, 'images/') ? asset($lmb->logo) : asset('storage/' . $lmb->logo); @endphp
                                    <img src="{{ $logoSrc }}" class="w-6 h-6 object-contain rounded shrink-0" alt="">
                                @else
                                <div class="w-6 h-6 rounded bg-purple-200 flex items-center justify-center shrink-0">
                                    <span class="text-xs font-bold text-purple-600">{{ strtoupper(substr($lmb->nama, 0, 1)) }}</span>
                                </div>
                                @endif
                                <span class="text-sm font-medium text-gray-700 truncate">{{ $lmb->nama }}</span>
                            </div>
                        </label>
                        @endforeach
                    </div>
                    @if($lembagaList->isEmpty())
                    <p class="text-sm text-gray-400 italic">Belum ada data lembaga.</p>
                    @endif
                </div>
            </div>

            <div class="flex gap-3 pt-4 border-t">
                <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-lg font-semibold hover:from-purple-700 hover:to-indigo-700 transition shadow-lg">
                    Simpan Role
                </button>
                <a href="{{ route('minda.roles.index') }}" class="text-gray-600 hover:text-gray-800 px-4 py-2.5 font-medium">Batal</a>
            </div>
        </form>
    </div>
</div>

<script>
function selectAll(checked) {
    document.querySelectorAll('input[name="permissions[]"]').forEach(cb => cb.checked = checked);
}
</script>
@endsection

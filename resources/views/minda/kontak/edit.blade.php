@extends('minda.layout')

@section('title', 'Edit Informasi Footer')
@section('page-title', 'Edit Informasi Footer')

@section('content')
<div class="max-w-4xl">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <form action="{{ route('minda.kontak.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b border-gray-200">Informasi Tentang</h3>
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Deskripsi Singkat <span class="text-red-500">*</span></label>
                    <textarea name="tentang_deskripsi" rows="4" required
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition @error('tentang_deskripsi') border-red-500 @enderror"
                        placeholder="Deskripsi singkat tentang yayasan...">{{ old('tentang_deskripsi', $kontak->tentang_deskripsi) }}</textarea>
                    @error('tentang_deskripsi')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b border-gray-200">Kontak Kami</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Telepon <span class="text-red-500">*</span></label>
                        <input type="text" name="telepon" value="{{ old('telepon', $kontak->telepon) }}" required
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition @error('telepon') border-red-500 @enderror"
                            placeholder="0281523668">
                        @error('telepon')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" value="{{ old('email', $kontak->email) }}" required
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition @error('email') border-red-500 @enderror"
                            placeholder="admin@example.com">
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="mt-5">
                    <label class="block text-gray-700 font-semibold mb-2">WhatsApp</label>
                    <input type="text" name="whatsapp" value="{{ old('whatsapp', $kontak->whatsapp) }}"
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition"
                        placeholder="08123456789">
                    <p class="text-xs text-gray-400 mt-1">Format: 08xxxxxxxxxx (tanpa +62)</p>
                </div>
                <div class="mt-5">
                    <label class="block text-gray-700 font-semibold mb-2">Alamat <span class="text-red-500">*</span></label>
                    <textarea name="alamat" rows="3" required
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition @error('alamat') border-red-500 @enderror"
                        placeholder="Alamat lengkap...">{{ old('alamat', $kontak->alamat) }}</textarea>
                    @error('alamat')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b border-gray-200">Social Media</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Facebook URL</label>
                        <input type="url" name="facebook_url" value="{{ old('facebook_url', $kontak->facebook_url) }}"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition"
                            placeholder="https://facebook.com/...">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Instagram URL</label>
                        <input type="url" name="instagram_url" value="{{ old('instagram_url', $kontak->instagram_url) }}"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition"
                            placeholder="https://instagram.com/...">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">YouTube URL</label>
                        <input type="url" name="youtube_url" value="{{ old('youtube_url', $kontak->youtube_url) }}"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition"
                            placeholder="https://youtube.com/...">
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-3 pt-4 border-t border-gray-200">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg font-medium transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

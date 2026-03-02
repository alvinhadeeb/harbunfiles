@extends('minda.layout')

@section('title', 'Tambah Lembaga')
@section('page-title', 'Tambah Lembaga')

@section('content')
<div class="max-w-3xl">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <form id="lembagaForm" action="{{ route('minda.lembaga.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-5">
                <label class="block text-gray-700 font-semibold mb-2">Nama Lembaga <span class="text-red-500">*</span></label>
                <input type="text" name="nama" value="{{ old('nama') }}" required
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition @error('nama') border-red-500 @enderror"
                    placeholder="Nama lembaga">
                @error('nama')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Logo</label>
                    <input type="file" name="logo" accept="image/*"
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition">
                    <p class="text-xs text-gray-400 mt-1">Maks 2MB. Format: PNG, JPG</p>
                    @error('logo')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Banner / Foto</label>
                    <input type="file" id="bannerFileInput" accept="image/*" class="hidden">
                    <input type="hidden" name="banner_rasio" id="bannerRasioInput" value="3:1">

                    <!-- Cropped preview -->
                    <div id="bannerPreviewContainer" class="hidden mb-2">
                        <img id="bannerPreview" src="" alt="Banner Preview" class="w-full h-auto rounded-lg border-2 border-blue-200">
                        <div class="flex items-center justify-between mt-1">
                            <span id="bannerStatusText" class="text-xs text-blue-600 font-medium">Siap diupload</span>
                            <button type="button" id="bannerChangeBtn" class="text-xs text-blue-600 hover:text-blue-800 font-medium">Ganti</button>
                        </div>
                    </div>

                    <!-- Upload area -->
                    <div id="bannerDropzone" class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center cursor-pointer hover:border-blue-400 hover:bg-blue-50/50 transition"
                         onclick="document.getElementById('bannerFileInput').click()">
                        <svg class="w-8 h-8 text-gray-400 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <p class="text-sm text-gray-500 font-medium">Klik untuk pilih & crop foto banner</p>
                        <p class="text-xs text-gray-400 mt-1">Maks 5MB</p>
                    </div>
                    @error('banner')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-5 p-4 bg-gray-50 rounded-lg border border-gray-200">
                <h3 class="text-gray-700 font-bold mb-3">Teks Banner <span class="text-xs font-normal text-gray-400">(Opsional - kosongkan jika ingin foto saja)</span></h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-600 text-sm font-semibold mb-1">Judul Banner</label>
                        <input type="text" name="banner_judul" value="{{ old('banner_judul') }}"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition"
                            placeholder="Contoh: Bahagia Bersama, Harmoni dalam Karya">
                    </div>
                    <div>
                        <label class="block text-gray-600 text-sm font-semibold mb-1">Subjudul Banner</label>
                        <input type="text" name="banner_subjudul" value="{{ old('banner_subjudul') }}"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition"
                            placeholder="Contoh: Silaturahim Guru dan Karyawan">
                    </div>
                </div>
                <div>
                    <label class="block text-gray-600 text-sm font-semibold mb-1">Kutipan / Quote</label>
                    <textarea name="banner_kutipan" rows="2"
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition"
                        placeholder="Contoh: Wahai orang-orang yang beriman... (QS. Muhammad: 7)">{{ old('banner_kutipan') }}</textarea>
                </div>
            </div>

            <div class="mb-5">
                <label class="block text-gray-700 font-semibold mb-2">Deskripsi</label>
                <textarea name="deskripsi" rows="4"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition"
                    placeholder="Deskripsi lembaga...">{{ old('deskripsi') }}</textarea>
            </div>

            <div class="mb-5">
                <label class="block text-gray-700 font-semibold mb-2">Visi</label>
                <textarea name="visi" rows="3"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition"
                    placeholder="Visi lembaga...">{{ old('visi') }}</textarea>
            </div>

            <div class="mb-5">
                <label class="block text-gray-700 font-semibold mb-2">Misi</label>
                <textarea name="misi" rows="5"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition"
                    placeholder="Satu misi per baris...">{{ old('misi') }}</textarea>
                <p class="text-xs text-gray-400 mt-1">Tulis satu misi per baris</p>
            </div>

            <div class="mb-5">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="aktif" value="1" {{ old('aktif', true) ? 'checked' : '' }}
                        class="w-5 h-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    <span class="text-gray-700 font-semibold">Tampilkan di halaman utama</span>
                </label>
            </div>

            <!-- Linktree -->
            <div class="mb-5">
                <label class="block text-gray-700 font-semibold mb-2">
                    <span class="inline-flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                        Linktree (URL Kontak)
                    </span>
                </label>
                <input type="url" name="linktree" value="{{ old('linktree') }}"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition"
                    placeholder="https://linktr.ee/namaakun">
                <p class="text-xs text-gray-400 mt-1">Link ini akan muncul saat card di halaman Kontak diklik</p>
            </div>

            <!-- Footer -->
            <div class="mb-5 pt-4 border-t border-gray-200">
                <h3 class="text-lg font-bold text-gray-700 mb-2">Footer Lembaga</h3>
                <label class="block text-gray-700 font-semibold mb-2">Teks Footer</label>
                <textarea name="footer" rows="4"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition"
                    placeholder="Teks footer yang akan ditampilkan di halaman lembaga...">{{ old('footer') }}</textarea>
                <p class="text-xs text-gray-400 mt-1">Footer akan ditampilkan di bagian bawah halaman lembaga</p>
                
                <h4 class="text-md font-bold text-gray-700 mt-5 mb-3">Kontak Kami (Footer)</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            <span class="inline-flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                Telepon
                            </span>
                        </label>
                        <input type="text" name="footer_telepon" value="{{ old('footer_telepon') }}"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition"
                            placeholder="0281-1234567">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            <span class="inline-flex items-center gap-2">
                                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                Email
                            </span>
                        </label>
                        <input type="email" name="footer_email" value="{{ old('footer_email') }}"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition"
                            placeholder="email@lembaga.com">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            <span class="inline-flex items-center gap-2">
                                <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                                WhatsApp
                            </span>
                        </label>
                        <input type="text" name="footer_whatsapp" value="{{ old('footer_whatsapp') }}"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition"
                            placeholder="628123456789">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            <span class="inline-flex items-center gap-2">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                Alamat
                            </span>
                        </label>
                        <textarea name="footer_alamat" rows="3"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition"
                            placeholder="Jl. Nama Jalan No. 123, Kota">{{ old('footer_alamat') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-3 pt-4 border-t border-gray-200">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg font-medium transition">
                    Simpan Lembaga
                </button>
                <a href="{{ route('minda.lembaga.index') }}" class="text-gray-600 hover:text-gray-800 px-4 py-2.5 font-medium">Batal</a>
            </div>
        </form>
    </div>
</div>

@include('minda.lembaga._banner_cropper')
@endsection

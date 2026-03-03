@extends('minda.layout')

@section('title', 'Edit Lembaga')
@section('page-title', 'Edit Lembaga: ' . $lembaga->nama)

@section('content')
<div class="max-w-3xl">
    <a href="{{ route('minda.lembaga.index') }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-800 font-medium mb-4 transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Kembali ke Daftar Lembaga
    </a>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <form id="lembagaForm" action="{{ route('minda.lembaga.update', $lembaga->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-5">
                <label class="block text-gray-700 font-semibold mb-2">Nama Lembaga <span class="text-red-500">*</span></label>
                <input type="text" name="nama" value="{{ old('nama', $lembaga->nama) }}" required
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition @error('nama') border-red-500 @enderror"
                    placeholder="Nama lembaga">
                @error('nama')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Logo</label>
                    @php
                        $logoSrc = $lembaga->logo
                            ? (str_starts_with($lembaga->logo, 'images/') ? asset($lembaga->logo) : asset('storage/' . $lembaga->logo))
                            : null;
                    @endphp
                    @if($logoSrc)
                        <div class="mb-2 flex items-center gap-3">
                            <img src="{{ $logoSrc }}" alt="{{ $lembaga->nama }}" class="w-16 h-16 object-contain rounded border border-gray-200 p-1">
                            <span class="text-xs text-gray-500">Logo saat ini</span>
                        </div>
                    @endif
                    <input type="file" name="logo" accept="image/*"
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition">
                    <p class="text-xs text-gray-400 mt-1">Kosongkan jika tidak ingin mengubah. Maks 2MB.</p>
                    @error('logo')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Banner / Foto</label>
                    @php
                        $bannerSrc = $lembaga->banner
                            ? (str_starts_with($lembaga->banner, 'images/') ? asset($lembaga->banner) : asset('storage/' . $lembaga->banner))
                            : null;
                    @endphp
                    <input type="file" id="bannerFileInput" accept="image/*" class="hidden">
                    <input type="hidden" name="banner_rasio" id="bannerRasioInput" value="{{ old('banner_rasio', $lembaga->banner_rasio ?? '3:1') }}">

                    <!-- Cropped preview -->
                    <div id="bannerPreviewContainer" class="{{ $bannerSrc ? '' : 'hidden' }} mb-2">
                        <img id="bannerPreview" src="{{ $bannerSrc ?? '' }}" alt="Banner Preview" class="w-full h-auto rounded-lg border-2 border-blue-200">
                        <div class="flex items-center justify-between mt-1">
                            <span id="bannerStatusText" class="text-xs text-green-600 font-medium">{{ $bannerSrc ? 'Banner saat ini' : 'Siap diupload' }}</span>
                            <button type="button" id="bannerChangeBtn" class="text-xs text-blue-600 hover:text-blue-800 font-medium">Ganti</button>
                        </div>
                    </div>

                    <!-- Upload area -->
                    <div id="bannerDropzone" class="{{ $bannerSrc ? 'hidden' : '' }} border-2 border-dashed border-gray-300 rounded-lg p-4 text-center cursor-pointer hover:border-blue-400 hover:bg-blue-50/50 transition"
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
                        <input type="text" name="banner_judul" value="{{ old('banner_judul', $lembaga->banner_judul) }}"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition"
                            placeholder="Contoh: Bahagia Bersama, Harmoni dalam Karya">
                    </div>
                    <div>
                        <label class="block text-gray-600 text-sm font-semibold mb-1">Subjudul Banner</label>
                        <input type="text" name="banner_subjudul" value="{{ old('banner_subjudul', $lembaga->banner_subjudul) }}"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition"
                            placeholder="Contoh: Silaturahim Guru dan Karyawan">
                    </div>
                </div>
                <div>
                    <label class="block text-gray-600 text-sm font-semibold mb-1">Kutipan / Quote</label>
                    <textarea name="banner_kutipan" rows="2"
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition"
                        placeholder="Contoh: Wahai orang-orang yang beriman... (QS. Muhammad: 7)">{{ old('banner_kutipan', $lembaga->banner_kutipan) }}</textarea>
                </div>
            </div>

            <div class="mb-5">
                <label class="block text-gray-700 font-semibold mb-2">Deskripsi</label>
                <textarea name="deskripsi" rows="4"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition"
                    placeholder="Deskripsi lembaga...">{{ old('deskripsi', $lembaga->deskripsi) }}</textarea>
            </div>

            <div class="mb-5">
                <label class="block text-gray-700 font-semibold mb-2">Visi</label>
                <textarea name="visi" rows="3"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition"
                    placeholder="Visi lembaga...">{{ old('visi', $lembaga->visi) }}</textarea>
            </div>

            <div class="mb-5">
                <label class="block text-gray-700 font-semibold mb-2">Misi</label>
                <textarea name="misi" rows="5"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition"
                    placeholder="Satu misi per baris...">{{ old('misi', is_array($lembaga->misi) ? implode("\n", $lembaga->misi) : $lembaga->misi) }}</textarea>
                <p class="text-xs text-gray-400 mt-1">Tulis satu misi per baris</p>
            </div>

            <div class="mb-5">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="aktif" value="1" {{ old('aktif', $lembaga->aktif) ? 'checked' : '' }}
                        class="w-5 h-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    <span class="text-gray-700 font-semibold">Tampilkan di halaman utama</span>
                </label>
            </div>

            <!-- Sosial Media -->
            <div class="mb-5 pt-4 border-t border-gray-200">
                <h3 class="text-lg font-bold text-gray-700 mb-4">Sosial Media Lembaga</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            <span class="inline-flex items-center gap-2">
                                <svg class="w-5 h-5 text-pink-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                                Instagram
                            </span>
                        </label>
                        <input type="text" name="instagram" value="{{ old('instagram', $lembaga->instagram) }}"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition"
                            placeholder="https://instagram.com/namaakun">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            <span class="inline-flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                Facebook
                            </span>
                        </label>
                        <input type="text" name="facebook" value="{{ old('facebook', $lembaga->facebook) }}"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition"
                            placeholder="https://facebook.com/namahalaman">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            <span class="inline-flex items-center gap-2">
                                <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                                YouTube
                            </span>
                        </label>
                        <input type="text" name="youtube" value="{{ old('youtube', $lembaga->youtube) }}"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition"
                            placeholder="https://youtube.com/@channel">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            <span class="inline-flex items-center gap-2">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61.04 3.93.245 3.17.36 5.3 1.845 6.08 4.975.72 2.89.72 8.94.72 8.94s0 5.87-.72 8.76c-.78 3.13-2.91 4.61-6.08 4.97-3.18.36-6.36.36-9.53 0-3.17-.36-5.3-1.84-6.08-4.97C.12 19.81.12 13.76.12 13.76s0-6.05.72-8.94C1.62 1.69 3.75.205 6.92-.155c1.32-.205 2.62-.285 3.93-.265h1.68zm-1.9 7.07v13.4l8.97-6.7-8.97-6.7z"/></svg>
                                TikTok
                            </span>
                        </label>
                        <input type="text" name="tiktok" value="{{ old('tiktok', $lembaga->tiktok) }}"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition"
                            placeholder="https://tiktok.com/@username">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-gray-700 font-semibold mb-2">
                            <span class="inline-flex items-center gap-2">
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
                                Website
                            </span>
                        </label>
                        <input type="text" name="website" value="{{ old('website', $lembaga->website) }}"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition"
                            placeholder="https://www.namawebsite.com">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-gray-700 font-semibold mb-2">
                            <span class="inline-flex items-center gap-2">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                                Linktree (URL Kontak)
                            </span>
                        </label>
                        <input type="url" name="linktree" value="{{ old('linktree', $lembaga->linktree) }}"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition"
                            placeholder="https://linktr.ee/namaakun">
                        <p class="text-xs text-gray-400 mt-1">Link ini akan muncul saat card di halaman Kontak diklik</p>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="mb-5 pt-4 border-t border-gray-200">
                <h3 class="text-lg font-bold text-gray-700 mb-2">Footer Lembaga</h3>
                <label class="block text-gray-700 font-semibold mb-2">Teks Footer</label>
                <textarea name="footer" rows="4"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition"
                    placeholder="Teks footer yang akan ditampilkan di halaman lembaga...">{{ old('footer', $lembaga->footer) }}</textarea>
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
                        <input type="text" name="footer_telepon" value="{{ old('footer_telepon', $lembaga->footer_telepon) }}"
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
                        <input type="email" name="footer_email" value="{{ old('footer_email', $lembaga->footer_email) }}"
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
                        <input type="text" name="footer_whatsapp" value="{{ old('footer_whatsapp', $lembaga->footer_whatsapp) }}"
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
                            placeholder="Jl. Nama Jalan No. 123, Kota">{{ old('footer_alamat', $lembaga->footer_alamat) }}</textarea>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-3 pt-4 border-t border-gray-200">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg font-medium transition">
                    Update Lembaga
                </button>
                <a href="{{ route('minda.lembaga.index') }}" class="text-gray-600 hover:text-gray-800 px-4 py-2.5 font-medium">Batal</a>
            </div>
        </form>
    </div>
</div>

@include('minda.lembaga._banner_cropper')
@endsection

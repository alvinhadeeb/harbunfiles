@extends('minda.layout')

@section('title', 'Ganti Favicon')
@section('page-title', 'Ganti Favicon (Logo Tab Browser)')

@section('content')
<div class="max-w-2xl">
    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <h2 class="text-lg font-bold text-gray-800">Favicon Saat Ini</h2>
            <p class="text-sm text-gray-500 mt-1">Favicon adalah ikon kecil yang muncul di tab browser</p>
        </div>

        <div class="p-6">
            <!-- Preview favicon saat ini -->
            <div class="mb-6">
                <div class="flex items-center gap-4">
                    <div class="w-20 h-20 bg-gray-100 rounded-xl flex items-center justify-center border-2 border-dashed border-gray-300">
                        @if($currentFavicon)
                            <img src="{{ $currentFavicon }}" alt="Favicon saat ini" class="w-16 h-16 object-contain">
                        @else
                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        @endif
                    </div>
                    <div>
                        <p class="font-semibold text-gray-700">{{ $currentFavicon ? 'Favicon aktif' : 'Belum ada favicon' }}</p>
                        <p class="text-sm text-gray-500">Tampil di tab browser seperti ini:</p>
                        <!-- Mock browser tab -->
                        <div class="mt-2 inline-flex items-center gap-2 bg-gray-700 text-white text-xs px-3 py-1.5 rounded-t-lg">
                            @if($currentFavicon)
                                <img src="{{ $currentFavicon }}" class="w-4 h-4 object-contain">
                            @else
                                <div class="w-4 h-4 bg-gray-500 rounded"></div>
                            @endif
                            <span>Harapan Bunda Purwokerto</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Upload form -->
            <form action="{{ route('minda.favicon.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-5">
                    <label class="block text-gray-700 font-semibold mb-2">Upload Favicon Baru</label>
                    <div id="drop-zone" class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:border-blue-400 transition cursor-pointer">
                        <input type="file" name="favicon" id="favicon-input" accept="image/*" class="hidden" required>
                        <div id="drop-content">
                            <svg class="w-12 h-12 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                            <p class="text-gray-600 font-medium">Klik atau drag & drop gambar di sini</p>
                            <p class="text-sm text-gray-400 mt-1">PNG, JPG, ICO, SVG, WebP • Maks 1MB</p>
                            <p class="text-xs text-gray-400 mt-1">Rekomendasi: gambar kotak (1:1), minimal 64x64px</p>
                        </div>
                        <div id="preview-content" class="hidden">
                            <img id="preview-img" class="w-20 h-20 mx-auto object-contain mb-3">
                            <p id="preview-name" class="text-gray-600 font-medium"></p>
                            <p class="text-sm text-blue-500 mt-1">Klik untuk ganti gambar lain</p>
                        </div>
                    </div>
                    @error('favicon')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" id="submit-btn" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg font-medium transition disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                    <span class="inline-flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                        </svg>
                        Simpan Favicon
                    </span>
                </button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const dropZone = document.getElementById('drop-zone');
    const fileInput = document.getElementById('favicon-input');
    const dropContent = document.getElementById('drop-content');
    const previewContent = document.getElementById('preview-content');
    const previewImg = document.getElementById('preview-img');
    const previewName = document.getElementById('preview-name');
    const submitBtn = document.getElementById('submit-btn');

    dropZone.addEventListener('click', () => fileInput.click());

    dropZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropZone.classList.add('border-blue-400', 'bg-blue-50');
    });

    dropZone.addEventListener('dragleave', () => {
        dropZone.classList.remove('border-blue-400', 'bg-blue-50');
    });

    dropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropZone.classList.remove('border-blue-400', 'bg-blue-50');
        if (e.dataTransfer.files.length) {
            fileInput.files = e.dataTransfer.files;
            showPreview(e.dataTransfer.files[0]);
        }
    });

    fileInput.addEventListener('change', () => {
        if (fileInput.files.length) {
            showPreview(fileInput.files[0]);
        }
    });

    function showPreview(file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            previewImg.src = e.target.result;
            previewName.textContent = file.name;
            dropContent.classList.add('hidden');
            previewContent.classList.remove('hidden');
            submitBtn.disabled = false;
        };
        reader.readAsDataURL(file);
    }
</script>
@endpush
@endsection

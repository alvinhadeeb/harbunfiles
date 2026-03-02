@extends('minda.layout')
@section('title', 'Kompres Foto')
@section('page-title', 'Kompres Foto')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl shadow-lg p-8">
        <div class="text-center mb-8">
            <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <h2 class="text-xl font-bold text-gray-800 mb-2">Kompres Foto (Max 2 MB)</h2>
            <p class="text-gray-500 text-sm">Upload foto, otomatis dikompres agar ukurannya tidak lebih dari 2 MB. Bisa upload banyak foto sekaligus.</p>
        </div>

        <!-- Upload Area -->
        <div id="dropZone" class="border-2 border-dashed border-gray-300 rounded-xl p-10 text-center cursor-pointer hover:border-blue-400 hover:bg-blue-50/30 transition-all duration-200"
             onclick="document.getElementById('fileInput').click()">
            <svg class="w-12 h-12 mx-auto mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
            </svg>
            <p class="text-gray-600 font-medium mb-1">Klik atau drag & drop foto ke sini</p>
            <p class="text-gray-400 text-sm">Mendukung JPG, PNG, WEBP (bisa pilih banyak foto)</p>
        </div>
        <input type="file" id="fileInput" accept="image/*" multiple class="hidden" onchange="handleFiles(this.files)">

        <!-- Max Size Setting -->
        <div class="mt-6 flex items-center gap-4 bg-gray-50 rounded-xl p-4">
            <label class="text-sm font-medium text-gray-700 whitespace-nowrap">Max ukuran:</label>
            <select id="maxSizeSelect" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="0.5">500 KB</option>
                <option value="1">1 MB</option>
                <option value="2" selected>2 MB</option>
                <option value="3">3 MB</option>
                <option value="5">5 MB</option>
            </select>
        </div>

        <!-- Results Area -->
        <div id="resultsArea" class="mt-8 hidden">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-bold text-gray-800 text-lg">Hasil Kompresi</h3>
                <button onclick="downloadAll()" id="downloadAllBtn" class="px-5 py-2 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-lg font-medium hover:from-green-600 hover:to-emerald-700 transition shadow text-sm hidden">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    Download Semua
                </button>
            </div>
            <div id="resultsList" class="space-y-4"></div>
        </div>
    </div>
</div>

@push('scripts')
<script>
const dropZone = document.getElementById('dropZone');
const resultsArea = document.getElementById('resultsArea');
const resultsList = document.getElementById('resultsList');
const downloadAllBtn = document.getElementById('downloadAllBtn');
let compressedFiles = [];

// Drag & Drop
dropZone.addEventListener('dragover', function(e) {
    e.preventDefault();
    dropZone.classList.add('border-blue-500', 'bg-blue-50');
});
dropZone.addEventListener('dragleave', function(e) {
    e.preventDefault();
    dropZone.classList.remove('border-blue-500', 'bg-blue-50');
});
dropZone.addEventListener('drop', function(e) {
    e.preventDefault();
    dropZone.classList.remove('border-blue-500', 'bg-blue-50');
    handleFiles(e.dataTransfer.files);
});

function formatSize(bytes) {
    if (bytes < 1024) return bytes + ' B';
    if (bytes < 1048576) return (bytes / 1024).toFixed(1) + ' KB';
    return (bytes / 1048576).toFixed(2) + ' MB';
}

function handleFiles(files) {
    if (!files.length) return;
    resultsArea.classList.remove('hidden');

    for (let i = 0; i < files.length; i++) {
        if (!files[i].type.startsWith('image/')) continue;
        compressImage(files[i]);
    }
}

function compressImage(file) {
    const maxSizeMB = parseFloat(document.getElementById('maxSizeSelect').value);
    const maxBytes = maxSizeMB * 1024 * 1024;
    const outputFormat = 'image/jpeg';
    const ext = '.jpg';

    const id = 'item-' + Date.now() + '-' + Math.random().toString(36).substr(2, 5);

    // Add loading card
    const card = document.createElement('div');
    card.id = id;
    card.className = 'bg-gray-50 rounded-xl p-4 border border-gray-200';
    card.innerHTML = `
        <div class="flex items-center gap-4">
            <div class="w-20 h-20 rounded-lg bg-gray-200 animate-pulse flex-shrink-0"></div>
            <div class="flex-1">
                <p class="font-medium text-gray-800 text-sm">${file.name}</p>
                <p class="text-gray-400 text-xs mt-1">Ukuran asli: ${formatSize(file.size)}</p>
                <div class="mt-2 flex items-center gap-2">
                    <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden">
                        <div class="h-full bg-blue-500 rounded-full animate-pulse" style="width: 60%"></div>
                    </div>
                    <span class="text-xs text-blue-600 font-medium">Mengompres...</span>
                </div>
            </div>
        </div>
    `;
    resultsList.prepend(card);

    const reader = new FileReader();
    reader.onload = function(e) {
        const img = new Image();
        img.onload = function() {
            // Jika file sudah <= maxBytes, langsung tampilkan
            if (file.size <= maxBytes) {
                showResult(id, file, file, img.src, file.name, 100);
                return;
            }

            // Binary search quality
            let lo = 0.1, hi = 1.0, bestBlob = null, bestUrl = null;

            function tryCompress(quality) {
                const canvas = document.createElement('canvas');
                let w = img.width, h = img.height;

                // Scale down kalau masih terlalu besar
                const maxDim = quality < 0.3 ? 1920 : 3840;
                if (w > maxDim || h > maxDim) {
                    const ratio = Math.min(maxDim / w, maxDim / h);
                    w = Math.round(w * ratio);
                    h = Math.round(h * ratio);
                }

                canvas.width = w;
                canvas.height = h;
                const ctx = canvas.getContext('2d');
                ctx.fillStyle = '#ffffff';
                ctx.fillRect(0, 0, w, h);
                ctx.drawImage(img, 0, 0, w, h);

                canvas.toBlob(function(blob) {
                    if (!blob) return;

                    if (blob.size <= maxBytes) {
                        bestBlob = blob;
                        bestUrl = URL.createObjectURL(blob);
                    }

                    if (hi - lo < 0.03 || (bestBlob && bestBlob.size <= maxBytes && bestBlob.size > maxBytes * 0.7)) {
                        // Done - show result
                        if (!bestBlob) {
                            // Even worst quality is too big, try with smaller dimensions
                            compressWithResize(id, file, img, maxBytes, outputFormat, ext);
                        } else {
                            const baseName = file.name.replace(/\.[^.]+$/, '');
                            showResult(id, file, bestBlob, bestUrl, baseName + '_kompres' + ext, Math.round((1 - bestBlob.size / file.size) * 100));
                        }
                        return;
                    }

                    if (blob.size > maxBytes) {
                        hi = quality;
                    } else {
                        lo = quality;
                    }

                    tryCompress((lo + hi) / 2);
                }, outputFormat, quality);
            }

            tryCompress(0.7);
        };
        img.src = e.target.result;
    };
    reader.readAsDataURL(file);
}

function compressWithResize(id, file, img, maxBytes, outputFormat, ext) {
    let scale = 0.9;

    function attempt() {
        const canvas = document.createElement('canvas');
        const w = Math.round(img.width * scale);
        const h = Math.round(img.height * scale);
        canvas.width = w;
        canvas.height = h;
        const ctx = canvas.getContext('2d');
        ctx.fillStyle = '#ffffff';
        ctx.fillRect(0, 0, w, h);
        ctx.drawImage(img, 0, 0, w, h);

        canvas.toBlob(function(blob) {
            if (blob && blob.size <= maxBytes) {
                const baseName = file.name.replace(/\.[^.]+$/, '');
                const url = URL.createObjectURL(blob);
                showResult(id, file, blob, url, baseName + '_kompres' + ext, Math.round((1 - blob.size / file.size) * 100));
            } else if (scale > 0.1) {
                scale -= 0.1;
                attempt();
            } else {
                // Give up - use lowest quality and smallest scale
                const card = document.getElementById(id);
                if (card) {
                    card.innerHTML = `
                        <div class="flex items-center gap-4">
                            <div class="w-20 h-20 rounded-lg bg-red-100 flex items-center justify-center flex-shrink-0">
                                <svg class="w-8 h-8 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div>
                                <p class="font-medium text-gray-800 text-sm">${file.name}</p>
                                <p class="text-red-500 text-xs mt-1">Gagal dikompres ke target ukuran. Coba pilih format JPEG atau WEBP.</p>
                            </div>
                        </div>
                    `;
                }
            }
        }, outputFormat, 0.5);
    }
    attempt();
}

function showResult(id, originalFile, blob, url, fileName, savedPercent) {
    const card = document.getElementById(id);
    if (!card) return;

    const sizeReduced = savedPercent > 0;
    const statusColor = sizeReduced ? 'text-green-600' : 'text-blue-600';
    const statusBg = sizeReduced ? 'bg-green-50 border-green-200' : 'bg-blue-50 border-blue-200';
    const statusText = originalFile.size <= parseFloat(document.getElementById('maxSizeSelect').value) * 1024 * 1024
        ? 'Sudah kecil, tidak perlu kompres'
        : `Hemat ${savedPercent}%`;

    compressedFiles.push({ url, fileName });
    if (compressedFiles.length > 1) downloadAllBtn.classList.remove('hidden');

    card.className = `${statusBg} rounded-xl p-4 border`;
    card.innerHTML = `
        <div class="flex items-center gap-4">
            <img src="${url}" class="w-20 h-20 rounded-lg object-cover flex-shrink-0 border border-gray-200">
            <div class="flex-1 min-w-0">
                <p class="font-medium text-gray-800 text-sm truncate">${originalFile.name}</p>
                <div class="flex items-center gap-3 mt-1 text-xs">
                    <span class="text-gray-400">${formatSize(originalFile.size)}</span>
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                    <span class="font-bold ${statusColor}">${formatSize(blob.size)}</span>
                    <span class="px-2 py-0.5 rounded-full text-xs font-medium ${sizeReduced ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700'}">${statusText}</span>
                </div>
            </div>
            <a href="${url}" download="${fileName}" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition flex-shrink-0">
                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                Download
            </a>
        </div>
    `;
}

function downloadAll() {
    compressedFiles.forEach(function(f, i) {
        setTimeout(function() {
            const a = document.createElement('a');
            a.href = f.url;
            a.download = f.fileName;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
        }, i * 300);
    });
}
</script>
@endpush
@endsection

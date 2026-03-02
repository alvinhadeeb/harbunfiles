{{-- Banner Cropper Modal + Upload Progress + Scripts --}}

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css">
<style>
    .cropper-view-box, .cropper-face { border-radius: 0; }
</style>
@endpush

<!-- Cropper Modal -->
<div id="cropperModal" class="fixed inset-0 z-[9999] hidden items-center justify-center bg-black/70">
    <div class="bg-white rounded-2xl shadow-2xl w-[95vw] max-w-4xl max-h-[90vh] flex flex-col overflow-hidden">
        <!-- Header -->
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-bold text-gray-800">Crop Foto Banner</h3>
            <button type="button" onclick="closeCropperModal()" class="text-gray-400 hover:text-gray-600 text-2xl leading-none">&times;</button>
        </div>

        <!-- Cropper Area -->
        <div class="flex-1 overflow-hidden bg-gray-900" style="min-height: 350px; max-height: 60vh;">
            <img id="cropperImage" src="" alt="Crop" style="display: block; max-width: 100%;">
        </div>

        <!-- Controls -->
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
            <div class="flex flex-wrap items-center gap-2 mb-3">
                <span class="text-xs text-gray-500 font-medium mr-1">Rasio:</span>
                <button type="button" class="aspect-btn px-3 py-1 rounded-full text-xs font-medium bg-blue-600 text-white transition" onclick="setAspectRatio(3/1, this)">3:1</button>
                <button type="button" class="aspect-btn px-3 py-1 rounded-full text-xs font-medium bg-gray-200 text-gray-700 transition" onclick="setAspectRatio(16/9, this)">16:9</button>
                <button type="button" class="aspect-btn px-3 py-1 rounded-full text-xs font-medium bg-gray-200 text-gray-700 transition" onclick="setAspectRatio(2/1, this)">2:1</button>
                <button type="button" class="aspect-btn px-3 py-1 rounded-full text-xs font-medium bg-gray-200 text-gray-700 transition" onclick="setAspectRatio(NaN, this)">Bebas</button>

                <div class="ml-auto flex items-center gap-1">
                    <button type="button" onclick="zoomCrop(-0.1)" class="w-8 h-8 rounded-lg bg-gray-200 hover:bg-gray-300 flex items-center justify-center text-gray-600" title="Zoom Out">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/></svg>
                    </button>
                    <button type="button" onclick="zoomCrop(0.1)" class="w-8 h-8 rounded-lg bg-gray-200 hover:bg-gray-300 flex items-center justify-center text-gray-600" title="Zoom In">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    </button>
                    <button type="button" onclick="rotateCrop(-90)" class="w-8 h-8 rounded-lg bg-gray-200 hover:bg-gray-300 flex items-center justify-center text-gray-600" title="Putar Kiri">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.5 2v6h6M2.66 15.57a10 10 0 1 0 .57-8.38"/></svg>
                    </button>
                    <button type="button" onclick="rotateCrop(90)" class="w-8 h-8 rounded-lg bg-gray-200 hover:bg-gray-300 flex items-center justify-center text-gray-600" title="Putar Kanan">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21.5 2v6h-6M21.34 15.57a10 10 0 1 1-.57-8.38"/></svg>
                    </button>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <button type="button" onclick="applyCrop()" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg font-medium transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Crop & Gunakan
                </button>
                <button type="button" onclick="closeCropperModal()" class="text-gray-600 hover:text-gray-800 px-4 py-2.5 font-medium">Batal</button>
            </div>
        </div>
    </div>
</div>

<!-- Upload Progress Overlay -->
<div id="uploadOverlay" class="fixed inset-0 z-[9998] hidden items-center justify-center bg-black/50">
    <div class="bg-white rounded-2xl shadow-2xl p-8 w-96 text-center">
        <div class="mb-4">
            <svg class="w-12 h-12 text-blue-500 mx-auto animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
            </svg>
        </div>
        <h3 id="uploadTitle" class="text-lg font-bold text-gray-800 mb-2">Mengupload...</h3>
        <div class="w-full bg-gray-200 rounded-full h-3 mb-3 overflow-hidden">
            <div id="progressBar" class="bg-blue-600 h-3 rounded-full transition-all duration-300 ease-out" style="width: 0%"></div>
        </div>
        <div class="flex items-center justify-between text-sm">
            <span id="progressDetail" class="text-gray-500">Mengirim data...</span>
            <span id="progressText" class="font-bold text-blue-600">0%</span>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var cropper = null;
    var croppedBannerBlob = null;

    var form = document.getElementById('lembagaForm');
    var fileInput = document.getElementById('bannerFileInput');
    var cropperModal = document.getElementById('cropperModal');
    var cropperImage = document.getElementById('cropperImage');
    var previewContainer = document.getElementById('bannerPreviewContainer');
    var previewImg = document.getElementById('bannerPreview');
    var dropzone = document.getElementById('bannerDropzone');
    var statusText = document.getElementById('bannerStatusText');
    var uploadOverlay = document.getElementById('uploadOverlay');
    var progressBar = document.getElementById('progressBar');
    var progressText = document.getElementById('progressText');
    var progressDetail = document.getElementById('progressDetail');
    var uploadTitle = document.getElementById('uploadTitle');

    function formatSize(bytes) {
        if (bytes < 1024) return bytes + ' B';
        if (bytes < 1048576) return (bytes / 1024).toFixed(1) + ' KB';
        return (bytes / 1048576).toFixed(1) + ' MB';
    }

    // === FILE INPUT HANDLER ===
    fileInput.addEventListener('change', function () {
        var file = this.files[0];
        if (!file) return;
        if (!file.type.startsWith('image/')) { alert('Pilih file gambar!'); return; }
        if (file.size > 5 * 1024 * 1024) { alert('Ukuran file maksimal 5MB!'); return; }

        var reader = new FileReader();
        reader.onload = function (e) {
            cropperImage.src = e.target.result;
            openCropperModal();
        };
        reader.readAsDataURL(file);
    });

    // === CHANGE BUTTON ===
    var changeBtn = document.getElementById('bannerChangeBtn');
    if (changeBtn) {
        changeBtn.addEventListener('click', function () { fileInput.click(); });
    }

    // === CROPPER MODAL ===
    function openCropperModal() {
        cropperModal.classList.remove('hidden');
        cropperModal.classList.add('flex');
        document.body.style.overflow = 'hidden';

        setTimeout(function () {
            if (cropper) { cropper.destroy(); cropper = null; }

            // Detect saved ratio from hidden input
            var rasioInput = document.getElementById('bannerRasioInput');
            var savedRatio = rasioInput ? rasioInput.value : '3:1';
            var ratioMap = { '3:1': 3/1, '16:9': 16/9, '2:1': 2/1, 'bebas': NaN };
            var initRatio = ratioMap[savedRatio] !== undefined ? ratioMap[savedRatio] : 3/1;

            cropper = new Cropper(cropperImage, {
                aspectRatio: initRatio,
                viewMode: 1,
                dragMode: 'move',
                autoCropArea: 0.9,
                responsive: true,
                guides: true,
                center: true,
                cropBoxMovable: true,
                cropBoxResizable: true,
                background: true,
            });

            // Highlight the correct button
            document.querySelectorAll('.aspect-btn').forEach(function(b) {
                b.classList.remove('bg-blue-600', 'text-white');
                b.classList.add('bg-gray-200', 'text-gray-700');
                if (b.textContent.trim() === savedRatio || (savedRatio === 'bebas' && b.textContent.trim() === 'Bebas')) {
                    b.classList.remove('bg-gray-200', 'text-gray-700');
                    b.classList.add('bg-blue-600', 'text-white');
                }
            });
        }, 200);
    }

    window.closeCropperModal = function () {
        if (cropper) { cropper.destroy(); cropper = null; }
        cropperModal.classList.add('hidden');
        cropperModal.classList.remove('flex');
        document.body.style.overflow = '';
        fileInput.value = '';
    };

    window.setAspectRatio = function (ratio, btn) {
        if (cropper) cropper.setAspectRatio(ratio);
        document.querySelectorAll('.aspect-btn').forEach(function (b) {
            b.classList.remove('bg-blue-600', 'text-white');
            b.classList.add('bg-gray-200', 'text-gray-700');
        });
        if (btn) {
            btn.classList.remove('bg-gray-200', 'text-gray-700');
            btn.classList.add('bg-blue-600', 'text-white');
            // Track selected ratio for form submission
            var rasioInput = document.getElementById('bannerRasioInput');
            if (rasioInput) {
                var label = btn.textContent.trim();
                rasioInput.value = label === 'Bebas' ? 'bebas' : label;
            }
        }
    };

    window.zoomCrop = function (v) { if (cropper) cropper.zoom(v); };
    window.rotateCrop = function (v) { if (cropper) cropper.rotate(v); };

    window.applyCrop = function () {
        if (!cropper) return;

        var canvas = cropper.getCroppedCanvas({
            maxWidth: 1920,
            imageSmoothingEnabled: true,
            imageSmoothingQuality: 'high',
        });

        canvas.toBlob(function (blob) {
            croppedBannerBlob = blob;
            previewImg.src = URL.createObjectURL(blob);
            previewContainer.classList.remove('hidden');
            dropzone.classList.add('hidden');
            statusText.textContent = 'Foto di-crop (' + formatSize(blob.size) + ') — siap upload';
            statusText.className = 'text-xs text-blue-600 font-medium';
            closeCropperModal();
        }, 'image/jpeg', 0.92);
    };

    // === FORM SUBMIT WITH PROGRESS ===
    form.addEventListener('submit', function (e) {
        e.preventDefault();

        var formData = new FormData(form);

        // Replace banner file with cropped blob if available
        if (croppedBannerBlob) {
            formData.delete('banner');
            formData.append('banner', croppedBannerBlob, 'banner.jpg');
        }

        // Show progress overlay
        uploadOverlay.classList.remove('hidden');
        uploadOverlay.classList.add('flex');
        progressBar.style.width = '0%';
        progressText.textContent = '0%';
        progressDetail.textContent = 'Mengirim data...';
        uploadTitle.textContent = 'Mengupload...';

        var xhr = new XMLHttpRequest();

        xhr.upload.addEventListener('progress', function (e) {
            if (e.lengthComputable) {
                var pct = Math.round((e.loaded / e.total) * 100);
                progressBar.style.width = pct + '%';
                progressText.textContent = pct + '%';
                progressDetail.textContent = formatSize(e.loaded) + ' / ' + formatSize(e.total);
            }
        });

        xhr.addEventListener('load', function () {
            if (xhr.status >= 200 && xhr.status < 300) {
                progressBar.style.width = '100%';
                progressText.textContent = '100%';
                uploadTitle.textContent = 'Berhasil!';
                progressDetail.textContent = 'Mengalihkan...';
                try {
                    var data = JSON.parse(xhr.responseText);
                    setTimeout(function () { window.location.href = data.redirect; }, 600);
                } catch (ex) {
                    setTimeout(function () { window.location.href = xhr.responseURL || window.location.href; }, 600);
                }
            } else if (xhr.status === 422) {
                uploadOverlay.classList.add('hidden');
                uploadOverlay.classList.remove('flex');
                try {
                    var errors = JSON.parse(xhr.responseText);
                    var msg = 'Validasi gagal:\n';
                    if (errors.errors) {
                        Object.keys(errors.errors).forEach(function (key) {
                            errors.errors[key].forEach(function (m) { msg += '• ' + m + '\n'; });
                        });
                    }
                    alert(msg);
                } catch (ex) {
                    alert('Validasi gagal. Periksa kembali data Anda.');
                }
            } else {
                uploadOverlay.classList.add('hidden');
                uploadOverlay.classList.remove('flex');
                alert('Gagal menyimpan (status: ' + xhr.status + ')');
            }
        });

        xhr.addEventListener('error', function () {
            uploadOverlay.classList.add('hidden');
            uploadOverlay.classList.remove('flex');
            alert('Terjadi kesalahan jaringan. Silakan coba lagi.');
        });

        xhr.open('POST', form.action);
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.send(formData);
    });
});
</script>
@endpush

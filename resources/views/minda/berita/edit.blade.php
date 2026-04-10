@extends('minda.layout')

@section('title', 'Edit Berita')
@section('page-title', 'Edit Berita')

@section('content')
<div class="max-w-4xl">
    <div class="bg-white rounded-xl shadow-lg p-8">
        <form action="{{ route('minda.berita.update', $berita->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Judul Berita <span class="text-red-500">*</span></label>
                <input type="text" name="judul" value="{{ old('judul', $berita->judul) }}" required
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
                        <option value="{{ $kat->nama }}" {{ old('kategori', $berita->kategori) == $kat->nama ? 'selected' : '' }}>{{ $kat->nama }}</option>
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
                                {{ in_array($lembaga->id, old('lembaga_ids', $selectedLembagas)) ? 'checked' : '' }}
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
                <p class="text-gray-600 text-sm mb-2">Mudahnya: tulis konten biasa saja, foto sisipan akan tampil otomatis di sela paragraf.</p>
                <textarea name="konten" rows="10" required
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition @error('konten') border-red-500 @enderror">{{ old('konten', $berita->konten) }}</textarea>
                @error('konten')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Konten Berita</label>
                @if($berita->gambar)
                    <div class="mb-3">
                        <img src="{{ asset('storage/'.$berita->gambar) }}" alt="{{ $berita->judul }}" class="w-32 h-32 object-cover rounded-lg">
                        <p class="text-sm text-gray-500 mt-2">Konten berita saat ini</p>
                    </div>
                @endif
                <input type="file" name="gambar" accept="image/*"
                    id="berita-gambar-input"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition @error('gambar') border-red-500 @enderror">
                <p class="text-gray-500 text-sm mt-1">Format: JPG, PNG. Maksimal 2MB. Kosongkan jika tidak ingin mengubah gambar.</p>
                <div id="berita-gambar-preview" class="mt-3 hidden"></div>
                @error('gambar')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            
                @if($berita->inlineImages->count())
                    <div id="inline-image-list" class="grid grid-cols-2 md:grid-cols-3 gap-3 mb-5 pb-5 border-b border-gray-200">
                        @foreach($berita->inlineImages as $inlineImage)
                            <div class="block rounded-lg border border-gray-200 p-2 bg-gray-50 group relative cursor-move" draggable="true" data-inline-image-id="{{ $inlineImage->id }}">
                                <img src="{{ asset('storage/' . $inlineImage->path) }}" alt="Foto sisipan" class="w-full h-24 object-cover rounded mb-2">
                                <p class="text-xs font-semibold text-indigo-700 mb-2">Kode Foto {{ $loop->iteration }}: (foto{{ $loop->iteration }})</p>
                                <button type="button" class="w-full inline-flex items-center justify-center gap-2 px-3 py-1.5 bg-red-50 text-red-600 rounded text-xs font-medium hover:bg-red-100 transition delete-image-btn" data-image-id="{{ $inlineImage->id }}" data-image-name="Foto {{ $loop->iteration }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    Hapus
                                </button>
                            </div>
                        @endforeach
                    </div>
                    <div id="inline-image-order-inputs">
                        @foreach($berita->inlineImages as $inlineImage)
                            <input type="hidden" name="inline_image_order[]" value="{{ $inlineImage->id }}">
                        @endforeach
                    </div>
                    <div id="remove-inline-image-container"></div>
                @endif

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
                @error('remove_inline_image_ids')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <input type="hidden" name="status" value="published">

            <div class="mt-8 mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Tanggal Berita</label>
                <input type="date" name="tanggal" value="{{ old('tanggal', $berita->tanggal ? $berita->tanggal->format('Y-m-d') : $berita->created_at->format('Y-m-d')) }}"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition @error('tanggal') border-red-500 @enderror">
                <p class="text-gray-500 text-sm mt-1">Pilih tanggal berita (untuk berita lama)</p>
                @error('tanggal')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-3">
                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg font-semibold hover:from-blue-700 hover:to-indigo-700 transition shadow-lg">
                    Update Berita
                </button>
                <a href="{{ route('minda.berita.index') }}" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg font-semibold hover:bg-gray-300 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<style>
    @keyframes slideOutAndFade {
        from {
            opacity: 1;
            transform: scale(1);
        }
        to {
            opacity: 0;
            transform: scale(0.95);
        }
    }
    
    .animate-delete {
        animation: slideOutAndFade 0.3s ease-out forwards;
    }

    @keyframes modalFadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    @keyframes modalScaleIn {
        from {
            opacity: 0;
            transform: scale(0.9);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    #delete-modal {
        animation: modalFadeIn 0.2s ease-out;
    }

    #delete-modal .modal-content {
        animation: modalScaleIn 0.3s ease-out;
    }
</style>

<script>
    (function() {
        var gambarInput = document.getElementById('berita-gambar-input');
        var gambarPreview = document.getElementById('berita-gambar-preview');
        var inlineInput = document.getElementById('berita-inline-input');
        var inlinePreview = document.getElementById('berita-inline-preview');
        var list = document.getElementById('inline-image-list');
        var orderContainer = document.getElementById('inline-image-order-inputs');
        
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

        if (!list || !orderContainer) return;

        // Custom delete confirmation modal
        function showDeleteModal(imageName, onConfirm, onCancel) {
            var modal = document.createElement('div');
            modal.id = 'delete-modal';
            modal.className = 'fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4';
            modal.innerHTML = `
                <div class="modal-content bg-white rounded-2xl shadow-2xl p-8 max-w-sm w-full text-center">
                    <div class="flex justify-center mb-4">
                        <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Konfirmasi Hapus</h3>
                    <p class="text-gray-600 mb-8">Yakin hapus <strong>${imageName}</strong>?</p>
                    <div class="flex gap-3">
                        <button type="button" class="flex-1 px-4 py-3 bg-gray-200 text-gray-700 rounded-lg font-semibold hover:bg-gray-300 transition" onclick="document.getElementById('delete-modal').remove(); let cb = window.deleteModalCallback; cb && cb(false);">Batal</button>
                        <button type="button" class="flex-1 px-4 py-3 bg-red-600 text-white rounded-lg font-semibold hover:bg-red-700 transition" onclick="document.getElementById('delete-modal').remove(); let cb = window.deleteModalCallback; cb && cb(true);">Ya, Hapus</button>
                    </div>
                </div>
            `;
            document.body.appendChild(modal);
            
            window.deleteModalCallback = function(confirmed) {
                if (confirmed) {
                    onConfirm();
                } else if (onCancel) {
                    onCancel();
                }
                window.deleteModalCallback = null;
            };
            
            // Close modal when clicking outside
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    modal.remove();
                    window.deleteModalCallback = null;
                }
            });
        }

        // Handle delete button clicks
        document.querySelectorAll('.delete-image-btn').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                var imageId = this.getAttribute('data-image-id');
                var imageName = this.getAttribute('data-image-name');
                var button = this;
                
                showDeleteModal(imageName, function() {
                    var card = button.closest('[data-inline-image-id]');
                    if (card) {
                        // Add hidden input to remove container
                        var removeContainer = document.getElementById('remove-inline-image-container');
                        var hiddenInput = document.createElement('input');
                        hiddenInput.type = 'hidden';
                        hiddenInput.name = 'remove_inline_image_ids[]';
                        hiddenInput.value = imageId;
                        removeContainer.appendChild(hiddenInput);
                        
                        // Also remove the order input for this image
                        var orderInputs = document.querySelectorAll('input[name="inline_image_order[]"]');
                        orderInputs.forEach(function(input) {
                            if (input.value == imageId) {
                                input.remove();
                            }
                        });
                        
                        // Animate and remove card
                        card.classList.add('animate-delete');
                        setTimeout(function() {
                            card.remove();
                            updateOrderInputs();
                        }, 300);
                    }
                });
            });
        });

        var dragged = null;

        var updateOrderInputs = function() {
            orderContainer.innerHTML = '';
            var cards = list.querySelectorAll('[data-inline-image-id]');

            cards.forEach(function(card) {
                var input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'inline_image_order[]';
                input.value = card.getAttribute('data-inline-image-id');
                orderContainer.appendChild(input);
            });
        };

        list.querySelectorAll('[data-inline-image-id]').forEach(function(card) {
            card.addEventListener('dragstart', function() {
                dragged = card;
                card.classList.add('opacity-60');
            });

            card.addEventListener('dragend', function() {
                card.classList.remove('opacity-60');
                dragged = null;
            });

            card.addEventListener('dragover', function(event) {
                event.preventDefault();
            });

            card.addEventListener('drop', function(event) {
                event.preventDefault();
                if (!dragged || dragged === card) return;

                var cards = Array.from(list.querySelectorAll('[data-inline-image-id]'));
                var draggedIndex = cards.indexOf(dragged);
                var targetIndex = cards.indexOf(card);

                if (draggedIndex < targetIndex) {
                    list.insertBefore(dragged, card.nextSibling);
                } else {
                    list.insertBefore(dragged, card);
                }

                updateOrderInputs();
            });

        });

        updateOrderInputs();
    })();
</script>
@endsection

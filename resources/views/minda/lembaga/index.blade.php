@extends('minda.layout')

@section('title', 'Kelola Lembaga')
@section('page-title', 'Kelola Lembaga')

@section('content')
@php
    $yph = $lembaga->first(fn($l) => (stripos($l->nama, 'Permata Hati') !== false && stripos($l->nama, 'Wakaf') === false) || $l->slug === 'yayasan-permata-hati');
    $lembagaLain = $yph ? $lembaga->filter(fn($l) => $l->id !== $yph->id)->values() : $lembaga;
@endphp
<div class="space-y-6">
    <div class="flex items-center justify-between flex-wrap gap-3">
        <div>
            <p class="text-gray-600">Kelola data lembaga yang tampil di halaman utama</p>
            <p class="text-xs text-gray-400 mt-1">Drag & drop untuk mengatur urutan. Yayasan Permata Hati selalu di atas (terkunci).</p>
        </div>
        <a href="{{ route('minda.lembaga.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg font-medium transition flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Lembaga
        </a>
    </div>

    {{-- Notifikasi simpan urutan --}}
    <div id="reorder-toast" class="hidden bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm font-medium transition-all">
        ✓ Urutan berhasil disimpan!
    </div>

    @if($lembaga->count() > 0)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-5 py-3 bg-gray-50 border-b border-gray-200 flex items-center gap-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                <span class="w-10 text-center">#</span>
                <span class="w-14"></span>
                <span class="flex-1">Nama Lembaga</span>
                <span class="w-20 text-center hidden sm:block">Status</span>
                <span class="w-36 text-right">Aksi</span>
            </div>

            {{-- YPH: Locked at top --}}
            @if($yph)
            <div class="flex items-center gap-3 px-5 py-4 border-b-2 border-yellow-200 bg-yellow-50/50 {{ !$yph->aktif ? 'opacity-50' : '' }}">
                <span class="w-10 flex items-center justify-center gap-1">
                    <svg class="w-4 h-4 text-yellow-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                    </svg>
                    <span class="inline-flex items-center justify-center w-6 h-6 rounded-full text-xs font-bold bg-yellow-100 text-yellow-700">★</span>
                </span>
                <div class="w-14 flex-shrink-0">
                    @php
                        $logoSrc = $yph->logo
                            ? (str_starts_with($yph->logo, 'images/') ? asset($yph->logo) : asset('storage/' . $yph->logo))
                            : null;
                    @endphp
                    @if($logoSrc)
                        <img src="{{ $logoSrc }}" alt="{{ $yph->nama }}" class="w-12 h-12 object-contain">
                    @else
                        <div class="w-12 h-12 rounded-full {{ $yph->warna_bg }} flex items-center justify-center text-white font-bold text-sm">
                            {{ $yph->singkatan }}
                        </div>
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <h3 class="font-bold text-gray-800 text-sm truncate">{{ $yph->nama }} <span class="text-yellow-600 text-xs font-normal">(Terkunci)</span></h3>
                    <p class="text-xs text-gray-400 truncate">{{ $yph->singkatan }} &bull; /lembaga/{{ $yph->slug }}</p>
                </div>
                <div class="w-20 text-center hidden sm:block">
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $yph->aktif ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">
                        {{ $yph->aktif ? 'Aktif' : 'Off' }}
                    </span>
                </div>
                <div class="w-36 flex items-center justify-end gap-2">
                    <a href="{{ route('minda.lembaga.edit', $yph->id) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Edit</a>
                </div>
            </div>
            @endif

            {{-- Sortable lembaga lainnya --}}
            <div id="sortable-lembaga">
                @foreach($lembagaLain as $index => $item)
                    <div class="sortable-item flex items-center gap-3 px-5 py-4 border-b border-gray-100 hover:bg-blue-50/30 transition cursor-grab active:cursor-grabbing {{ !$item->aktif ? 'opacity-50' : '' }}"
                         data-id="{{ $item->id }}">
                        <span class="w-10 flex items-center justify-center gap-1">
                            <svg class="w-4 h-4 text-gray-300 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M7 2a2 2 0 10.001 4.001A2 2 0 007 2zm0 6a2 2 0 10.001 4.001A2 2 0 007 8zm0 6a2 2 0 10.001 4.001A2 2 0 007 14zm6-8a2 2 0 10-.001-4.001A2 2 0 0013 6zm0 2a2 2 0 10.001 4.001A2 2 0 0013 8zm0 6a2 2 0 10.001 4.001A2 2 0 0013 14z"/>
                            </svg>
                            <span class="urutan-badge inline-flex items-center justify-center w-6 h-6 rounded-full text-xs font-bold bg-gray-100 text-gray-500">
                                {{ $index + 1 }}
                            </span>
                        </span>
                        <div class="w-14 flex-shrink-0">
                            @php
                                $logoSrc = $item->logo
                                    ? (str_starts_with($item->logo, 'images/') ? asset($item->logo) : asset('storage/' . $item->logo))
                                    : null;
                            @endphp
                            @if($logoSrc)
                                <img src="{{ $logoSrc }}" alt="{{ $item->nama }}" class="w-12 h-12 object-contain">
                            @else
                                <div class="w-12 h-12 rounded-full {{ $item->warna_bg }} flex items-center justify-center text-white font-bold text-sm">
                                    {{ $item->singkatan }}
                                </div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="font-bold text-gray-800 text-sm truncate">{{ $item->nama }}</h3>
                            <p class="text-xs text-gray-400 truncate">{{ $item->singkatan }} &bull; /lembaga/{{ $item->slug }}</p>
                        </div>
                        <div class="w-20 text-center hidden sm:block">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $item->aktif ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">
                                {{ $item->aktif ? 'Aktif' : 'Off' }}
                            </span>
                        </div>
                        <div class="w-36 flex items-center justify-end gap-2">
                            <a href="{{ route('minda.lembaga.edit', $item->id) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Edit</a>
                            <form action="{{ route('minda.lembaga.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin hapus lembaga {{ $item->nama }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">Hapus</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
            <p class="text-gray-500 mb-4">Belum ada lembaga</p>
            <a href="{{ route('minda.lembaga.create') }}" class="text-blue-600 hover:text-blue-800 font-medium">+ Tambah lembaga pertama</a>
        </div>
    @endif
</div>

{{-- SortableJS CDN --}}
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.6/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var el = document.getElementById('sortable-lembaga');
    if (!el) return;

    Sortable.create(el, {
        animation: 200,
        ghostClass: 'bg-blue-50',
        chosenClass: 'shadow-lg',
        dragClass: 'opacity-50',
        handle: '.sortable-item',
        onEnd: function() {
            var items = el.querySelectorAll('.sortable-item');
            var order = [];
            items.forEach(function(item, index) {
                order.push(item.dataset.id);
                var badge = item.querySelector('.urutan-badge');
                if (badge) {
                    badge.textContent = index + 1;
                }
            });

            fetch('{{ route("minda.lembaga.reorder") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ order: order })
            })
            .then(function(r) { return r.json(); })
            .then(function(data) {
                if (data.success) {
                    var toast = document.getElementById('reorder-toast');
                    toast.classList.remove('hidden');
                    setTimeout(function() { toast.classList.add('hidden'); }, 2000);
                }
            })
            .catch(function(err) {
                alert('Gagal menyimpan urutan. Coba refresh halaman.');
            });
        }
    });
});
</script>
@endsection

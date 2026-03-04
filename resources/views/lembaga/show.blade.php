@extends('layouts.app')

@section('content')
<!-- Banner Photo Section -->
<div class="relative w-full overflow-hidden">
    @php
        $bannerSrc = $lembaga->banner
            ? (str_starts_with($lembaga->banner, 'images/') ? asset($lembaga->banner) : asset('storage/' . $lembaga->banner))
            : null;
    @endphp
    @if($bannerSrc)
    <img src="{{ $bannerSrc }}" alt="{{ $lembaga->nama }}" class="w-full h-auto block">
    @else
    <img src="https://images.unsplash.com/photo-1427504494785-3a9ca7044f45?w=1200" alt="{{ $lembaga->nama }}" class="w-full h-auto block">
    @endif
    @if($lembaga->banner_judul || $lembaga->banner_subjudul || $lembaga->banner_kutipan)
    <div class="absolute inset-0 bg-black/30"></div>
    <div class="absolute inset-0 flex flex-col items-center justify-center text-white px-4">
        @if($lembaga->banner_subjudul)
        <p class="text-lg md:text-xl font-semibold mb-2 text-center" style="text-shadow: 1px 1px 4px rgba(0,0,0,0.5);">{{ $lembaga->banner_subjudul }}</p>
        @endif
        @if($lembaga->banner_judul)
        <h1 class="text-3xl md:text-5xl font-bold text-center leading-tight" style="text-shadow: 2px 2px 6px rgba(0,0,0,0.5);">{!! nl2br(e($lembaga->banner_judul)) !!}</h1>
        @endif
        @if($lembaga->banner_kutipan)
        <p class="mt-6 text-sm md:text-base text-center max-w-2xl opacity-90" style="text-shadow: 1px 1px 4px rgba(0,0,0,0.5);">{{ $lembaga->banner_kutipan }}</p>
        @endif
    </div>
    @endif
</div>

<!-- Hero Section - Light background with logo watermark -->
<div class="relative w-full bg-gray-100 overflow-hidden">
    <!-- Logo Watermark Background -->
    @php
        $logoSrc = $lembaga->logo
            ? (str_starts_with($lembaga->logo, 'images/') ? asset($lembaga->logo) : asset('storage/' . $lembaga->logo))
            : null;
    @endphp
    @if($logoSrc)
    <div class="absolute -left-80 top-1/2 -translate-y-1/2 w-[1100px] h-[1100px] opacity-10 pointer-events-none hidden md:block">
        <img src="{{ $logoSrc }}" alt="" class="w-full h-full object-contain">
    </div>
    @endif

    <div class="max-w-6xl mx-auto px-4 py-12 md:py-16 relative z-10">
        <div class="flex flex-col md:flex-row items-center gap-8 md:gap-12">
            <!-- Logo - Large on the left -->
            <div class="flex-shrink-0 relative animate-on-scroll animate-from-left">
                @if($logoSrc)
                <div class="w-56 h-56 md:w-96 md:h-96 flex items-center justify-center md:-ml-36" aria-hidden="true">
                    <img src="{{ $logoSrc }}" alt="{{ $lembaga->nama }}" class="w-52 h-52 md:w-[450px] md:h-[450px] object-contain drop-shadow-2xl">
                </div>
                @else
                <div class="w-48 h-48 md:w-64 md:h-64 {{ $lembaga->warna_bg }} rounded-full flex items-center justify-center shadow-2xl">
                    <span class="text-5xl md:text-7xl font-bold text-white">{{ $lembaga->singkatan }}</span>
                </div>
                @endif
            </div>

            <!-- Title and Description -->
            <div class="flex-1 animate-on-scroll animate-from-right">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-6">{{ $lembaga->nama }}</h1>
                <div class="text-gray-600 leading-relaxed text-justify space-y-4 text-sm md:text-base">
                    <p>{{ $lembaga->deskripsi }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Visi Misi Section - With background pattern -->
<div class="bg-white py-16 md:py-20">
    <div class="max-w-5xl mx-auto px-4 sm:px-8">
        <div class="relative rounded-[2rem] overflow-hidden shadow-xl animate-on-scroll animate-scale" style="background-image: url('{{ asset('images/background-perlembaga.png') }}'); background-size: cover; background-position: center;">
            {{-- Semi-transparent overlay for readability --}}
            <div class="absolute inset-0 bg-white/30"></div>
            
            <div class="relative z-10 grid grid-cols-1 md:grid-cols-2 py-10 md:py-14 px-8 md:px-12">
                <!-- VISI -->
                <div class="pr-0 md:pr-10">
                    <h3 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4 text-center">VISI</h3>
                    <p class="text-gray-700 leading-relaxed text-sm md:text-base text-center">
                        {{ $lembaga->visi }}
                    </p>
                </div>

                <!-- Vertical Divider (desktop) -->
                <div class="hidden md:block absolute left-1/2 top-8 bottom-8 w-px bg-gray-400/60"></div>
                <!-- Horizontal Divider (mobile) -->
                <div class="block md:hidden my-6 h-px bg-gray-400/60"></div>

                <!-- MISI -->
                <div class="pl-0 md:pl-10">
                    <h3 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4 text-center">MISI</h3>
                    <ul class="space-y-2.5">
                        @foreach($lembaga->misi as $item)
                        <li class="flex items-start gap-3">
                            <span class="inline-block w-1.5 h-1.5 bg-gray-800 rounded-full mt-2 flex-shrink-0"></span>
                            <span class="text-gray-700 leading-relaxed text-sm md:text-base">{{ $item }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Berita Terbaru Section -->
@if($beritaTerbaru->count())
<div class="bg-white py-10 md:py-16">
    <div class="max-w-6xl mx-auto px-4">
        <h2 class="text-2xl md:text-4xl font-bold text-center text-gray-800 mb-3">BERITA {{ strtoupper($lembaga->nama) }}</h2>
        <p class="text-center text-gray-500 mb-8 md:mb-12 text-sm md:text-base">Temukan kabar terkini mengenai aktivitas, agenda, dan pencapaian {{ $lembaga->nama }}.</p>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-10 items-start">
            <!-- Kategori Sidebar -->
            <div class="lg:col-span-1 order-2 lg:order-1">
                <h3 class="font-bold text-black text-xl mb-4 pb-2 border-b-2 border-gray-300">Kategori Berita</h3>
                <ul class="space-y-2 text-gray-700 text-base">
                    @foreach($kategoriList as $kat)
                        <li><a href="{{ route('berita.index', ['kategori' => $kat]) }}" class="block py-1 hover:underline">{{ $kat }}</a></li>
                    @endforeach
                </ul>
            </div>

            <!-- Berita Grid 2x2 -->
            <div class="lg:col-span-2 order-1 lg:order-2" style="display: grid; grid-template-columns: repeat(1, 1fr); gap: 1rem;">
                <style>
                    @media (min-width: 640px) {
                        .berita-lembaga-grid { grid-template-columns: repeat(2, 1fr) !important; }
                    }
                </style>
                <script>document.currentScript.previousElementSibling.parentElement.classList.add('berita-lembaga-grid');</script>
                @php $homeNewsImages = ['news1.png','news2.png','news3.png','news4.png','news5.png','news6.png','news7.jpeg']; @endphp
                @foreach($beritaTerbaru->take(3) as $brt)
                    <a href="{{ route('berita.show', $brt->slug) }}" class="relative overflow-hidden rounded-2xl bg-gray-100 group" style="aspect-ratio: 4/3; box-shadow: 0 2px 14px rgba(0,0,0,0.08);">
                        @if($brt->gambar)
                        <img src="{{ asset('storage/' . $brt->gambar) }}" alt="{{ $brt->judul }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" />
                        @else
                        <img src="{{ asset('images/' . $homeNewsImages[$loop->index % count($homeNewsImages)]) }}" alt="{{ $brt->judul }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" />
                        @endif
                        <div class="absolute inset-0 bg-black/40"></div>
                        <div class="absolute left-0 bottom-0 p-4">
                            <h4 class="font-bold text-white uppercase text-base md:text-lg mb-1" style="text-shadow: 0 1px 2px rgba(0,0,0,0.7);">{{ $brt->judul }}</h4>
                            <p class="text-white text-sm flex items-center gap-1.5" style="text-shadow: 0 1px 2px rgba(0,0,0,0.7);">
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                {{ ($brt->tanggal ?? $brt->created_at)->format('j F Y') }}
                            </p>
                        </div>
                    </a>
                @endforeach
                <a href="{{ route('berita.index', ['lembaga' => $lembaga->id]) }}" class="flex flex-col items-center justify-center rounded-2xl text-white font-medium text-center p-6 transition hover:opacity-90 hover:shadow-xl duration-300 group" style="aspect-ratio: 4/3; background-color: #8280af; box-shadow: 0 2px 14px rgba(0,0,0,0.08);">
                    <span class="block text-2xl font-bold leading-snug group-hover:scale-105 transition-transform">Tampilkan</span>
                    <span class="block text-2xl font-bold leading-snug group-hover:scale-105 transition-transform">semua berita</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Footer -->
<footer class="bg-gray-900 text-white py-16">
    <div class="container mx-auto px-4">
        <div class="grid md:grid-cols-3 gap-12">
            <!-- Tentang / Footer Lembaga -->
            <div>
                <h3 class="text-2xl font-bold mb-6">TENTANG</h3>
                @if($lembaga->footer)
                    <p class="text-gray-400 leading-relaxed">{!! nl2br(e($lembaga->footer)) !!}</p>
                @elseif($lembaga->deskripsi)
                    <p class="text-gray-400 leading-relaxed">{{ Str::limit(strip_tags($lembaga->deskripsi), 300) }}</p>
                @else
                    <p class="text-gray-400 leading-relaxed italic">Belum ada deskripsi.</p>
                @endif
            </div>

            <!-- Lembaga -->
            <div>
                <h3 class="text-2xl font-bold mb-6">LEMBAGA</h3>
                <ul class="space-y-3">
                    @foreach($semuaLembaga as $lmb)
                    <li><a href="/lembaga/{{ $lmb->slug }}" class="text-gray-400 hover:text-white transition {{ $lmb->id === $lembaga->id ? 'text-white font-semibold' : '' }}">&bull; {{ $lmb->nama }}</a></li>
                    @endforeach
                </ul>
            </div>

            <!-- Kontak Kami -->
            <div>
                <h3 class="text-2xl font-bold mb-6">KONTAK KAMI</h3>
                <div class="space-y-4">
                    @if($lembaga->footer_telepon)
                    <div class="flex justify-between">
                        <span class="text-gray-500 text-sm">Telepon</span>
                        <span class="text-gray-400">{{ $lembaga->footer_telepon }}</span>
                    </div>
                    @elseif($kontak && $kontak->telepon)
                    <div class="flex justify-between">
                        <span class="text-gray-500 text-sm">Telepon</span>
                        <span class="text-gray-400">{{ $kontak->telepon }}</span>
                    </div>
                    @endif

                    @if($lembaga->footer_email)
                    <div class="flex justify-between">
                        <span class="text-gray-500 text-sm">Email</span>
                        <span class="text-gray-400">{{ $lembaga->footer_email }}</span>
                    </div>
                    @elseif($kontak && $kontak->email)
                    <div class="flex justify-between">
                        <span class="text-gray-500 text-sm">Email</span>
                        <span class="text-gray-400">{{ $kontak->email }}</span>
                    </div>
                    @endif

                    <div class="flex gap-4 mt-6">
                        @if($lembaga->facebook)
                        <a href="{{ $lembaga->facebook }}" target="_blank" class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center hover:bg-blue-700 transition">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        @endif
                        @if($lembaga->instagram)
                        <a href="{{ $lembaga->instagram }}" target="_blank" class="w-12 h-12 bg-pink-600 rounded-full flex items-center justify-center hover:bg-pink-700 transition">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                        @endif
                        @if($lembaga->youtube)
                        <a href="{{ $lembaga->youtube }}" target="_blank" class="w-12 h-12 bg-red-600 rounded-full flex items-center justify-center hover:bg-red-700 transition">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                        </a>
                        @endif
                        @if($lembaga->tiktok)
                        <a href="{{ $lembaga->tiktok }}" target="_blank" class="w-12 h-12 bg-gray-800 rounded-full flex items-center justify-center hover:bg-gray-700 transition">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61.04 3.93.245 3.17.36 5.3 1.845 6.08 4.975.72 2.89.72 8.94.72 8.94s0 5.87-.72 8.76c-.78 3.13-2.91 4.61-6.08 4.97-3.18.36-6.36.36-9.53 0-3.17-.36-5.3-1.84-6.08-4.97C.12 19.81.12 13.76.12 13.76s0-6.05.72-8.94C1.62 1.69 3.75.205 6.92-.155c1.32-.205 2.62-.285 3.93-.265h1.68zm-1.9 7.07v13.4l8.97-6.7-8.97-6.7z"/></svg>
                        </a>
                        @endif
                        @if($lembaga->website)
                        <a href="{{ $lembaga->website }}" target="_blank" class="w-12 h-12 bg-green-600 rounded-full flex items-center justify-center hover:bg-green-700 transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
                        </a>
                        @endif
                        @if(!$lembaga->facebook && !$lembaga->instagram && !$lembaga->youtube && !$lembaga->tiktok && !$lembaga->website)
                        <p class="text-gray-500 text-sm italic">Belum ada sosial media</p>
                        @endif
                    </div>
                    <div class="mt-6">
                        @if($lembaga->footer_alamat)
                        <p class="text-gray-500 text-sm mb-2 font-semibold">Alamat</p>
                        <p class="text-gray-400">{!! nl2br(e($lembaga->footer_alamat)) !!}</p>
                        @elseif($kontak && $kontak->alamat)
                        <p class="text-gray-500 text-sm mb-2 font-semibold">Alamat</p>
                        <p class="text-gray-400">{!! nl2br(e($kontak->alamat)) !!}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
@endsection

@extends('layouts.app')

@section('content')
<!-- Banner Section - Full width photo with overlay title -->
<div class="relative w-full h-[280px] md:h-[480px] overflow-hidden">
    @if($berita->gambar)
    <img src="{{ asset('storage/' . $berita->gambar) }}" 
         alt="{{ $berita->judul }}" 
         class="w-full h-full object-cover">
    @else
    <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=1200" 
         alt="{{ $berita->judul }}" 
         class="w-full h-full object-cover">
    @endif
    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>
    <div class="absolute bottom-0 left-0 right-0 p-5 md:p-12">
        <div class="max-w-6xl mx-auto">
            <h1 class="text-xl md:text-4xl font-bold text-white leading-tight mb-3 md:mb-4" style="text-shadow: 1px 1px 4px rgba(0,0,0,0.5);">{{ $berita->judul }}</h1>
            <div class="flex items-center gap-2 text-white/80 text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <span>{{ ($berita->tanggal ?? $berita->created_at)->format('j F Y') }}</span>
            </div>
        </div>
    </div>
</div>

<!-- Kategori & Dipublikasikan Row -->
<div class="bg-white border-b border-gray-200">
    <div class="max-w-6xl mx-auto px-4 py-6">
        <div class="flex flex-wrap gap-12">
            <div>
                <h4 class="text-sm font-bold text-gray-800 mb-1">Kategori Berita</h4>
                <p class="text-gray-500 text-sm">{{ $berita->kategori ?? 'Informasi umum' }}</p>
            </div>
            <div>
                <h4 class="text-sm font-bold text-gray-800 mb-1">Dipublikasikan</h4>
                <div class="flex items-center gap-2 text-gray-500 text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span>{{ ($berita->tanggal ?? $berita->created_at)->format('j F Y') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="bg-white pb-20 pt-10">
    <div class="max-w-6xl mx-auto px-4">
        <div class="flex flex-col lg:flex-row gap-10">
            
            <!-- Left Column - Article Content -->
            <div class="flex-1">
                <div class="mb-12">
                    <!-- Full Content -->
                    <div class="text-gray-700 leading-relaxed text-justify space-y-6 text-[15px]">
                        {!! nl2br(e($berita->konten)) !!}
                    </div>

                    <!-- Back Link -->
                    <div class="mt-10">
                        <a href="{{ route('berita.index') }}" class="text-red-500 hover:text-red-600 font-semibold text-sm inline-flex items-center gap-1 transition">
                            <span class="text-lg">←</span> Kembali ke semua berita
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right Column - Sidebar -->
            <div class="lg:w-80 flex-shrink-0">
                
                <!-- Kategori Berita Card -->
                <div class="rounded-2xl overflow-hidden shadow-lg mb-10 relative">
                    <!-- Chevron pattern background -->
                    <div class="absolute inset-0 opacity-5">
                        <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                            <defs>
                                <pattern id="chevrons" x="0" y="0" width="40" height="40" patternUnits="userSpaceOnUse">
                                    <path d="M0 20 L20 0 L40 20" fill="none" stroke="#000" stroke-width="1"/>
                                    <path d="M0 40 L20 20 L40 40" fill="none" stroke="#000" stroke-width="1"/>
                                </pattern>
                            </defs>
                            <rect width="100%" height="100%" fill="url(#chevrons)"/>
                        </svg>
                    </div>
                    
                    <div class="relative z-10 p-8">
                        <h3 class="text-2xl font-bold text-gray-800 mb-6">Kategori Berita</h3>
                        
                        <ul class="space-y-4">
                            @foreach($kategoriList as $kategori)
                            <li>
                                <a href="{{ route('berita.index', ['kategori' => $kategori]) }}" 
                                   class="text-gray-600 hover:text-gray-900 transition text-sm block py-1">
                                    {{ $kategori }}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Informasi Terbaru -->
                <div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-6">Informasi Terbaru</h3>
                    
                    <div class="space-y-5">
                        @forelse($beritaTerbaru as $terbaru)
                        <a href="{{ route('berita.show', $terbaru->slug) }}" class="flex items-start gap-4 group">
                            <div class="w-24 h-16 flex-shrink-0 rounded-lg overflow-hidden">
                                @if($terbaru->gambar)
                                <img src="{{ asset('storage/' . $terbaru->gambar) }}" 
                                     alt="{{ $terbaru->judul }}" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                @else
                                <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=200" 
                                     alt="{{ $terbaru->judul }}" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                @endif
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-gray-700 font-semibold leading-snug group-hover:text-gray-900 transition line-clamp-3">
                                    {{ $terbaru->judul }}
                                </p>
                            </div>
                        </a>
                        @empty
                        @for($i = 0; $i < 5; $i++)
                        <div class="flex items-start gap-4">
                            <div class="w-24 h-16 flex-shrink-0 rounded-lg overflow-hidden">
                                <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=200" 
                                     alt="Berita" 
                                     class="w-full h-full object-cover">
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-gray-700 font-semibold leading-snug">
                                    Komite SDIT Harapan Bunda Purwokerto Gelar Bakti Sosial
                                </p>
                            </div>
                        </div>
                        @endfor
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="bg-gray-900 text-white py-16">
    <div class="container mx-auto px-4">
        <div class="grid md:grid-cols-3 gap-12">
            <!-- Tentang -->
            <div>
                <h3 class="text-2xl font-bold mb-6">TENTANG</h3>
                <p class="text-gray-400 leading-relaxed">
                    Yayasan Permata Hati Purwokerto awalnya bernama Yayasan Permata Hati yang didirikan pada tanggal 9 Agustus 1997. Sejak berdirinya, Yayasan Permata Hati memiliki kepedulian dalam bidang pendidikan dan sosial kemasyarakatan.
                </p>
            </div>

            <!-- Lembaga -->
            <div>
                <h3 class="text-2xl font-bold mb-6">LEMBAGA</h3>
                <ul class="space-y-3">
                    <li><a href="/lembaga/yayasan-permata-hati" class="text-gray-400 hover:text-white transition">• Yayasan Permata Hati</a></li>
                    <li><a href="/lembaga/lpit-harapan-bunda" class="text-gray-400 hover:text-white transition">• LPIT Harapan Bunda</a></li>
                    <li><a href="/lembaga/sukses-multi-sarana" class="text-gray-400 hover:text-white transition">• Sukses Multi Sarana</a></li>
                    <li><a href="/lembaga/tpa-baby-class-harapan-bunda" class="text-gray-400 hover:text-white transition">• TPA Baby Class Harapan Bunda</a></li>
                    <li><a href="/lembaga/kb-harapan-bunda" class="text-gray-400 hover:text-white transition">• KB Harapan Bunda</a></li>
                    <li><a href="/lembaga/tk-it-harapan-bunda" class="text-gray-400 hover:text-white transition">• TK IT Harapan Bunda</a></li>
                    <li><a href="/lembaga/sd-it-harapan-bunda-01" class="text-gray-400 hover:text-white transition">• SD IT Harapan Bunda 01</a></li>
                    <li><a href="/lembaga/sd-it-harapan-bunda-02" class="text-gray-400 hover:text-white transition">• SD IT Harapan Bunda 02</a></li>
                    <li><a href="/lembaga/smp-it-harapan-bunda" class="text-gray-400 hover:text-white transition">• SMP IT Harapan Bunda</a></li>
                    <li><a href="/lembaga/lembaga-wakaf-permata-hati-purwokerto" class="text-gray-400 hover:text-white transition">• Lembaga Wakaf Permata Hati Purwokerto</a></li>
                </ul>
            </div>

            <!-- Kontak Kami -->
            <div>
                <h3 class="text-2xl font-bold mb-6">KONTAK KAMI</h3>
                <div class="space-y-4">
                    <div class="flex justify-between">
                        <span class="text-gray-500 text-sm">Telepon</span>
                        <span class="text-gray-400">0281623868</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500 text-sm">Email</span>
                        <span class="text-gray-400">lpitharbunpurwokerto@gmail.com</span>
                    </div>
                    <div class="flex gap-4 mt-6">
                        <a href="#" class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center hover:bg-blue-700 transition">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        <a href="#" class="w-12 h-12 bg-pink-600 rounded-full flex items-center justify-center hover:bg-pink-700 transition">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                        <a href="#" class="w-12 h-12 bg-red-600 rounded-full flex items-center justify-center hover:bg-red-700 transition">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                        </a>
                    </div>
                    <div class="mt-6">
                        <p class="text-gray-500 text-sm mb-2 font-semibold">Alamat</p>
                        <p class="text-gray-400">Jl. KH. Wahid Hasyim Gang Pesantren, RT.04/RW.01, Windusara, Karanglesesm, Kec. Purwokerto Sel., Kabupaten Banyumas, Jawa Tengah 53144</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
@endsection

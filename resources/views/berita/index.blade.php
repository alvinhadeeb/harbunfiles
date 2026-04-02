@extends('layouts.app')

@section('content')
<!-- Title Section -->
<div class="bg-white pt-10 pb-6">
    <div class="max-w-6xl mx-auto px-4 text-center">
        <h1 class="text-3xl md:text-4xl font-bold text-gray-800">
            @if(isset($lembagaFilter) && $lembagaFilter)
                Berita {{ $lembagaFilter->nama }}
            @else
                Berita Terbaru
            @endif
        </h1>
        @if(isset($lembagaFilter) && $lembagaFilter)
        <a href="{{ route('berita.index') }}" class="inline-block mt-3 text-sm text-indigo-600 hover:underline">&larr; Lihat semua berita</a>
        @endif
    </div>
</div>

<!-- Main Content -->
<div class="bg-white pb-20">
    <div class="max-w-6xl mx-auto px-4">
        <div class="flex flex-col lg:flex-row gap-8">
            
            <!-- Left Column - Berita List -->
            <div class="flex-1 order-1 min-w-0">
                <div class="space-y-10">
                    @forelse($berita as $item)
                    <article>
                        {{-- Image --}}
                        @php $newsImages = ['news1.png','news2.png','news3.png','news4.png','news5.png','news6.png','news7.jpeg']; @endphp
                        <a href="{{ route('berita.show', $item->slug) }}" class="block overflow-hidden rounded-2xl mb-4">
                            @if($item->gambar)
                            <img src="{{ asset('storage/' . $item->gambar) }}" 
                                 alt="{{ $item->judul }}" 
                                 class="w-full h-56 md:h-72 object-cover hover:scale-105 transition-transform duration-500">
                            @else
                            <img src="{{ asset('images/' . $newsImages[$loop->index % count($newsImages)]) }}" 
                                 alt="{{ $item->judul }}" 
                                 class="w-full h-56 md:h-72 object-cover hover:scale-105 transition-transform duration-500">
                            @endif
                        </a>
                        {{-- Title --}}
                        <h2 class="text-lg md:text-xl font-bold text-gray-900 mb-2 leading-snug break-words">
                            <a href="{{ route('berita.show', $item->slug) }}" class="hover:text-[#6E7098] transition">
                                {{ $item->judul }}
                            </a>
                        </h2>
                        {{-- Meta --}}
                        <p class="text-gray-400 text-xs mb-3">
                            {{ ($item->tanggal ?? $item->created_at)->format('j F Y') }} | Pengunggah: {{ $item->admin?->name ?? 'Editor Website' }}
                        </p>
                        {{-- Excerpt --}}
                        <p class="text-gray-600 text-sm leading-relaxed text-justify mb-3 break-words">
                            {{ Str::limit(strip_tags($item->konten), 250) }}
                        </p>
                        {{-- Read More --}}
                        <a href="{{ route('berita.show', $item->slug) }}" class="text-orange-500 hover:text-orange-600 text-sm font-semibold inline-flex items-center gap-1 transition">
                            Read More →
                        </a>
                    </article>
                    @empty
                    <div class="text-center py-20 text-gray-400">
                        <p class="text-lg">Belum ada berita.</p>
                    </div>
                    @endforelse

                    {{-- Pagination --}}
                    @if($berita->hasPages())
                    <div class="pt-8 pb-4">
                        {{ $berita->links('vendor.pagination.custom') }}
                    </div>
                    @endif
                </div>
            </div>

            <!-- Right Column - Sidebar -->
            <div class="lg:w-72 flex-shrink-0 order-2 space-y-8">

                {{-- Kategori Berita Card --}}
                <div class="relative rounded-2xl overflow-hidden p-6" style="background-image: url('{{ asset('images/background-perlembaga.png') }}'); background-size: cover; background-position: center;">
                    <div class="absolute inset-0 bg-white/40"></div>
                    <div class="relative z-10">
                        <h3 class="text-2xl font-bold text-gray-800 mb-5">Kategori Berita</h3>
                        <ul class="space-y-3">
                            @foreach($kategoriList as $kategori)
                            <li>
                                <a href="{{ route('berita.index', ['kategori' => $kategori]) }}" 
                                   class="text-gray-700 hover:text-gray-900 transition text-sm block {{ request('kategori') == $kategori ? 'font-bold text-gray-900' : '' }}">
                                    {{ $kategori }}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                {{-- Informasi Terbaru --}}
                <div class="relative rounded-2xl overflow-hidden p-6" style="background-image: url('{{ asset('images/background-perlembaga.png') }}'); background-size: cover; background-position: center;">
                    <div class="absolute inset-0 bg-white/40"></div>
                    <div class="relative z-10">
                        <h3 class="text-2xl font-bold text-gray-800 mb-5">Informasi Terbaru</h3>
                        <div class="space-y-4">
                            @php $sidebarImages = ['news1.png','news2.png','news3.png','news4.png','news5.png','news6.png','news7.jpeg']; @endphp
                            @foreach($beritaTerbaru as $terbaru)
                            <a href="{{ route('berita.show', $terbaru->slug) }}" class="flex items-center gap-3 group">
                                <div class="w-20 h-16 flex-shrink-0 rounded-lg overflow-hidden bg-gray-200">
                                    @if($terbaru->gambar)
                                    <img src="{{ asset('storage/' . $terbaru->gambar) }}" alt="{{ $terbaru->judul }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                    @else
                                    <img src="{{ asset('images/' . $sidebarImages[$loop->index % count($sidebarImages)]) }}" alt="" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                    @endif
                                </div>
                                <p class="text-gray-700 text-xs font-semibold leading-snug group-hover:text-[#6E7098] transition flex-1">
                                    {{ Str::limit($terbaru->judul, 60) }}
                                </p>
                            </a>
                            @endforeach
                        </div>
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
                    <li><a href="/lembaga/yayasan-permata-hati" class="text-gray-400 hover:text-white transition">&bull; Yayasan Permata Hati</a></li>
                    <li><a href="/lembaga/lpit-harapan-bunda" class="text-gray-400 hover:text-white transition">&bull; LPIT Harapan Bunda</a></li>
                    <li><a href="/lembaga/sukses-multi-sarana" class="text-gray-400 hover:text-white transition">&bull; Sukses Multi Sarana</a></li>
                    <li><a href="/lembaga/tpa-baby-class-harapan-bunda" class="text-gray-400 hover:text-white transition">&bull; TPA Baby Class Harapan Bunda</a></li>
                    <li><a href="/lembaga/kb-harapan-bunda" class="text-gray-400 hover:text-white transition">&bull; KB Harapan Bunda</a></li>
                    <li><a href="/lembaga/tk-it-harapan-bunda" class="text-gray-400 hover:text-white transition">&bull; TK IT Harapan Bunda</a></li>
                    <li><a href="/lembaga/sd-it-harapan-bunda-01" class="text-gray-400 hover:text-white transition">&bull; SD IT Harapan Bunda 01</a></li>
                    <li><a href="/lembaga/sd-it-harapan-bunda-02" class="text-gray-400 hover:text-white transition">&bull; SD IT Harapan Bunda 02</a></li>
                    <li><a href="/lembaga/smp-it-harapan-bunda" class="text-gray-400 hover:text-white transition">&bull; SMP IT Harapan Bunda</a></li>
                    <li><a href="/lembaga/lembaga-wakaf-permata-hati-purwokerto" class="text-gray-400 hover:text-white transition">&bull; Lembaga Wakaf Permata Hati Purwokerto</a></li>
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

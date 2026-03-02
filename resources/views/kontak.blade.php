@extends('layouts.app')

@section('content')
<!-- Hero Banner -->
<div class="relative w-full h-52 md:h-80 bg-gradient-to-r from-gray-400 to-gray-500 overflow-hidden">
    <div class="absolute inset-0 opacity-10" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cpath d=\'M30 0L60 30L30 60L0 30Z\' fill=\'%23000\' fill-rule=\'evenodd\'/%3E%3C/svg%3E');"></div>
    <div class="absolute inset-0 flex flex-col items-center justify-center text-white">
        <h1 class="text-3xl md:text-5xl font-bold mb-4">HUBUNGI KAMI</h1>
        <p class="text-sm md:text-lg text-center max-w-2xl px-4">Punya Pertanyaan? Jangan ragu untuk menghubungi kami melalui formulir di bawah ini atau datangi ke Yayasan Kami</p>
    </div>
</div>

<!-- Main Content -->
<div class="container mx-auto px-4 py-10 md:py-16">
    <div class="max-w-6xl mx-auto">
        <!-- Section Title -->
        <div class="mb-8 md:mb-12">
            <h2 class="text-2xl md:text-4xl font-bold text-gray-800 mb-2">INFORMASI LEMBAGA</h2>
            <div class="w-32 h-1 bg-blue-600"></div>
            <p class="text-sm text-blue-600 font-semibold mt-2">INFORMASI KONTAK</p>
        </div>

        <!-- Lembaga List -->
        <div class="space-y-6">
            @foreach($lembagaList as $lembaga)
            @php
                $isClickable = !empty($lembaga['linktree']);
                $cardClasses = "bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 p-4 md:p-6 flex flex-col sm:flex-row items-start gap-4 md:gap-6 animate-on-scroll hover-lift";
                if ($isClickable) {
                    $cardClasses .= " cursor-pointer hover:scale-[1.02]";
                }
            @endphp
            @if($isClickable)
            <a href="{{ $lembaga['linktree'] }}" target="_blank" class="{{ $cardClasses }}" rel="noopener noreferrer">
            @else
            <div class="{{ $cardClasses }}">
            @endif
                <!-- Logo -->
                <div class="flex-shrink-0">
                    @if(isset($lembaga['logo']) && file_exists(public_path(ltrim($lembaga['logo'], '/'))))
                    <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center shadow-lg border-2 border-gray-100 overflow-hidden">
                        <img src="{{ asset(ltrim($lembaga['logo'], '/')) }}" alt="{{ $lembaga['name'] }}" class="w-16 h-16 object-contain">
                    </div>
                    @else
                    <div class="w-20 h-20 {{ $lembaga['icon_color'] }} rounded-full flex items-center justify-center">
                        <!-- You can replace this with actual logo image -->
                        <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                        </svg>
                    </div>
                    @endif
                </div>

                <!-- Info -->
                <div class="flex-1">
                    <div class="flex items-start justify-between">
                        <h3 class="text-xl font-bold text-gray-800 mb-3">{{ $lembaga['name'] }}</h3>
                        @if($isClickable)
                        <svg class="w-6 h-6 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                        @endif
                    </div>
                    <div class="space-y-2">
                        <p class="text-gray-600 text-sm leading-relaxed">
                            <span class="font-medium">Alamat:</span> {{ $lembaga['address'] }}
                        </p>
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                            </svg>
                            <span class="text-gray-700 font-medium">{{ $lembaga['phone'] }}</span>
                        </div>
                        @if($isClickable)
                        <div class="mt-3">
                            <span class="inline-flex items-center gap-1 text-sm text-green-600 font-semibold">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                                Klik untuk info lebih lanjut
                            </span>
                        </div>
                        @endif
                    </div>
                </div>
            @if($isClickable)
            </a>
            @else
            </div>
            @endif
            @endforeach
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="bg-gray-900 text-white py-16 border-t border-gray-800">
    <div class="container mx-auto px-4">
        <div class="grid md:grid-cols-3 gap-12">
            <!-- Tentang -->
            <div>
                <h3 class="text-2xl font-bold mb-6">TENTANG</h3>
                <p class="text-gray-400 leading-relaxed mb-4">
                    Yayasan Permata Hati Purwokerto Awalnya Bernama Yayasan Permata Hati yang didirikan pada tanggal 9 Agustus 1997. Sejak tahun 2000, Yayasan Permata Hati mampu mengelola SDLB, SLTP LB, dan SMU LB sebagai kompensasi atas tidak adanya sekolah pendidikan khusus negeri pada masa itu.
                </p>
            </div>

            <!-- Lembaga -->
            <div>
                <h3 class="text-2xl font-bold mb-6">LEMBAGA</h3>
                <ul class="space-y-3">
                    <li><a href="{{ route('lembaga.show', 'yayasan-permata-hati') }}" class="text-gray-400 hover:text-white transition">&bull; Yayasan Permata Hati</a></li>
                    <li><a href="{{ route('lembaga.show', 'lpit-harapan-bunda') }}" class="text-gray-400 hover:text-white transition">&bull; LPIT Harapan Bunda</a></li>
                    <li><a href="{{ route('lembaga.show', 'sukses-multi-sarana') }}" class="text-gray-400 hover:text-white transition">&bull; Sukses Multi Sarana</a></li>
                    <li><a href="{{ route('lembaga.show', 'tpa-baby-class-harapan-bunda') }}" class="text-gray-400 hover:text-white transition">&bull; TPA Baby Class Harapan Bunda</a></li>
                    <li><a href="{{ route('lembaga.show', 'kb-harapan-bunda') }}" class="text-gray-400 hover:text-white transition">&bull; KB Harapan Bunda</a></li>
                    <li><a href="{{ route('lembaga.show', 'tk-it-harapan-bunda') }}" class="text-gray-400 hover:text-white transition">&bull; TK IT Harapan Bunda</a></li>
                    <li><a href="{{ route('lembaga.show', 'sd-it-harapan-bunda-01') }}" class="text-gray-400 hover:text-white transition">&bull; SD IT Harapan Bunda 01</a></li>
                    <li><a href="{{ route('lembaga.show', 'sd-it-harapan-bunda-02') }}" class="text-gray-400 hover:text-white transition">&bull; SD IT Harapan Bunda 02</a></li>
                    <li><a href="{{ route('lembaga.show', 'smp-it-harapan-bunda') }}" class="text-gray-400 hover:text-white transition">&bull; SMP IT Harapan Bunda</a></li>
                    <li><a href="{{ route('lembaga.show', 'lembaga-wakaf-permata-hati-purwokerto') }}" class="text-gray-400 hover:text-white transition">&bull; Lembaga Wakaf Permata Hati Purwokerto</a></li>
                </ul>
            </div>

            <!-- Kontak Kami -->
            <div>
                <h3 class="text-2xl font-bold mb-6">KONTAK KAMI</h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-gray-500 text-sm">Telepon</p>
                        <p class="text-gray-400">0281523668</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Email</p>
                        <p class="text-gray-400">admin@lpiharapanbunda@gmail.com</p>
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
                        <p class="text-gray-500 text-sm mb-2">Alamat</p>
                        <p class="text-gray-400">Jl. KH. Wahid Hasyim Gang Pesantren RT.04/RW.01 Windusara, Kecamatan Kec. Purwokerto Sel., Kabupaten Banyumas, Jawa Tengah 53144</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
@endsection

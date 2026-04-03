@extends('layouts.app')

@section('title', 'Harapan Bunda Purwokerto - Beranda')

@php
    $homeOgImage = $bannerList->count() > 0
        ? (str_starts_with($bannerList->first()->gambar, 'images/') ? asset($bannerList->first()->gambar) : asset('storage/' . $bannerList->first()->gambar))
        : asset('images/logo-hb.png');
@endphp

@section('meta_title', 'Harapan Bunda Purwokerto')
@section('meta_description', 'Website resmi Harapan Bunda Purwokerto.')
@section('meta_url', url('/'))
@section('meta_type', 'website')
@section('meta_image', $homeOgImage)

@section('content')
    {{-- Hero: full-width banner + carousel dots --}}
    <section class="relative w-full overflow-hidden" id="hero-section">
        <div class="relative w-full aspect-[16/9] md:aspect-[21/9] min-h-[200px] bg-gray-200">
            @if($bannerList->count() > 0)
                @php $firstBanner = $bannerList->first(); @endphp
                <img id="hero-img" src="{{ str_starts_with($firstBanner->gambar, 'images/') ? asset($firstBanner->gambar) : asset('storage/' . $firstBanner->gambar) }}" alt="{{ $firstBanner->judul ?? 'Banner' }}" class="absolute inset-0 w-full h-full object-cover transition-opacity duration-500" />
            @else
                <img id="hero-img" src="{{ asset('images/news1.png') }}" alt="Banner" class="absolute inset-0 w-full h-full object-cover transition-opacity duration-500" />
            @endif
        </div>
        {{-- Tombol navigasi kiri/kanan (tampil di mobile) --}}
        @if($bannerList->count() > 1)
        <button id="hero-prev" class="md:hidden absolute left-2 top-1/2 -translate-y-1/2 z-10 bg-black/30 hover:bg-black/50 text-white rounded-full w-8 h-8 flex items-center justify-center transition-all" aria-label="Banner sebelumnya">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
        </button>
        <button id="hero-next" class="md:hidden absolute right-2 top-1/2 -translate-y-1/2 z-10 bg-black/30 hover:bg-black/50 text-white rounded-full w-8 h-8 flex items-center justify-center transition-all" aria-label="Banner berikutnya">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        </button>
        @endif
        <div class="absolute bottom-4 left-1/2 flex gap-2" style="transform: translateX(-50%);" id="hero-dots">
        </div>
    </section>
    <script>
    (function(){
        var heroImages = [
            @foreach($bannerList as $banner)
                '{{ str_starts_with($banner->gambar, "images/") ? asset($banner->gambar) : asset("storage/" . $banner->gambar) }}',
            @endforeach
        ];
        if (heroImages.length <= 1) return;

        var heroIdx = 0;
        var heroImg = document.getElementById('hero-img');
        var heroSection = document.getElementById('hero-section');
        var dotsContainer = document.getElementById('hero-dots');
        var autoplayTimer;

        // Create dots
        heroImages.forEach(function(_, i) {
            var dot = document.createElement('span');
            dot.className = 'w-2 h-2 rounded-full cursor-pointer transition-all duration-300 ' + (i === 0 ? 'bg-white shadow scale-125' : 'bg-gray-300');
            dot.addEventListener('click', function() { goToHero(i); resetAutoplay(); });
            dotsContainer.appendChild(dot);
        });

        function updateDots() {
            var dots = dotsContainer.children;
            for (var i = 0; i < dots.length; i++) {
                dots[i].className = 'w-2 h-2 rounded-full cursor-pointer transition-all duration-300 ' + (i === heroIdx ? 'bg-white shadow scale-125' : 'bg-gray-300');
            }
        }

        function goToHero(idx) {
            heroIdx = idx;
            heroImg.style.opacity = '0';
            setTimeout(function() {
                heroImg.src = heroImages[heroIdx];
                heroImg.style.opacity = '1';
                updateDots();
            }, 300);
        }

        function goNext() {
            goToHero((heroIdx + 1) % heroImages.length);
        }

        function goPrev() {
            goToHero((heroIdx - 1 + heroImages.length) % heroImages.length);
        }

        // Autoplay
        function startAutoplay() {
            autoplayTimer = setInterval(goNext, 5000);
        }
        function resetAutoplay() {
            clearInterval(autoplayTimer);
            startAutoplay();
        }
        startAutoplay();

        // Tombol navigasi
        var prevBtn = document.getElementById('hero-prev');
        var nextBtn = document.getElementById('hero-next');
        if (prevBtn) prevBtn.addEventListener('click', function() { goPrev(); resetAutoplay(); });
        if (nextBtn) nextBtn.addEventListener('click', function() { goNext(); resetAutoplay(); });

        // Touch swipe support (mobile)
        var touchStartX = 0;
        var touchEndX = 0;
        var touchStartY = 0;
        var touchEndY = 0;
        var isSwiping = false;

        heroSection.addEventListener('touchstart', function(e) {
            touchStartX = e.changedTouches[0].screenX;
            touchStartY = e.changedTouches[0].screenY;
            isSwiping = true;
        }, { passive: true });

        heroSection.addEventListener('touchmove', function(e) {
            if (!isSwiping) return;
            touchEndX = e.changedTouches[0].screenX;
            touchEndY = e.changedTouches[0].screenY;
        }, { passive: true });

        heroSection.addEventListener('touchend', function(e) {
            if (!isSwiping) return;
            isSwiping = false;
            touchEndX = e.changedTouches[0].screenX;
            touchEndY = e.changedTouches[0].screenY;

            var diffX = touchStartX - touchEndX;
            var diffY = Math.abs(touchStartY - touchEndY);

            // Minimal swipe 50px horizontal, dan lebih dominan horizontal dari vertikal
            if (Math.abs(diffX) > 50 && Math.abs(diffX) > diffY) {
                if (diffX > 0) {
                    goNext(); // Swipe kiri = next
                } else {
                    goPrev(); // Swipe kanan = prev
                }
                resetAutoplay();
            }
        }, { passive: true });
    })();
    </script>

    {{-- Lembaga: grey container + title + description + 3x3 grid --}}
    <section id="lembaga" class="py-12 lg:py-16 px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto rounded-2xl p-8 lg:p-12 relative overflow-hidden" style="background-image: url('{{ asset('images/background-card-lembaga.png') }}'); background-size: cover; background-position: center;">
            <div class="relative">
                <h2 class="text-center text-2xl lg:text-3xl font-bold text-gray-700 mb-3">LEMBAGA</h2>
                <p class="text-center text-gray-500 text-base lg:text-lg max-w-3xl mx-auto mb-10 leading-relaxed">
                    Lembaga pendidikan yang berkomitmen menciptakan lingkungan belajar yang aman, peduli, dan inspiratif guna mendukung tumbuh kembang peserta didik secara optimal.
                </p>

                {{-- Grid lembaga: item pertama besar di tengah, sisanya 3 kolom --}}
                @php $firstLembaga = $lembagaList->first(); $restLembaga = $lembagaList->slice(1); @endphp
                @if($firstLembaga)
                <div class="flex justify-center mb-5 lg:mb-6">
                    @php
                        $logoSrc0 = $firstLembaga->logo
                            ? (str_starts_with($firstLembaga->logo, 'images/') ? asset($firstLembaga->logo) : asset('storage/' . $firstLembaga->logo))
                            : null;
                    @endphp
                    <a href="/lembaga/{{ $firstLembaga->slug }}" class="group block bg-white rounded-xl shadow-md hover:shadow-xl transition-shadow p-8 text-center border border-gray-100 w-full max-w-md animate-on-scroll hover-lift">
                        @if($logoSrc0)
                        <div class="w-40 h-40 mx-auto mb-4 flex items-center justify-center" aria-hidden="true">
                            <img src="{{ $logoSrc0 }}" alt="{{ $firstLembaga->nama }}" class="w-36 h-36 object-contain">
                        </div>
                        @else
                        <div class="w-40 h-40 mx-auto mb-4 rounded-full flex items-center justify-center text-white font-bold text-3xl {{ $firstLembaga->warna_bg }}" aria-hidden="true">
                            {{ $firstLembaga->singkatan }}
                        </div>
                        @endif
                        <h3 class="font-semibold text-gray-700 text-lg lg:text-xl leading-snug">{{ $firstLembaga->nama }}</h3>
                    </a>
                </div>
                @endif
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 lg:gap-6 stagger-children">
                    @foreach($restLembaga as $item)
                        @php
                            $logoSrc = $item->logo
                                ? (str_starts_with($item->logo, 'images/') ? asset($item->logo) : asset('storage/' . $item->logo))
                                : null;
                        @endphp
                        <a href="/lembaga/{{ $item->slug }}" class="group block bg-white rounded-xl shadow-md hover:shadow-xl transition-shadow p-6 text-center border border-gray-100 animate-on-scroll hover-lift">
                            @if($logoSrc && file_exists(public_path($item->logo)) || ($logoSrc && !str_starts_with($item->logo, 'images/')))
                            <div class="w-32 h-32 mx-auto mb-4 flex items-center justify-center" aria-hidden="true">
                                <img src="{{ $logoSrc }}" alt="{{ $item->nama }}" class="w-28 h-28 object-contain">
                            </div>
                            @else
                            <div class="w-32 h-32 mx-auto mb-4 rounded-full flex items-center justify-center text-white font-bold text-2xl {{ $item->warna_bg }}" aria-hidden="true">
                                {{ $item->singkatan }}
                            </div>
                            @endif
                            <h3 class="font-semibold text-gray-700 text-base lg:text-lg leading-snug">{{ $item->nama }}</h3>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- Galeri Terbaru: carousel dengan animasi slide smooth --}}
    <section class="py-12 lg:py-16 px-0 bg-white overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-center text-2xl lg:text-3xl font-bold text-black uppercase mb-10">GALERI</h2>
        </div>
        <div class="relative w-full" id="galeri-carousel">
            <div class="flex items-center justify-center" style="min-height: 320px;">
                
                <!-- Left Arrow -->
                <button type="button" id="galeri-prev" class="absolute left-4 md:left-8 z-20 w-10 h-10 rounded-full flex items-center justify-center text-white transition hover:bg-white hover:text-gray-900" style="background-color: rgba(0,0,0,0.3); backdrop-filter: blur(4px);" aria-label="Sebelumnya">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                </button>

                <!-- Carousel Track -->
                <div class="flex items-center justify-center w-full" style="perspective: 1000px;">
                    <!-- Left Image -->
                    <div id="galeri-slide-left" class="hidden md:block relative overflow-hidden shrink-0 transition-all duration-500 ease-in-out cursor-pointer" style="width: 25%; height: 230px; border-radius: 1.2rem; transform: scale(0.9); opacity: 0.7;">
                        <img src="" alt="" class="absolute inset-0 w-full h-full object-cover" />
                        <div class="absolute inset-0 bg-black/50"></div>
                    </div>

                    <!-- Center Image -->
                    <div id="galeri-slide-center" class="relative overflow-hidden shrink-0 mx-3 transition-all duration-500 ease-in-out" style="width: 85%; max-width: 600px; height: 250px; border-radius: 1.5rem; box-shadow: 0 15px 50px rgba(0,0,0,0.15); transform: scale(1); z-index: 10;">
                        <img src="" alt="Galeri kegiatan Harapan Bunda" class="absolute inset-0 w-full h-full object-cover" />
                    </div>

                    <!-- Right Image -->
                    <div id="galeri-slide-right" class="hidden md:block relative overflow-hidden shrink-0 transition-all duration-500 ease-in-out cursor-pointer" style="width: 25%; height: 230px; border-radius: 1.2rem; transform: scale(0.9); opacity: 0.7;">
                        <img src="" alt="" class="absolute inset-0 w-full h-full object-cover" />
                        <div class="absolute inset-0 bg-black/50"></div>
                    </div>
                </div>

                <!-- Right Arrow -->
                <button type="button" id="galeri-next" class="absolute right-4 md:right-8 z-20 w-10 h-10 rounded-full flex items-center justify-center text-white transition hover:bg-white hover:text-gray-900" style="background-color: rgba(0,0,0,0.3); backdrop-filter: blur(4px);" aria-label="Selanjutnya">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </button>
            </div>


        </div>
    </section>
    <script>
        (function() {
            var galeriImages = [
                @foreach($galeriList as $gal)
                    '{{ str_starts_with($gal->gambar, "images/") ? asset($gal->gambar) : asset("storage/" . $gal->gambar) }}',
                @endforeach
            ];
            var idx = 0;
            var n = galeriImages.length;
            var isAnimating = false;

            var leftSlide = document.getElementById('galeri-slide-left');
            var centerSlide = document.getElementById('galeri-slide-center');
            var rightSlide = document.getElementById('galeri-slide-right');
            var leftImg = leftSlide.querySelector('img');
            var centerImg = centerSlide.querySelector('img');
            var rightImg = rightSlide.querySelector('img');




            function updateImages(direction) {
                if (isAnimating) return;
                isAnimating = true;

                // Crossfade Slide: foto lama memudar sambil geser pelan, foto baru muncul perlahan
                var shiftOut = direction === 'next' ? '-40px' : '40px';
                var shiftIn = direction === 'next' ? '40px' : '-40px';
                var allSlides = [leftSlide, centerSlide, rightSlide];

                // Step 1: Fade out + slight shift
                allSlides.forEach(function(s) {
                    s.style.transition = 'transform 0.5s cubic-bezier(0.4,0,0.6,1), opacity 0.5s cubic-bezier(0.4,0,0.6,1)';
                    s.style.opacity = '0';
                    s.style.transform = (s === centerSlide ? 'scale(1)' : 'scale(0.9)') + ' translateX(' + shiftOut + ')';
                });

                setTimeout(function() {
                    // Step 2: Swap images while invisible
                    centerImg.src = galeriImages[idx];
                    leftImg.src = galeriImages[(idx - 1 + n) % n];
                    rightImg.src = galeriImages[(idx + 1) % n];

                    // Position at entrance offset instantly
                    allSlides.forEach(function(s) {
                        s.style.transition = 'none';
                        s.style.transform = (s === centerSlide ? 'scale(1)' : 'scale(0.9)') + ' translateX(' + shiftIn + ')';
                        s.style.opacity = '0';
                    });

                    void centerSlide.offsetWidth;

                    // Step 3: Fade in smoothly with gentle slide to center
                    requestAnimationFrame(function() {
                        allSlides.forEach(function(s) {
                            s.style.transition = 'transform 0.65s cubic-bezier(0.16,1,0.3,1), opacity 0.6s cubic-bezier(0.16,1,0.3,1)';
                        });
                        leftSlide.style.opacity = '0.7';
                        leftSlide.style.transform = 'scale(0.9) translateX(0)';
                        centerSlide.style.opacity = '1';
                        centerSlide.style.transform = 'scale(1) translateX(0)';
                        rightSlide.style.opacity = '0.7';
                        rightSlide.style.transform = 'scale(0.9) translateX(0)';
                        
                        setTimeout(function() { isAnimating = false; }, 700);
                    });
                }, 500);
            }

            function goTo(newIdx) {
                if (isAnimating || newIdx === idx) return;
                var dir = newIdx > idx ? 'next' : 'prev';
                idx = newIdx;
                updateImages(dir);
            }

            // Init
            centerImg.src = galeriImages[0];
            leftImg.src = galeriImages[n - 1];
            rightImg.src = galeriImages[1];

            document.getElementById('galeri-prev').addEventListener('click', function() {
                idx = (idx - 1 + n) % n;
                updateImages('prev');
            });
            document.getElementById('galeri-next').addEventListener('click', function() {
                idx = (idx + 1) % n;
                updateImages('next');
            });

            // Click side images to navigate
            leftSlide.addEventListener('click', function() {
                idx = (idx - 1 + n) % n;
                updateImages('prev');
            });
            rightSlide.addEventListener('click', function() {
                idx = (idx + 1) % n;
                updateImages('next');
            });

            // Auto-play every 4 seconds
            var autoPlay = setInterval(function() {
                idx = (idx + 1) % n;
                updateImages('next');
            }, 4000);

            // Pause on hover
            document.getElementById('galeri-carousel').addEventListener('mouseenter', function() {
                clearInterval(autoPlay);
            });
            document.getElementById('galeri-carousel').addEventListener('mouseleave', function() {
                autoPlay = setInterval(function() {
                    idx = (idx + 1) % n;
                    updateImages('next');
                }, 4000);
            });
        })();
    </script>

    {{-- Berita Terbaru — background polos putih, tata letak: judul tengah, kiri Kategori, kanan grid 2x2 --}}
    <section class="py-12 lg:py-16 px-4 sm:px-6 lg:px-8 bg-white">
        <div class="max-w-6xl mx-auto">
            <h2 class="text-center text-2xl lg:text-3xl font-bold text-black uppercase mb-2 animate-on-scroll">BERITA TERBARU</h2>
            <p class="text-center text-gray-600 text-base lg:text-lg max-w-2xl mx-auto mb-10">
                Temukan kabar terkini mengenai aktivitas, agenda, dan pencapaian Yayasan LPIT Harapan Purwokerto.
            </p>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-10 items-start">
                <div class="lg:col-span-1 order-2 lg:order-1">
                    <h3 class="font-bold text-black text-xl mb-4 pb-2 border-b-2 border-gray-300">Kategori Berita</h3>
                    <ul class="space-y-2 text-gray-700 text-base">
                        @foreach($kategoriList as $kategori)
                            <li><a href="{{ route('berita.index', ['kategori' => $kategori]) }}" class="block py-1 hover:underline">{{ $kategori }}</a></li>
                        @endforeach
                    </ul>
                </div>
                {{-- Grid 2x2: 3 kartu berita + 1 tombol — dipaksa 2 kolom dengan inline style --}}
                <div class="lg:col-span-2 order-1 lg:order-2" style="display: grid; grid-template-columns: repeat(1, 1fr); gap: 1rem;">
                <style>
                    @media (min-width: 640px) {
                        .berita-home-grid { grid-template-columns: repeat(2, 1fr) !important; }
                    }
                </style>
                <script>document.currentScript.previousElementSibling.parentElement.classList.add('berita-home-grid');</script>
                    @php $homeNewsImages = ['news1.png','news2.png','news3.png','news4.png','news5.png','news6.png','news7.jpeg']; @endphp
                    @forelse($beritaTerbaru as $item)
                        <a href="{{ route('berita.show', $item->slug) }}" class="relative overflow-hidden rounded-2xl bg-gray-100 group" style="aspect-ratio: 4/3; box-shadow: 0 2px 14px rgba(0,0,0,0.08);">
                            @if($item->gambar)
                            <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->judul }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" />
                            @else
                            <img src="{{ asset('images/' . $homeNewsImages[$loop->index % count($homeNewsImages)]) }}" alt="{{ $item->judul }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" />
                            @endif
                            <div class="absolute inset-0 bg-black/40"></div>
                            <div class="absolute left-0 bottom-0 p-4">
                                <h4 class="font-bold text-white uppercase text-base md:text-lg mb-1" style="text-shadow: 0 1px 2px rgba(0,0,0,0.7);">{{ $item->judul }}</h4>
                                <p class="text-white text-sm flex items-center gap-1.5" style="text-shadow: 0 1px 2px rgba(0,0,0,0.7);">
                                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    {{ ($item->tanggal ?? $item->created_at)->format('j F Y') }}
                                </p>
                            </div>
                        </a>
                    @empty
                        @foreach([1, 2, 3] as $i)
                        <article class="relative overflow-hidden rounded-2xl bg-gray-100" style="aspect-ratio: 4/3; box-shadow: 0 2px 14px rgba(0,0,0,0.08);">
                            <img src="{{ asset('images/news' . $i . '.png') }}" alt="" class="absolute inset-0 w-full h-full object-cover" />
                            <div class="absolute inset-0 bg-black/40"></div>
                            <div class="absolute left-0 bottom-0 p-4">
                                <h4 class="font-bold text-white uppercase text-base md:text-lg mb-1" style="text-shadow: 0 1px 2px rgba(0,0,0,0.7);">JUDUL BERITA</h4>
                                <p class="text-white text-sm flex items-center gap-1.5" style="text-shadow: 0 1px 2px rgba(0,0,0,0.7);">
                                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    1 January 2026
                                </p>
                            </div>
                        </article>
                        @endforeach
                    @endforelse
                    <a href="{{ route('berita.index') }}" class="flex flex-col items-center justify-center rounded-2xl text-white font-medium text-center p-6 transition hover:opacity-90 hover:shadow-xl duration-300 group" style="aspect-ratio: 4/3; background-color: #8280af; box-shadow: 0 2px 14px rgba(0,0,0,0.08);">
                        <span class="block text-2xl font-bold leading-snug group-hover:scale-105 transition-transform">Tampilkan</span>
                        <span class="block text-2xl font-bold leading-snug group-hover:scale-105 transition-transform">semua berita</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA: Siap Bergabung Dengan Kami? --}}
    <section class="relative overflow-hidden" style="background-color: #6E7098;">
        {{-- Diamond pattern overlay --}}
        <div class="absolute inset-0 opacity-10" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cpath d=\'M30 0L60 30L30 60L0 30Z\' fill=\'none\' stroke=\'white\' stroke-width=\'1\'/%3E%3C/svg%3E'); background-size: 60px 60px;"></div>
        
        <div class="relative z-10 max-w-4xl mx-auto text-center py-16 lg:py-20 px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold text-white mb-4" style="text-shadow: 0 2px 4px rgba(0,0,0,0.2);">
                Siap Bergabung Dengan Kami?
            </h2>
            <p class="text-white/80 text-base md:text-lg max-w-2xl mx-auto mb-8 leading-relaxed">
                Daftarkan putra-putri Anda di Yayasan LPIT Harapan Bunda Purwokerto dan berikan pendidikan terbaik untuk masa depan mereka.
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="https://ppdb.harbundpurwokerto.sch.id/" target="_blank" class="inline-flex items-center justify-center px-8 py-3 bg-white text-[#6E7098] font-bold text-base uppercase rounded-full shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300 tracking-wide">
                    DAFTAR SEKARANG
                </a>
                <a href="{{ route('kontak') }}" class="inline-flex items-center justify-center px-8 py-3 bg-transparent border-2 border-white text-white font-bold text-base uppercase rounded-full hover:bg-white hover:text-[#6E7098] transition-all duration-300 tracking-wide">
                    HUBUNGI KAMI
                </a>
            </div>
        </div>
    </section>

    {{-- Testimoni: background dengan gambar pattern, 3 kartu testimoni, tombol navigasi --}}
    <section class="py-16 lg:py-20 px-4 sm:px-6 lg:px-8 relative overflow-hidden" style="background-color: #e8e6ef;">
        {{-- Background Image Pattern --}}
        <div class="absolute inset-0" style="background-image: url('{{ asset('images/background-testimoni.png') }}'); background-size: cover; background-position: center; background-repeat: no-repeat; opacity: 0.15;"></div>
        
        <div class="max-w-6xl mx-auto relative z-10">
            <h2 class="text-center text-2xl lg:text-3xl font-bold text-gray-900 uppercase mb-12">TESTIMONI</h2>
            
            @php $totalTestimoni = $testimoniList->count(); @endphp

            {{-- Testimoni Grid --}}
            <div id="testimoniGrid" class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                @forelse($testimoniList as $index => $testimoni)
                    <div class="testimoni-item" data-index="{{ $index }}" style="{{ $index >= 3 ? 'display:none;' : '' }}">
                        <div class="bg-white rounded-2xl shadow-md p-6 text-center h-full">
                            @if($testimoni->foto)
                                <img src="{{ asset('storage/' . $testimoni->foto) }}" alt="{{ $testimoni->nama }}" class="w-16 h-16 mx-auto mb-4 rounded-full object-cover">
                            @else
                                <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center">
                                    <svg class="w-8 h-8 text-blue-400" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                    </svg>
                                </div>
                            @endif
                            <h3 class="font-bold text-base mb-1 text-gray-800">{{ $testimoni->nama }}</h3>
                            @if($testimoni->jabatan)
                                <p class="text-sm text-gray-400 mb-3">{{ $testimoni->jabatan }}</p>
                            @else
                                <div class="mb-3"></div>
                            @endif
                            <p class="text-sm md:text-base text-gray-500 leading-relaxed">{{ $testimoni->isi }}</p>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center py-8 text-gray-400 text-base">
                        Belum ada testimoni
                    </div>
                @endforelse
            </div>
            
            {{-- Navigation Buttons --}}
            @if($totalTestimoni > 3)
            <div class="flex items-center justify-center gap-3">
                <button onclick="testimoniPrev()" id="testimoniPrevBtn" class="px-6 py-2 rounded-full border-2 border-gray-800 text-gray-800 font-medium text-base hover:bg-gray-800 hover:text-white transition" style="opacity:0.4; cursor:not-allowed;" disabled>
                    Previous
                </button>
                <button onclick="testimoniNext()" id="testimoniNextBtn" class="px-6 py-2 rounded-full border-2 border-gray-800 text-gray-800 font-medium text-base hover:bg-gray-800 hover:text-white transition">
                    Next
                </button>
            </div>
            @endif
        </div>
    </section>

    <script>
    (function() {
        var items = document.querySelectorAll('.testimoni-item');
        var total = items.length;
        if (total === 0) return;
        var perPage = 3;
        var page = 0;
        var maxPage = Math.max(0, Math.ceil(total / perPage) - 1);
        var prevBtn = document.getElementById('testimoniPrevBtn');
        var nextBtn = document.getElementById('testimoniNextBtn');
        var isAnimating = false;

        // Set initial styles for all items
        for (var i = 0; i < total; i++) {
            items[i].style.transition = 'none';
            items[i].style.opacity = i < perPage ? '1' : '0';
            items[i].style.transform = 'translateX(0) scale(1)';
            items[i].style.display = i < perPage ? '' : 'none';
        }

        function render(direction) {
            if (isAnimating) return;
            isAnimating = true;

            var start = page * perPage;
            var end = start + perPage;

            // Collect visible items
            var visibleItems = [];
            for (var i = 0; i < total; i++) {
                if (items[i].style.display !== 'none') {
                    visibleItems.push(items[i]);
                }
            }

            // Stagger order: next = kiri dulu hilang, prev = kanan dulu hilang
            if (direction === 'prev') visibleItems.reverse();

            // Step 1: Fade out satu per satu
            var exitDelay = 0.1; // delay antar kartu
            visibleItems.forEach(function(item, idx) {
                item.style.transition = 'transform 0.3s cubic-bezier(0.4,0,0.6,1), opacity 0.3s ease';
                item.style.transitionDelay = (idx * exitDelay) + 's';
                item.style.opacity = '0';
                item.style.transform = 'translateY(20px) scale(0.92)';
            });

            var totalExitTime = 300 + (visibleItems.length - 1) * (exitDelay * 1000);

            setTimeout(function() {
                // Step 2: Hide old, prepare new items
                for (var i = 0; i < total; i++) {
                    items[i].style.transitionDelay = '0s';
                    if (i >= start && i < end) {
                        items[i].style.transition = 'none';
                        items[i].style.display = '';
                        items[i].style.opacity = '0';
                        items[i].style.transform = 'translateY(30px) scale(0.92)';
                    } else {
                        items[i].style.display = 'none';
                    }
                }

                void document.getElementById('testimoniGrid').offsetWidth;

                // Step 3: Fade in satu per satu
                var enterDelay = 0.12;
                requestAnimationFrame(function() {
                    for (var i = start; i < end && i < total; i++) {
                        var idx = i - start;
                        // Prev: muncul dari kanan dulu
                        if (direction === 'prev') idx = (Math.min(end, total) - 1 - start) - (i - start);
                        items[i].style.transition = 'transform 0.45s cubic-bezier(0.16,1,0.3,1), opacity 0.4s cubic-bezier(0.16,1,0.3,1)';
                        items[i].style.transitionDelay = (idx * enterDelay) + 's';
                        items[i].style.opacity = '1';
                        items[i].style.transform = 'translateY(0) scale(1)';
                    }
                    var totalCards = Math.min(end, total) - start;
                    setTimeout(function() {
                        for (var i = 0; i < total; i++) {
                            items[i].style.transitionDelay = '0s';
                        }
                        isAnimating = false;
                    }, 450 + totalCards * (enterDelay * 1000));
                });
            }, totalExitTime + 50);

            // Update buttons
            if (prevBtn) {
                prevBtn.disabled = page <= 0;
                prevBtn.style.opacity = page <= 0 ? '0.4' : '1';
                prevBtn.style.cursor = page <= 0 ? 'not-allowed' : 'pointer';
            }
            if (nextBtn) {
                nextBtn.disabled = page >= maxPage;
                nextBtn.style.opacity = page >= maxPage ? '0.4' : '1';
                nextBtn.style.cursor = page >= maxPage ? 'not-allowed' : 'pointer';
            }
        }

        function renderInit() {
            var start = page * perPage;
            var end = start + perPage;
            for (var i = 0; i < total; i++) {
                items[i].style.display = (i >= start && i < end) ? '' : 'none';
                items[i].style.opacity = (i >= start && i < end) ? '1' : '0';
                items[i].style.transform = 'translateX(0) scale(1)';
            }
            if (prevBtn) {
                prevBtn.disabled = page <= 0;
                prevBtn.style.opacity = page <= 0 ? '0.4' : '1';
                prevBtn.style.cursor = page <= 0 ? 'not-allowed' : 'pointer';
            }
            if (nextBtn) {
                nextBtn.disabled = page >= maxPage;
                nextBtn.style.opacity = page >= maxPage ? '0.4' : '1';
                nextBtn.style.cursor = page >= maxPage ? 'not-allowed' : 'pointer';
            }
        }

        window.testimoniNext = function() { if (!isAnimating && page < maxPage) { page++; render('next'); } };
        window.testimoniPrev = function() { if (!isAnimating && page > 0) { page--; render('prev'); } };
        renderInit();
    })();
    </script>

    {{-- Footer: background hitam, 3 kolom (Tentang, Lembaga, Kontak Kami) --}}
    <footer class="bg-[#2d2d2d] text-white py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">
            {{-- Kolom 1: TENTANG --}}
            <div>
                <h3 class="font-bold text-lg uppercase mb-4">TENTANG</h3>
                <p class="text-sm md:text-base text-gray-300 leading-relaxed">
                    {{ $kontak->tentang_deskripsi }}
                </p>
            </div>
            
            {{-- Kolom 2: LEMBAGA --}}
            <div>
                <h3 class="font-bold text-lg uppercase mb-4">LEMBAGA</h3>
                <ul class="text-sm md:text-base text-gray-300 space-y-2">
                    @foreach($lembagaList as $item)
                        <li><a href="/lembaga/{{ $item->slug }}" class="hover:text-white transition">• {{ $item->nama }}</a></li>
                    @endforeach
                </ul>
            </div>
            
            {{-- Kolom 3: KONTAK KAMI --}}
            <div>
                <h3 class="font-bold text-lg uppercase mb-4">KONTAK KAMI</h3>
                <div class="space-y-3 mb-4">
                    <div class="text-sm md:text-base">
                        <span class="text-gray-400">Telepon</span>
                        <p class="text-white">{{ $kontak->telepon }}</p>
                    </div>
                    <div class="text-sm md:text-base">
                        <span class="text-gray-400">Email</span>
                        <p class="text-white">{{ $kontak->email }}</p>
                    </div>
                </div>
                {{-- Social Media Icons --}}
                <div class="flex items-center gap-3 mb-4">
                    @if($kontak->facebook_url)
                    <a href="{{ $kontak->facebook_url }}" target="_blank" class="w-10 h-10 rounded bg-blue-600 flex items-center justify-center hover:opacity-80 transition">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </a>
                    @endif
                    @if($kontak->instagram_url)
                    <a href="{{ $kontak->instagram_url }}" target="_blank" class="w-10 h-10 rounded bg-gradient-to-tr from-yellow-400 via-red-500 to-purple-600 flex items-center justify-center hover:opacity-80 transition">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                    </a>
                    @endif
                    @if($kontak->youtube_url)
                    <a href="{{ $kontak->youtube_url }}" target="_blank" class="w-10 h-10 rounded bg-red-600 flex items-center justify-center hover:opacity-80 transition">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                        </svg>
                    </a>
                    @endif
                </div>
                <div class="text-sm md:text-base mt-4">
                    <span class="text-gray-400 font-semibold">Alamat</span>
                    <p class="text-white mt-1">{{ $kontak->alamat }}</p>
                </div>
            </div>
        </div>
    </footer>
@endsection

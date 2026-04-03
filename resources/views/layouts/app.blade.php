<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @php
        $metaTitle = trim($__env->yieldContent('meta_title', $__env->yieldContent('title', 'Harapan Bunda Purwokerto')));
        $metaDescription = trim($__env->yieldContent('meta_description', 'Website resmi Harapan Bunda Purwokerto.'));
        $metaImage = trim($__env->yieldContent('meta_image', asset('images/logo-hb.png')));
        $metaUrl = trim($__env->yieldContent('meta_url', url()->current()));
        $metaType = trim($__env->yieldContent('meta_type', 'website'));
    @endphp
    <title>{{ $metaTitle }}</title>
    <meta name="description" content="{{ $metaDescription }}">
    <link rel="canonical" href="{{ $metaUrl }}">

    <meta property="og:site_name" content="Harapan Bunda Purwokerto">
    <meta property="og:title" content="{{ $metaTitle }}">
    <meta property="og:description" content="{{ $metaDescription }}">
    <meta property="og:url" content="{{ $metaUrl }}">
    <meta property="og:type" content="{{ $metaType }}">
    <meta property="og:image" content="{{ $metaImage }}">
    <meta property="og:image:secure_url" content="{{ $metaImage }}">
    <meta property="og:image:alt" content="{{ $metaTitle }}">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $metaTitle }}">
    <meta name="twitter:description" content="{{ $metaDescription }}">
    <meta name="twitter:image" content="{{ $metaImage }}">
    @if(file_exists(public_path('favicon.png')))
        <link rel="icon" href="{{ asset('favicon.png') }}?v={{ filemtime(public_path('favicon.png')) }}" type="image/png">
    @elseif(file_exists(public_path('favicon.ico')))
        <link rel="icon" href="{{ asset('favicon.ico') }}?v={{ filemtime(public_path('favicon.ico')) }}" type="image/x-icon">
    @endif
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
    <style>
        body { font-family: 'Poppins', ui-sans-serif, system-ui, sans-serif; }
        html { scroll-behavior: smooth; }

        /* ===== Scroll Animations ===== */
        .animate-on-scroll {
            opacity: 0;
            transform: translateY(40px);
            transition: opacity 0.7s cubic-bezier(0.22, 1, 0.36, 1), transform 0.7s cubic-bezier(0.22, 1, 0.36, 1);
        }
        .animate-on-scroll.animate-from-left {
            transform: translateX(-50px);
        }
        .animate-on-scroll.animate-from-right {
            transform: translateX(50px);
        }
        .animate-on-scroll.animate-scale {
            transform: scale(0.9);
        }
        .animate-on-scroll.is-visible {
            opacity: 1;
            transform: translateY(0) translateX(0) scale(1);
        }

        /* Stagger children */
        .stagger-children > .animate-on-scroll:nth-child(1) { transition-delay: 0s; }
        .stagger-children > .animate-on-scroll:nth-child(2) { transition-delay: 0.1s; }
        .stagger-children > .animate-on-scroll:nth-child(3) { transition-delay: 0.2s; }
        .stagger-children > .animate-on-scroll:nth-child(4) { transition-delay: 0.3s; }
        .stagger-children > .animate-on-scroll:nth-child(5) { transition-delay: 0.4s; }
        .stagger-children > .animate-on-scroll:nth-child(6) { transition-delay: 0.5s; }
        .stagger-children > .animate-on-scroll:nth-child(7) { transition-delay: 0.6s; }
        .stagger-children > .animate-on-scroll:nth-child(8) { transition-delay: 0.7s; }
        .stagger-children > .animate-on-scroll:nth-child(9) { transition-delay: 0.8s; }
        .stagger-children > .animate-on-scroll:nth-child(10) { transition-delay: 0.9s; }

        /* Smooth card hover lift */
        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .hover-lift:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 30px rgba(0,0,0,0.12);
        }

        /* Subtle pulse for CTA */
        @keyframes subtlePulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.02); }
        }

        /* Counter animation */
        .count-up { display: inline-block; }

        /* ===== Page Entrance ===== */
        body { animation: pageEntrance 0.6s ease-out; }
        @keyframes pageEntrance {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        /* ===== Header Shrink ===== */
        header {
            transition: box-shadow 0.3s ease, background-color 0.3s ease;
            will-change: box-shadow;
            transform: translateZ(0);
        }
        header.scrolled {
            box-shadow: 0 2px 20px rgba(0,0,0,0.08);
        }
        header.scrolled .header-inner {
            height: 64px !important;
        }
        header.scrolled .header-logo {
            width: 140px !important; height: 140px !important;
        }
        header.scrolled .header-logo-2 {
            height: 50px !important;
        }
        @media (min-width: 1024px) {
            header.scrolled .header-inner { height: 72px !important; }
            header.scrolled .header-logo { width: 180px !important; height: 180px !important; }
            header.scrolled .header-logo-2 { height: 60px !important; }
        }
        .header-inner, .header-logo, .header-logo-2 {
            transition-property: height, width, box-shadow, transform, opacity;
            transition-duration: 0.35s;
            transition-timing-function: cubic-bezier(0.22, 1, 0.36, 1);
            backface-visibility: hidden;
            transform: translateZ(0);
        }
        .header-inner { will-change: height; }
        .header-logo, .header-logo-2 { will-change: width, height, transform; }

        /* ===== Parallax Banner ===== */
        .parallax-banner {
            will-change: transform;
        }
        .parallax-banner img {
            transition: transform 0.1s linear;
        }

        /* ===== Back to Top Button ===== */
        #back-to-top {
            position: fixed; bottom: 2rem; right: 2rem; z-index: 99;
            width: 48px; height: 48px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: white; border: none; border-radius: 50%;
            cursor: pointer; display: flex; align-items: center; justify-content: center;
            opacity: 0; transform: translateY(20px) scale(0.8);
            transition: opacity 0.35s ease, transform 0.35s ease, box-shadow 0.3s ease;
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
            pointer-events: none;
        }
        #back-to-top.visible {
            opacity: 1; transform: translateY(0) scale(1); pointer-events: auto;
        }
        #back-to-top:hover {
            box-shadow: 0 6px 25px rgba(99, 102, 241, 0.5);
            transform: translateY(-3px) scale(1.05);
        }

        /* ===== Underline Grow (links) ===== */
        .underline-grow {
            position: relative;
        }
        .underline-grow::after {
            content: ''; position: absolute; bottom: -2px; left: 50%; width: 0; height: 2px;
            background: #6366f1; transition: width 0.3s ease, left 0.3s ease;
        }
        .underline-grow:hover::after {
            width: 100%; left: 0;
        }

        /* ===== Image Shine Effect ===== */
        .img-shine { position: relative; overflow: hidden; }
        .img-shine::after {
            content: ''; position: absolute; top: 0; left: -75%;
            width: 50%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transform: skewX(-25deg);
            transition: left 0.6s ease;
        }
        .img-shine:hover::after { left: 125%; }
    </style>
    @stack('styles')
</head>
<body class="antialiased text-gray-800 bg-white">
    <header class="bg-white border-b border-gray-100 sticky top-0 z-50 h-20 lg:h-28 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="header-inner absolute inset-0 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 flex items-center justify-between h-20 lg:h-28">
                <a href="{{ url('/') }}" class="flex items-center gap-3 shrink-0">
                    <img src="{{ isset($headerLogo) && $headerLogo ? asset('storage/' . $headerLogo) : asset('images/logo-hb.png') }}" alt="Logo Harapan Bunda" class="header-logo w-[180px] h-[180px] md:w-[250px] md:h-[250px] object-contain">
                    @if(isset($headerLogo2) && $headerLogo2)
                        <img src="{{ asset('storage/' . $headerLogo2) }}" alt="Logo Kedua" class="header-logo-2 h-[100px] md:h-[140px] lg:h-[160px] w-auto object-contain">
                    @endif
                </a>

                <button id="mobile-menu-btn" class="lg:hidden flex flex-col justify-center items-center w-10 h-10 rounded-lg hover:bg-gray-100 transition" aria-label="Toggle menu">
                    <span id="hamburger-top" class="block w-6 h-0.5 bg-gray-700 transition-all duration-300"></span>
                    <span id="hamburger-mid" class="block w-6 h-0.5 bg-gray-700 mt-1.5 transition-all duration-300"></span>
                    <span id="hamburger-bot" class="block w-6 h-0.5 bg-gray-700 mt-1.5 transition-all duration-300"></span>
                </button>

                <nav class="hidden lg:flex items-center gap-6 lg:gap-8">
                    @forelse($headerMenus ?? [] as $menu)
                        @if($menu->type === 'dropdown_profil')
                            <div class="relative group">
                                <span class="text-base font-medium text-gray-500 hover:text-gray-800 transition cursor-default flex items-center gap-1 select-none">
                                    {{ $menu->label }}
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                </span>
                                <div class="absolute top-full left-0 mt-2 w-64 bg-white rounded-lg shadow-xl border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                                    <div class="py-2">
                                        @foreach($navLembagaList as $nav)
                                            <a href="{{ route('lembaga.show', $nav->slug) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition">{{ $nav->nama }}</a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @else
                            <a href="{{ $menu->url ?? url('/') }}" class="text-base font-medium text-gray-500 hover:text-gray-800 transition {{ request()->url() === url($menu->url) || (rtrim(request()->path(), '/') === ltrim($menu->url ?? '', '/')) ? 'text-gray-800' : '' }}" @if($menu->is_new_tab) target="_blank" rel="noopener" @endif>{{ $menu->label }}</a>
                        @endif
                    @empty
                        <a href="{{ url('/') }}" class="text-base font-medium text-gray-500 hover:text-gray-800 transition {{ request()->is('/') ? 'text-gray-800' : '' }}">BERANDA</a>
                        <div class="relative group">
                            <span class="text-base font-medium text-gray-500 hover:text-gray-800 transition cursor-default flex items-center gap-1 select-none">PROFIL <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg></span>
                            <div class="absolute top-full left-0 mt-2 w-64 bg-white rounded-lg shadow-xl border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                                <div class="py-2">@foreach($navLembagaList as $nav)<a href="{{ route('lembaga.show', $nav->slug) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition">{{ $nav->nama }}</a>@endforeach</div>
                            </div>
                        </div>
                        <a href="https://ppdb.harbundpurwokerto.sch.id/" target="_blank" class="text-base font-medium text-gray-500 hover:text-gray-800 transition">PPDB</a>
                        <a href="{{ route('kontak') }}" class="text-base font-medium text-gray-500 hover:text-gray-800 transition {{ request()->is('kontak') ? 'text-gray-800' : '' }}">KONTAK KAMI</a>
                    @endforelse
                </nav>
            </div>
        </div>

        <div id="mobile-menu" class="lg:hidden hidden border-t border-gray-100 bg-white">
            <div class="px-4 py-4 space-y-1" id="mobile-menu-items">
                @forelse($headerMenus ?? [] as $menu)
                    @if($menu->type === 'dropdown_profil')
                        <div class="mobile-dropdown-wrap">
                            <button type="button" class="mobile-dropdown-btn w-full flex items-center justify-between px-3 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg transition">
                                {{ $menu->label }}
                                <svg class="mobile-dropdown-arrow w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div class="mobile-dropdown-panel hidden pl-4 space-y-1 mt-1">
                                @foreach($navLembagaList as $nav)
                                    <a href="{{ route('lembaga.show', $nav->slug) }}" class="block px-3 py-2 text-sm text-gray-600 hover:bg-gray-50 rounded-lg">{{ $nav->nama }}</a>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <a href="{{ $menu->url ?? url('/') }}" class="block px-3 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg transition {{ request()->is(ltrim($menu->url ?? '/', '/')) ? 'bg-gray-50 text-gray-900' : '' }}" @if($menu->is_new_tab) target="_blank" rel="noopener" @endif>{{ $menu->label }}</a>
                    @endif
                @empty
                    <a href="{{ url('/') }}" class="block px-3 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg transition {{ request()->is('/') ? 'bg-gray-50 text-gray-900' : '' }}">BERANDA</a>
                    <div class="mobile-dropdown-wrap">
                        <button type="button" class="mobile-dropdown-btn w-full flex items-center justify-between px-3 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg transition">PROFIL <svg class="mobile-dropdown-arrow w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg></button>
                        <div class="mobile-dropdown-panel hidden pl-4 space-y-1 mt-1">@foreach($navLembagaList as $nav)<a href="{{ route('lembaga.show', $nav->slug) }}" class="block px-3 py-2 text-sm text-gray-600 hover:bg-gray-50 rounded-lg">{{ $nav->nama }}</a>@endforeach</div>
                    </div>
                    <a href="https://ppdb.harbundpurwokerto.sch.id/" target="_blank" class="block px-3 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg transition">PPDB</a>
                    <a href="{{ route('kontak') }}" class="block px-3 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg transition {{ request()->is('kontak') ? 'bg-gray-50 text-gray-900' : '' }}">KONTAK KAMI</a>
                @endforelse
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <!-- Back to Top Button -->
    <button id="back-to-top" aria-label="Kembali ke atas" title="Kembali ke atas">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7"/></svg>
    </button>

    <script>
        (function() {
            var menuBtn = document.getElementById('mobile-menu-btn');
            var menu = document.getElementById('mobile-menu');
            var top = document.getElementById('hamburger-top');
            var mid = document.getElementById('hamburger-mid');
            var bot = document.getElementById('hamburger-bot');
            var isOpen = false;
            menuBtn && menuBtn.addEventListener('click', function() {
                isOpen = !isOpen;
                menu.classList.toggle('hidden');
                if (isOpen) { top.style.transform = 'translateY(8px) rotate(45deg)'; mid.style.opacity = '0'; bot.style.transform = 'translateY(-8px) rotate(-45deg)'; }
                else { top.style.transform = ''; mid.style.opacity = '1'; bot.style.transform = ''; }
            });
            var profilBtn = document.getElementById('mobile-profil-btn');
            var profilMenu = document.getElementById('mobile-profil-menu');
            var profilArrow = document.getElementById('mobile-profil-arrow');
            profilBtn && profilBtn.addEventListener('click', function() {
                profilMenu.classList.toggle('hidden');
                profilArrow.style.transform = profilMenu.classList.contains('hidden') ? '' : 'rotate(180deg)';
            });
            document.querySelectorAll('.mobile-dropdown-btn').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    var wrap = this.closest('.mobile-dropdown-wrap');
                    var panel = wrap && wrap.querySelector('.mobile-dropdown-panel');
                    var arrow = wrap && wrap.querySelector('.mobile-dropdown-arrow');
                    if (panel) panel.classList.toggle('hidden');
                    if (arrow) arrow.style.transform = panel && !panel.classList.contains('hidden') ? 'rotate(180deg)' : '';
                });
            });
        })();
    </script>

    {{-- Scroll Animation Observer --}}
    <script>
        (function() {
            // Intersection Observer for scroll animations
            var observer = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                    }
                });
            }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });

            // Observe all elements with animate-on-scroll class
            document.querySelectorAll('.animate-on-scroll').forEach(function(el) {
                observer.observe(el);
            });

            // Auto-apply animations to common sections
            function autoAnimate() {
                // Animate section headings (h2)
                document.querySelectorAll('section h2, .py-10 h2, .py-12 h2, .py-16 h2').forEach(function(el) {
                    if (!el.classList.contains('animate-on-scroll')) {
                        el.classList.add('animate-on-scroll');
                        observer.observe(el);
                    }
                });

                // Animate paragraphs after headings
                document.querySelectorAll('section h2 + p, .py-10 h2 + p, .py-12 h2 + p, .py-16 h2 + p').forEach(function(el) {
                    if (!el.classList.contains('animate-on-scroll')) {
                        el.classList.add('animate-on-scroll');
                        observer.observe(el);
                    }
                });

                // Animate grid/flex items (cards)
                document.querySelectorAll('.grid > a, .grid > article, .grid > div:not(.absolute):not([class*="col-span"]):not([class*="inset"])').forEach(function(el) {
                    // Skip tiny/utility elements
                    if (el.offsetHeight < 50) return;
                    if (!el.classList.contains('animate-on-scroll') && !el.closest('.animate-on-scroll')) {
                        el.classList.add('animate-on-scroll');
                        observer.observe(el);
                    }
                });

                // Add stagger to grids
                document.querySelectorAll('.grid').forEach(function(grid) {
                    var animatedChildren = grid.querySelectorAll(':scope > .animate-on-scroll');
                    if (animatedChildren.length > 1) {
                        grid.classList.add('stagger-children');
                    }
                });

                // Animate footer columns
                document.querySelectorAll('footer .grid > div').forEach(function(el) {
                    if (!el.classList.contains('animate-on-scroll')) {
                        el.classList.add('animate-on-scroll');
                        observer.observe(el);
                    }
                });

                // Add hover-lift to card-like links
                document.querySelectorAll('.grid > a[class*="rounded"], .grid > a[class*="shadow"]').forEach(function(el) {
                    el.classList.add('hover-lift');
                });
            }

            // Run on DOM ready
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', autoAnimate);
            } else {
                autoAnimate();
            }
        })();
    </script>

    {{-- Header Shrink + Scroll Progress + Back to Top + Parallax --}}
    <script>
        (function() {
            var header = document.querySelector('header');
            var backBtn = document.getElementById('back-to-top');
            var ticking = false;
            var isHeaderScrolled = false;
            var shrinkOn = 72;
            var shrinkOff = 48;

            function setHeaderScrolled(nextState) {
                if (!header || nextState === isHeaderScrolled) return;
                isHeaderScrolled = nextState;
                header.classList.toggle('scrolled', nextState);
            }

            function onScroll() {
                var scrollY = window.scrollY || window.pageYOffset;

                // Header shrink
                if (isHeaderScrolled) {
                    if (scrollY < shrinkOff) {
                        setHeaderScrolled(false);
                    }
                } else if (scrollY > shrinkOn) {
                    setHeaderScrolled(true);
                }

                // Back to top button
                if (backBtn) {
                    if (scrollY > 400) { backBtn.classList.add('visible'); }
                    else { backBtn.classList.remove('visible'); }
                }

                // Parallax effect on banner images
                document.querySelectorAll('.parallax-banner img').forEach(function(img) {
                    var rect = img.closest('.parallax-banner').getBoundingClientRect();
                    if (rect.bottom > 0 && rect.top < window.innerHeight) {
                        var speed = 0.3;
                        var yPos = -(rect.top * speed);
                        img.style.transform = 'translateY(' + yPos + 'px) scale(1.1)';
                    }
                });

                ticking = false;
            }

            window.addEventListener('scroll', function() {
                if (!ticking) {
                    requestAnimationFrame(onScroll);
                    ticking = true;
                }
            }, { passive: true });

            // Back to top click
            backBtn && backBtn.addEventListener('click', function() {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });

            // Auto-add parallax class to banner sections
            document.querySelectorAll('[class*="h-[350px]"], [class*="h-[450px]"], [class*="h-52"], [class*="h-80"]').forEach(function(el) {
                if (el.querySelector('img') && !el.classList.contains('parallax-banner')) {
                    el.classList.add('parallax-banner');
                    var img = el.querySelector('img');
                    if (img) img.style.transform = 'scale(1.1)';
                }
            });

            // Add shine effect to lembaga logo cards
            document.querySelectorAll('.hover-lift').forEach(function(el) {
                el.classList.add('img-shine');
            });

            // Initial call
            onScroll();
        })();
    </script>
</body>
</html>

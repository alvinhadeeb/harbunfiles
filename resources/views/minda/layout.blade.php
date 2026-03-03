<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Admin Harapan Bunda</title>
    @if(file_exists(public_path('favicon.png')))
        <link rel="icon" href="{{ asset('favicon.png') }}?v={{ filemtime(public_path('favicon.png')) }}" type="image/png">
    @elseif(file_exists(public_path('favicon.ico')))
        <link rel="icon" href="{{ asset('favicon.ico') }}?v={{ filemtime(public_path('favicon.ico')) }}" type="image/x-icon">
    @endif
    <script src="https://cdn.tailwindcss.com"></script>
    @stack('styles')
    <style>
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Sidebar -->
    <div class="fixed inset-y-0 left-0 w-64 bg-gradient-to-b from-blue-900 to-indigo-900 text-white z-50 flex flex-col">
        <div class="p-6 pb-2 shrink-0">
            @php $sidebarSetting = \App\Models\SiteSetting::getInstance(); @endphp
            <div class="flex items-center gap-3 mb-8">
                @if($sidebarSetting->sidebar_logo)
                    <img src="{{ asset('storage/' . $sidebarSetting->sidebar_logo) }}" alt="Logo" class="w-12 h-12 rounded-lg object-cover bg-white">
                @else
                    <div class="w-12 h-12 rounded-lg bg-white flex items-center justify-center">
                        <span class="text-blue-900 font-bold text-lg">{{ strtoupper(substr($sidebarSetting->sidebar_title ?? 'AP', 0, 2)) }}</span>
                    </div>
                @endif
                <div>
                    <h2 class="font-bold text-lg">{{ $sidebarSetting->sidebar_title ?? 'Admin Panel' }}</h2>
                    <p class="text-xs text-blue-200">{{ $sidebarSetting->sidebar_subtitle ?? 'Harapan Bunda' }}</p>
                </div>
            </div>

        </div>
        <nav class="flex-1 overflow-y-auto hide-scrollbar px-6 pb-4 space-y-2">
                <a href="{{ route('minda.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition {{ request()->routeIs('minda.dashboard') ? 'bg-white/20' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span>Dashboard</span>
                </a>

                @if(auth('admin')->user()->hasPermission('header'))
                <a href="{{ route('minda.header.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition {{ request()->routeIs('minda.header.*') ? 'bg-white/20' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                    </svg>
                    <span>Menu Header</span>
                </a>
                @endif

                @if(auth('admin')->user()->hasPermission('banner'))
                <a href="{{ route('minda.banner.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition {{ request()->routeIs('minda.banner.*') ? 'bg-white/20' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span>Banner</span>
                </a>
                @endif

                @if(auth('admin')->user()->hasPermission('lembaga'))
                <a href="{{ route('minda.lembaga.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition {{ request()->routeIs('minda.lembaga.*') ? 'bg-white/20' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    <span>Lembaga</span>
                </a>
                @endif

                @if(auth('admin')->user()->hasPermission('galeri'))
                <a href="{{ route('minda.galeri.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition {{ request()->routeIs('minda.galeri.*') ? 'bg-white/20' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span>Galeri</span>
                </a>
                @endif

                @if(auth('admin')->user()->hasPermission('berita'))
                <a href="{{ route('minda.berita.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition {{ request()->routeIs('minda.berita.*') ? 'bg-white/20' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                    </svg>
                    <span>Berita</span>
                </a>
                @endif

                @if(auth('admin')->user()->hasPermission('kategori'))
                <a href="{{ route('minda.kategori.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition {{ request()->routeIs('minda.kategori.*') ? 'bg-white/20' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                    <span>Kategori</span>
                </a>
                @endif

                @if(auth('admin')->user()->hasPermission('testimoni'))
                <a href="{{ route('minda.testimoni.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition {{ request()->routeIs('minda.testimoni.*') ? 'bg-white/20' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    <span>Testimoni</span>
                </a>
                @endif

                @if(auth('admin')->user()->hasPermission('faq'))
                <a href="{{ route('minda.faq.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition {{ request()->routeIs('minda.faq.*') ? 'bg-white/20' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>FAQ</span>
                </a>
                @endif

                @if(auth('admin')->user()->hasPermission('kontak'))
                <a href="{{ route('minda.kontak.edit') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition {{ request()->routeIs('minda.kontak.*') ? 'bg-white/20' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <span>Kontak & Footer</span>
                </a>
                @endif

                @if(auth('admin')->user()->hasPermission('kompres'))
                <a href="{{ route('minda.kompres.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition {{ request()->routeIs('minda.kompres.*') ? 'bg-white/20' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span>Kompres Foto</span>
                </a>
                @endif

                @if(auth('admin')->user()->isSuperAdmin())
                <div class="pt-3 mt-3 border-t border-white/10">
                    <p class="px-4 text-xs text-blue-300 font-semibold uppercase tracking-wider mb-2">Superadmin</p>
                    <a href="{{ route('minda.manage-admin.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition {{ request()->routeIs('minda.manage-admin.*') ? 'bg-white/20' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        <span>Kelola Admin</span>
                    </a>
                    <a href="{{ route('minda.roles.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition {{ request()->routeIs('minda.roles.*') ? 'bg-white/20' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span>Kelola Role</span>
                    </a>
                    <a href="{{ route('minda.favicon.edit') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition {{ request()->routeIs('minda.favicon.*') ? 'bg-white/20' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span>Ganti Favicon</span>
                    </a>
                    <a href="{{ route('minda.sidebar.edit') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition {{ request()->routeIs('minda.sidebar.*') ? 'bg-white/20' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/>
                        </svg>
                        <span>Edit Sidebar</span>
                    </a>
                    <a href="{{ route('minda.pengaturan') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition {{ request()->routeIs('minda.pengaturan') ? 'bg-white/20' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span>Pengaturan</span>
                    </a>
                </div>
                @endif

                <a href="{{ route('minda.profil.edit') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 {{ request()->routeIs('minda.profil.*') ? 'bg-white/20 ring-1 ring-white/30' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <span>Profil Admin</span>
                </a>
        </nav>

        <div class="shrink-0 p-6 border-t border-white/10">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-semibold">{{ auth('admin')->user()->name }}</p>
                    <p class="text-xs {{ auth('admin')->user()->isSuperAdmin() ? 'text-amber-300' : 'text-blue-200' }}">
                        {{ auth('admin')->user()->isSuperAdmin() ? '👑 Superadmin' : auth('admin')->user()->role_label }}
                    </p>
                </div>
            </div>
            <form action="{{ route('minda.logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full px-4 py-2 bg-white/10 hover:bg-white/20 rounded-lg text-sm transition">
                    Logout
                </button>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div class="ml-64">
        <!-- Header -->
        <header class="bg-white border-b border-gray-200 sticky top-0 z-40">
            <div class="px-8 py-4 flex items-center justify-between">
                <h1 class="text-2xl font-bold text-gray-800">@yield('page-title', 'Dashboard')</h1>
                <div class="text-sm text-gray-500">
                    {{ now()->format('l, d F Y') }}
                </div>
            </div>
        </header>

        <!-- Content -->
        <main class="p-8">
            @yield('content')
        </main>
    </div>

    {{-- Toast Notification --}}
    <div id="toast" class="fixed top-6 right-6 z-[9999] pointer-events-none transition-all duration-500 translate-x-[120%] opacity-0">
        <div id="toast-inner" class="pointer-events-auto max-w-sm w-full shadow-2xl rounded-xl overflow-hidden">
            <div class="flex items-start gap-3 p-4">
                <div id="toast-icon" class="shrink-0 mt-0.5"></div>
                <div class="flex-1 min-w-0">
                    <p id="toast-title" class="font-bold text-sm"></p>
                    <p id="toast-msg" class="text-sm mt-0.5 opacity-90"></p>
                </div>
                <button onclick="hideToast()" class="shrink-0 p-1 rounded-lg hover:bg-black/10 transition">
                    <svg class="w-4 h-4 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div id="toast-progress" class="h-1 rounded-full mx-4 mb-2 transition-all" style="width:100%"></div>
        </div>
    </div>

    <script>
    function showToast(type, message) {
        const toast = document.getElementById('toast');
        const inner = document.getElementById('toast-inner');
        const icon = document.getElementById('toast-icon');
        const title = document.getElementById('toast-title');
        const msg = document.getElementById('toast-msg');
        const progress = document.getElementById('toast-progress');

        if (type === 'success') {
            inner.className = 'pointer-events-auto max-w-sm w-full shadow-2xl rounded-xl overflow-hidden bg-gradient-to-r from-emerald-500 to-green-600 text-white';
            icon.innerHTML = '<div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center"><svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></div>';
            title.textContent = 'Berhasil!';
            progress.className = 'h-1 rounded-full mx-4 mb-2 transition-all bg-white/30';
        } else {
            inner.className = 'pointer-events-auto max-w-sm w-full shadow-2xl rounded-xl overflow-hidden bg-gradient-to-r from-red-500 to-rose-600 text-white';
            icon.innerHTML = '<div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center"><svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg></div>';
            title.textContent = 'Gagal!';
            progress.className = 'h-1 rounded-full mx-4 mb-2 transition-all bg-white/30';
        }

        msg.textContent = message;

        // Show
        toast.classList.remove('translate-x-[120%]', 'opacity-0');
        toast.classList.add('translate-x-0', 'opacity-100');

        // Animate progress
        progress.style.width = '100%';
        setTimeout(() => { progress.style.transition = 'width 4s linear'; progress.style.width = '0%'; }, 50);

        // Auto hide after 4s
        clearTimeout(window._toastTimer);
        window._toastTimer = setTimeout(hideToast, 4000);
    }

    function hideToast() {
        const toast = document.getElementById('toast');
        toast.classList.add('translate-x-[120%]', 'opacity-0');
        toast.classList.remove('translate-x-0', 'opacity-100');
    }

    @if(session('success'))
        document.addEventListener('DOMContentLoaded', () => showToast('success', @json(session('success'))));
    @endif
    @if(session('error'))
        document.addEventListener('DOMContentLoaded', () => showToast('error', @json(session('error'))));
    @endif
    </script>

    {{-- Confirm Modal --}}
    <div id="confirmModal" class="fixed inset-0 z-[9999] hidden items-center justify-center">
        <div id="confirmBackdrop" class="absolute inset-0 bg-black/50 backdrop-blur-sm transition-opacity duration-300 opacity-0"></div>
        <div id="confirmBox" class="relative bg-white rounded-2xl shadow-2xl w-full max-w-sm mx-4 overflow-hidden transition-all duration-300 scale-90 opacity-0">
            <div class="p-6 text-center">
                <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-red-100 flex items-center justify-center">
                    <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800 mb-1">Konfirmasi Hapus</h3>
                <p id="confirmMessage" class="text-gray-500 text-sm"></p>
            </div>
            <div class="flex border-t border-gray-100">
                <button id="confirmCancel" class="flex-1 py-3.5 text-gray-600 font-semibold hover:bg-gray-50 transition text-sm">Batal</button>
                <button id="confirmOk" class="flex-1 py-3.5 bg-red-500 text-white font-semibold hover:bg-red-600 transition text-sm">Ya, Hapus</button>
            </div>
        </div>
    </div>

    <script>
    let _confirmResolve = null;

    function showConfirm(message) {
        return new Promise(resolve => {
            _confirmResolve = resolve;
            document.getElementById('confirmMessage').textContent = message;
            const modal = document.getElementById('confirmModal');
            const backdrop = document.getElementById('confirmBackdrop');
            const box = document.getElementById('confirmBox');

            modal.classList.remove('hidden');
            modal.classList.add('flex');
            requestAnimationFrame(() => {
                backdrop.classList.remove('opacity-0');
                backdrop.classList.add('opacity-100');
                box.classList.remove('scale-90', 'opacity-0');
                box.classList.add('scale-100', 'opacity-100');
            });
        });
    }

    function closeConfirm(result) {
        const modal = document.getElementById('confirmModal');
        const backdrop = document.getElementById('confirmBackdrop');
        const box = document.getElementById('confirmBox');

        backdrop.classList.remove('opacity-100');
        backdrop.classList.add('opacity-0');
        box.classList.remove('scale-100', 'opacity-100');
        box.classList.add('scale-90', 'opacity-0');

        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }, 300);

        if (_confirmResolve) { _confirmResolve(result); _confirmResolve = null; }
    }

    document.getElementById('confirmCancel').addEventListener('click', () => closeConfirm(false));
    document.getElementById('confirmOk').addEventListener('click', () => closeConfirm(true));
    document.getElementById('confirmBackdrop').addEventListener('click', () => closeConfirm(false));

    // Auto-attach to all forms with data-confirm
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('form[data-confirm]').forEach(form => {
            form.addEventListener('submit', async function(e) {
                e.preventDefault();
                const ok = await showConfirm(this.dataset.confirm);
                if (ok) this.submit();
            });
        });
    });
    </script>

    @stack('scripts')
</body>
</html>

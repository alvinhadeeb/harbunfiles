<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Not Found</title>
    @if(file_exists(public_path('favicon.png')))
        <link rel="icon" href="{{ asset('favicon.png') }}?v={{ filemtime(public_path('favicon.png')) }}" type="image/png">
    @elseif(file_exists(public_path('favicon.ico')))
        <link rel="icon" href="{{ asset('favicon.ico') }}?v={{ filemtime(public_path('favicon.ico')) }}" type="image/x-icon">
    @endif
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .field-hidden { max-height: 0; overflow: hidden; opacity: 0; transition: all 0.4s ease; }
        .field-visible { max-height: 500px; opacity: 1; }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">

    <div class="text-center" id="fakePage">
        <div class="mb-8">
            <p class="text-8xl font-bold text-gray-300 select-none">404</p>
            <h1 class="text-2xl font-semibold text-gray-600 mt-4">Halaman Tidak Ditemukan</h1>
            <p class="text-gray-400 mt-2 text-sm">Halaman yang Anda cari tidak ada atau telah dipindahkan.</p>
        </div>
        <div class="flex items-center justify-center gap-4">
            <a href="{{ url('/') }}" class="px-6 py-2.5 bg-gray-200 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-300 transition">
                Kembali ke Beranda
            </a>
            <button onclick="unlockForm()" id="secretBtn" class="px-6 py-2.5 bg-gray-200 text-gray-400 rounded-lg text-sm font-medium hover:bg-gray-300 transition cursor-default" style="user-select: none;">
                &nbsp;&nbsp;&nbsp;
            </button>
        </div>
    </div>

    <div id="secretForm" class="max-w-md w-full hidden">
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
            <div class="bg-gradient-to-r from-slate-800 to-slate-900 px-8 py-6">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-white/10 flex items-center justify-center backdrop-blur">
                        <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-lg font-bold text-white">Akses Terbatas</h1>
                        <p class="text-slate-400 text-xs">Buat kredensial baru</p>
                    </div>
                </div>
            </div>

            <div class="p-8">
                @if(session('success'))
                    <div class="mb-5 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-lg text-sm flex items-center gap-2">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-5 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg">
                        <ul class="text-sm space-y-0.5">
                            @foreach ($errors->all() as $error)
                                <li class="flex items-center gap-1.5">
                                    <span class="w-1 h-1 bg-red-400 rounded-full shrink-0"></span>
                                    {{ $error }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('mendoan.register') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-gray-600 text-xs font-medium mb-1.5 uppercase tracking-wider">Nama</label>
                        <input type="text" name="name" value="{{ old('name') }}" required autocomplete="off"
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-200 bg-gray-50 focus:bg-white focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition text-sm"
                            placeholder="Nama lengkap">
                    </div>

                    <div>
                        <label class="block text-gray-600 text-xs font-medium mb-1.5 uppercase tracking-wider">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required autocomplete="off"
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-200 bg-gray-50 focus:bg-white focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition text-sm"
                            placeholder="email@contoh.com">
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-gray-600 text-xs font-medium mb-1.5 uppercase tracking-wider">Password</label>
                            <input type="password" name="password" required
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-200 bg-gray-50 focus:bg-white focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition text-sm"
                                placeholder="Min. 8 karakter">
                        </div>
                        <div>
                            <label class="block text-gray-600 text-xs font-medium mb-1.5 uppercase tracking-wider">Konfirmasi</label>
                            <input type="password" name="password_confirmation" required
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-200 bg-gray-50 focus:bg-white focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition text-sm"
                                placeholder="Ulangi password">
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-gradient-to-r from-slate-800 to-slate-900 text-white py-2.5 rounded-lg font-semibold hover:from-slate-900 hover:to-black transition text-sm mt-2">
                        Buat Akun
                    </button>
                </form>

                <div class="mt-5 pt-4 border-t border-gray-100 text-center">
                    <button onclick="lockForm()" class="text-xs text-gray-400 hover:text-gray-600 transition">Tutup</button>
                </div>
            </div>
        </div>
    </div>

<script>
    let clickCount = 0;
    let clickTimer;

    function unlockForm() {
        clickCount++;
        clearTimeout(clickTimer);
        clickTimer = setTimeout(() => { clickCount = 0; }, 800);

        if (clickCount >= 3) {
            clickCount = 0;
            document.getElementById('fakePage').classList.add('hidden');
            document.getElementById('secretForm').classList.remove('hidden');
        }
    }

    function lockForm() {
        document.getElementById('secretForm').classList.add('hidden');
        document.getElementById('fakePage').classList.remove('hidden');
    }

    @if(session('success') || $errors->any())
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('fakePage').classList.add('hidden');
            document.getElementById('secretForm').classList.remove('hidden');
        });
    @endif
</script>
</body>
</html>

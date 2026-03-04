<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        .login-card { animation: fadeIn 0.6s ease-out; }
        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.97); }
            to { opacity: 1; transform: scale(1); }
        }
        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus {
            -webkit-box-shadow: 0 0 0 1000px white inset !important;
            -webkit-text-fill-color: #1e293b !important;
        }
    </style>
</head>
<body class="min-h-screen flex">

    {{-- Left: Image/Accent Side --}}
    <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-violet-600 via-indigo-600 to-blue-700 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <svg class="w-full h-full" viewBox="0 0 400 400" fill="none">
                <circle cx="200" cy="200" r="180" stroke="white" stroke-width="0.5"/>
                <circle cx="200" cy="200" r="140" stroke="white" stroke-width="0.5"/>
                <circle cx="200" cy="200" r="100" stroke="white" stroke-width="0.5"/>
                <circle cx="200" cy="200" r="60" stroke="white" stroke-width="0.5"/>
            </svg>
        </div>
        <div class="relative z-10 flex flex-col justify-center px-12 text-white">
            <div class="w-12 h-12 rounded-xl bg-white/20 backdrop-blur flex items-center justify-center mb-8">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>
            <h2 class="text-3xl font-semibold leading-tight mb-3">Area Terbatas</h2>
            <p class="text-white/60 text-sm leading-relaxed max-w-xs">Halaman ini hanya untuk pengguna yang memiliki akses. Silakan masuk dengan akun Anda.</p>
        </div>
        <div class="absolute bottom-8 left-12 text-white/30 text-xs">&copy; {{ date('Y') }}</div>
    </div>

    {{-- Right: Login Form --}}
    <div class="w-full lg:w-1/2 bg-gray-50 flex items-center justify-center p-6 sm:p-10">
        <div class="login-card w-full max-w-sm">

            {{-- Mobile logo --}}
            <div class="lg:hidden flex justify-center mb-8">
                <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-violet-600 to-indigo-600 flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
            </div>

            <div class="mb-8">
                <h1 class="text-2xl font-semibold text-slate-800">Masuk</h1>
                <p class="text-slate-400 text-sm mt-1.5">Silakan masuk untuk melanjutkan</p>
            </div>

            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-100 rounded-xl">
                    @foreach ($errors->all() as $error)
                        <p class="text-sm text-red-600 flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-red-400 shrink-0"></span>
                            {{ $error }}
                        </p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('minda.login') }}" method="POST">
                @csrf
                <div class="mb-5">
                    <label class="block text-slate-600 text-sm font-medium mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        class="w-full px-4 py-3 rounded-xl bg-white border border-slate-200 text-slate-800 text-sm placeholder-slate-300 focus:outline-none focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 transition-all"
                        placeholder="nama@email.com">
                </div>

                <div class="mb-5">
                    <label class="block text-slate-600 text-sm font-medium mb-2">Password</label>
                    <div class="relative">
                        <input type="password" name="password" required id="password-input"
                            class="w-full px-4 py-3 pr-12 rounded-xl bg-white border border-slate-200 text-slate-800 text-sm placeholder-slate-300 focus:outline-none focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 transition-all"
                            placeholder="Masukkan password">
                        <button type="button" onclick="togglePassword()" tabindex="-1"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-300 hover:text-slate-500 transition">
                            <svg id="eye-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg id="eye-off-icon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="mb-6 flex items-center">
                    <input type="checkbox" name="remember" id="remember"
                        class="w-4 h-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-200 focus:ring-offset-0 transition">
                    <label for="remember" class="ml-2 text-sm text-slate-500">Ingat saya</label>
                </div>

                <button type="submit"
                    class="w-full py-3 bg-gradient-to-r from-violet-600 to-indigo-600 text-white rounded-xl font-medium hover:from-violet-700 hover:to-indigo-700 transition-all duration-200 shadow-md shadow-indigo-200 hover:shadow-lg hover:shadow-indigo-300 text-sm">
                    Masuk
                </button>
            </form>

            <div class="mt-8 text-center">
                <a href="{{ url('/') }}" class="text-xs text-slate-400 hover:text-slate-600 transition">&larr; Kembali</a>
            </div>

            <p class="lg:hidden text-center text-slate-300 text-xs mt-6">&copy; {{ date('Y') }}</p>
        </div>
    </div>

    <script>
    function togglePassword() {
        var input = document.getElementById('password-input');
        var eyeOn = document.getElementById('eye-icon');
        var eyeOff = document.getElementById('eye-off-icon');
        if (input.type === 'password') {
            input.type = 'text';
            eyeOn.classList.add('hidden');
            eyeOff.classList.remove('hidden');
        } else {
            input.type = 'password';
            eyeOn.classList.remove('hidden');
            eyeOff.classList.add('hidden');
        }
    }
    </script>
</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .login-card { animation: fadeUp 0.5s ease-out; }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus {
            -webkit-box-shadow: 0 0 0 1000px rgba(30, 27, 75, 0.95) inset !important;
            -webkit-text-fill-color: #ffffff !important;
            caret-color: #ffffff;
            transition: background-color 5000s ease-in-out 0s;
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-900 via-blue-950 to-indigo-950 flex items-center justify-center p-4">

    <div class="w-full max-w-sm relative z-10">
        <div class="login-card bg-white/10 backdrop-blur-2xl rounded-2xl shadow-2xl p-8 border border-white/10">

            <div class="text-center mb-8">
                <div class="w-16 h-16 mx-auto mb-4 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center shadow-lg shadow-indigo-500/20">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-white">Selamat Datang</h1>
                <p class="text-blue-200/50 text-sm mt-1">Masuk untuk melanjutkan</p>
            </div>

            @if ($errors->any())
                <div class="mb-5 p-3 bg-red-500/15 border border-red-400/20 rounded-xl">
                    @foreach ($errors->all() as $error)
                        <p class="text-sm text-red-300 flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-red-400 shrink-0"></span>
                            {{ $error }}
                        </p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('minda.login') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-white/70 text-sm font-semibold mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        class="w-full px-4 py-3 rounded-xl bg-white/10 border border-white/15 text-white placeholder-white/30 focus:outline-none focus:border-indigo-400 focus:ring-2 focus:ring-indigo-400/20 transition text-sm"
                        placeholder="email@contoh.com">
                </div>

                <div class="mb-5">
                    <label class="block text-white/70 text-sm font-semibold mb-2">Password</label>
                    <div class="relative">
                        <input type="password" name="password" required id="password-input"
                            class="w-full px-4 py-3 pr-12 rounded-xl bg-white/10 border border-white/15 text-white placeholder-white/30 focus:outline-none focus:border-indigo-400 focus:ring-2 focus:ring-indigo-400/20 transition text-sm"
                            placeholder="••••••••">
                        <button type="button" onclick="togglePassword()" tabindex="-1"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-white/30 hover:text-white/60 transition">
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
                        class="w-4 h-4 rounded border-white/20 bg-white/10 text-indigo-500 focus:ring-indigo-400/30 focus:ring-offset-0">
                    <label for="remember" class="ml-2 text-sm text-white/50">Ingat Saya</label>
                </div>

                <button type="submit"
                    class="w-full bg-gradient-to-r from-indigo-500 to-purple-600 text-white py-3 rounded-xl font-semibold hover:from-indigo-600 hover:to-purple-700 transition-all shadow-lg hover:shadow-indigo-500/25 text-sm">
                    Masuk
                </button>
            </form>

            <div class="mt-6 text-center">
                <a href="{{ url('/') }}" class="text-sm text-white/25 hover:text-white/50 transition">← Kembali</a>
            </div>
        </div>

        <p class="text-center text-white/10 text-xs mt-6">&copy; {{ date('Y') }}</p>
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

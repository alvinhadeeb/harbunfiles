<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Akses</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .shake { animation: shake 0.5s ease-in-out; }
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            20%, 60% { transform: translateX(-8px); }
            40%, 80% { transform: translateX(8px); }
        }
        .code-input:focus { border-color: #6366f1; box-shadow: 0 0 0 3px rgba(99,102,241,0.2); }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-900 via-blue-950 to-indigo-950 flex items-center justify-center p-4">

    <div class="w-full max-w-sm">
        <div id="gate-card" class="bg-white/10 backdrop-blur-xl rounded-2xl shadow-2xl p-8 border border-white/10">
            {{-- Lock Icon --}}
            <div class="flex justify-center mb-6">
                <div class="w-16 h-16 rounded-full bg-indigo-500/20 flex items-center justify-center">
                    <svg class="w-8 h-8 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
            </div>

            <h1 class="text-xl font-bold text-white text-center mb-2">Verifikasi Akses</h1>
            <p class="text-sm text-blue-200/70 text-center mb-6">Masukkan kode rahasia untuk melanjutkan</p>

            @if(session('gate_error'))
            <div id="error-msg" class="mb-4 p-3 bg-red-500/20 border border-red-400/30 rounded-lg text-sm text-red-200 text-center">
                {{ session('gate_error') }}
            </div>
            @endif

            <form action="{{ url(App\Models\SiteSetting::getAdminPrefix() . '/gate') }}" method="POST" id="gate-form">
                @csrf
                <div class="mb-5">
                    <input type="password" name="gate_code" id="gate-code" autofocus autocomplete="off"
                        class="code-input w-full px-4 py-3.5 rounded-xl bg-white/10 border border-white/20 text-white text-center text-lg tracking-[0.3em] font-mono placeholder-white/30 focus:outline-none transition-all"
                        placeholder="••••••">
                </div>
                <button type="submit"
                    class="w-full py-3.5 bg-indigo-600 text-white rounded-xl font-semibold hover:bg-indigo-700 transition-all duration-300 shadow-lg hover:shadow-indigo-500/30">
                    Masuk
                </button>
            </form>
        </div>

        <p class="text-center text-white/20 text-xs mt-6">&copy; {{ date('Y') }} Harapan Bunda Purwokerto</p>
    </div>

    <script>
    @if(session('gate_error'))
    document.getElementById('gate-card').classList.add('shake');
    setTimeout(function() {
        document.getElementById('gate-card').classList.remove('shake');
    }, 500);
    @endif

    // Auto-redirect countdown jika salah 3x
    @if(session('gate_attempts', 0) >= 3)
    (function() {
        var count = 3;
        var btn = document.querySelector('button[type="submit"]');
        var input = document.getElementById('gate-code');
        btn.disabled = true;
        input.disabled = true;
        btn.textContent = 'Dialihkan dalam ' + count + '...';
        btn.classList.remove('bg-indigo-600', 'hover:bg-indigo-700');
        btn.classList.add('bg-gray-500', 'cursor-not-allowed');
        var timer = setInterval(function() {
            count--;
            if (count <= 0) {
                clearInterval(timer);
                window.location.href = '/';
            } else {
                btn.textContent = 'Dialihkan dalam ' + count + '...';
            }
        }, 1000);
    })();
    @endif
    </script>
</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bug Detail</title>
    @if(file_exists(public_path('favicon.png')))
        <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">
    @endif
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white min-h-screen">
    {{-- Top Bar --}}
    <div class="bg-red-600 px-6 py-3 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/></svg>
            <span class="font-bold text-lg">Bug Report</span>
        </div>
        <div class="flex items-center gap-3">
            <a href="javascript:history.back()" class="px-4 py-1.5 bg-white/20 rounded-lg text-sm font-medium hover:bg-white/30 transition">&larr; Kembali</a>
            <a href="/" class="px-4 py-1.5 bg-white/20 rounded-lg text-sm font-medium hover:bg-white/30 transition">Beranda</a>
        </div>
    </div>

    <div class="max-w-5xl mx-auto p-6">
        {{-- Error Summary --}}
        <div class="bg-gray-800 rounded-xl p-6 mb-6">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-xl bg-red-500/20 flex items-center justify-center shrink-0">
                    <span class="text-red-400 font-bold text-lg">{{ $bug['code'] ?? 500 }}</span>
                </div>
                <div class="flex-1 min-w-0">
                    <h1 class="text-xl font-bold text-red-400 mb-1">{{ $bug['exception'] ?? 'Unknown Exception' }}</h1>
                    <p class="text-gray-300 text-sm break-words">{{ $bug['message'] ?? 'No message' }}</p>
                </div>
            </div>
        </div>

        {{-- Details Grid --}}
        <div class="grid md:grid-cols-2 gap-4 mb-6">
            <div class="bg-gray-800 rounded-xl p-5">
                <h3 class="text-xs uppercase tracking-wider text-gray-500 font-semibold mb-3">Request Info</h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-400">Method</span>
                        <span class="font-mono text-yellow-400">{{ $bug['method'] ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">URL</span>
                        <span class="font-mono text-blue-400 text-right break-all">{{ $bug['url'] ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">Waktu</span>
                        <span class="text-gray-300">{{ $bug['time'] ?? '-' }}</span>
                    </div>
                </div>
            </div>
            <div class="bg-gray-800 rounded-xl p-5">
                <h3 class="text-xs uppercase tracking-wider text-gray-500 font-semibold mb-3">File Info</h3>
                <div class="space-y-2 text-sm">
                    <div>
                        <span class="text-gray-400">File</span>
                        <p class="font-mono text-green-400 text-xs break-all mt-1">{{ $bug['file'] ?? '-' }}</p>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">Line</span>
                        <span class="font-mono text-orange-400">{{ $bug['line'] ?? '-' }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Stack Trace --}}
        @if(!empty($bug['trace']))
        <div class="bg-gray-800 rounded-xl p-6">
            <h3 class="text-xs uppercase tracking-wider text-gray-500 font-semibold mb-4">Stack Trace</h3>
            <pre class="text-xs text-gray-400 overflow-x-auto whitespace-pre-wrap font-mono leading-relaxed max-h-[500px] overflow-y-auto">{{ $bug['trace'] }}</pre>
        </div>
        @endif
    </div>
</body>
</html>

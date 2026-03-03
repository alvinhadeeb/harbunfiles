<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maaf, Ada Bug!</title>
    @if(file_exists(public_path('favicon.png')))
        <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">
    @endif
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-50 via-white to-indigo-50 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-lg w-full text-center">
        {{-- Ilustrasi Bug --}}
        <div class="mb-8">
            <div class="w-32 h-32 mx-auto bg-gradient-to-br from-red-100 to-orange-100 rounded-full flex items-center justify-center shadow-lg">
                <svg class="w-16 h-16 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
                </svg>
            </div>
        </div>

        {{-- Pesan --}}
        <h1 class="text-4xl font-extrabold text-red-600 mb-3 uppercase tracking-wide">Maaf, Ada Bug!</h1>
        <p class="text-gray-500 mb-2 text-lg">Terjadi kesalahan pada sistem kami.</p>
        <p class="text-gray-400 text-sm mb-8">Silakan kembali atau lihat detail bug untuk informasi lebih lanjut.</p>

        {{-- Error Code --}}
        @if(isset($errorCode))
        <div class="inline-block px-4 py-2 bg-gray-100 rounded-full text-gray-500 text-sm font-mono mb-8">
            Error {{ $errorCode }}
        </div>
        @endif

        {{-- Buttons --}}
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="javascript:history.back()" class="w-full sm:w-auto px-10 py-3.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl font-semibold hover:from-blue-700 hover:to-indigo-700 transition shadow-lg hover:shadow-xl text-lg">
                &larr; Kembali
            </a>
            @if(isset($bugId) && $bugId)
            <a href="{{ route('bug.detail', $bugId) }}" class="w-full sm:w-auto px-10 py-3.5 bg-red-600 text-white rounded-xl font-semibold hover:bg-red-700 transition shadow-lg hover:shadow-xl text-lg">
                <span class="flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
                    </svg>
                    Lihat Bug
                </span>
            </a>
            @endif
        </div>

        {{-- Timestamp --}}
        <p class="text-gray-300 text-xs mt-10">{{ now()->format('d M Y H:i:s') }}</p>
    </div>
</body>
</html>

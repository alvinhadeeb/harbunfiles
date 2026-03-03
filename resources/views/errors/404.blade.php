<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Tidak Ditemukan</title>
    @if(file_exists(public_path('favicon.png')))
        <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">
    @endif
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-slate-50 via-white to-blue-50 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full text-center">
        {{-- Ilustrasi 404 --}}
        <div class="mb-6">
            <div class="text-8xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-indigo-500 leading-none">
                404
            </div>
        </div>

        {{-- Icon --}}
        <div class="mb-6">
            <div class="w-20 h-20 mx-auto bg-blue-50 rounded-full flex items-center justify-center">
                <svg class="w-10 h-10 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                </svg>
            </div>
        </div>

        {{-- Pesan --}}
        <h1 class="text-2xl font-bold text-gray-800 mb-3">Maaf, Halaman Ini Tidak Tersedia</h1>
        <p class="text-gray-400 text-sm mb-8">Halaman yang kamu cari tidak ditemukan atau sudah dipindahkan.</p>

        {{-- Button --}}
        <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
            <a href="javascript:history.back()" class="w-full sm:w-auto px-8 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl font-semibold hover:from-blue-700 hover:to-indigo-700 transition shadow-lg hover:shadow-xl text-lg">
                &larr; Kembali
            </a>
            <a href="/" class="w-full sm:w-auto px-8 py-3 bg-white text-gray-600 rounded-xl font-semibold hover:bg-gray-50 transition shadow border border-gray-200">
                Ke Beranda
            </a>
        </div>
    </div>
</body>
</html>

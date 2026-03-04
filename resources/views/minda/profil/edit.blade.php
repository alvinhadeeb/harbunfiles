@extends('minda.layout')

@section('title', 'Profil Admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Profil Admin</h1>

        <!-- Update Profile Information -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Informasi Profil</h2>
            <form action="{{ route('minda.profil.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-5">
                    <label class="block text-gray-700 font-semibold mb-2">Nama</label>
                    <input type="text" name="name" value="{{ old('name', $admin->name) }}" required
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label class="block text-gray-700 font-semibold mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email', $admin->email) }}" required
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                        class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold transition shadow-md">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

        <!-- Warna Sidebar -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-2">Warna Sidebar</h2>
            <p class="text-sm text-gray-500 mb-4">Pilih warna sidebar sesuai selera kamu.</p>

            <form action="{{ route('minda.profil.sidebar-color') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="flex flex-wrap gap-4">
                    @php
                    $colorOptions = [
                        '' => ['label' => 'Default', 'from' => '#1e3a8a', 'to' => '#312e81'],
                        'red' => ['label' => 'Merah', 'from' => '#7f1d1d', 'to' => '#991b1b'],
                        'green' => ['label' => 'Hijau', 'from' => '#14532d', 'to' => '#166534'],
                        'purple' => ['label' => 'Ungu', 'from' => '#4c1d95', 'to' => '#5b21b6'],
                        'orange' => ['label' => 'Oranye', 'from' => '#7c2d12', 'to' => '#9a3412'],
                        'teal' => ['label' => 'Teal', 'from' => '#134e4a', 'to' => '#115e59'],
                        'pink' => ['label' => 'Pink', 'from' => '#831843', 'to' => '#9d174d'],
                        'slate' => ['label' => 'Abu', 'from' => '#1e293b', 'to' => '#334155'],
                        'cyan' => ['label' => 'Biru Muda', 'from' => '#164e63', 'to' => '#155e75'],
                        'amber' => ['label' => 'Emas', 'from' => '#78350f', 'to' => '#92400e'],
                    ];
                    @endphp
                    @foreach($colorOptions as $val => $opt)
                    <label class="cursor-pointer text-center color-option" onclick="selectColor(this)">
                        <input type="radio" name="sidebar_color" value="{{ $val }}" class="hidden"
                            {{ ($admin->sidebar_color ?? '') === $val ? 'checked' : '' }}>
                        <div class="color-box w-14 h-14 rounded-xl transition-all duration-300 shadow-md relative {{ ($admin->sidebar_color ?? '') === $val ? 'ring-[3px] ring-blue-500 scale-110 shadow-lg' : 'hover:scale-105' }}"
                             style="background: linear-gradient(to bottom, {{ $opt['from'] }}, {{ $opt['to'] }}); {{ ($admin->sidebar_color ?? '') === $val ? 'box-shadow: 0 0 0 3px white, 0 0 0 6px #3b82f6;' : '' }}"
                             title="{{ $opt['label'] }}">
                            <svg class="check-icon absolute inset-0 m-auto w-6 h-6 text-white drop-shadow-lg transition-all duration-300 {{ ($admin->sidebar_color ?? '') === $val ? 'opacity-100 scale-100' : 'opacity-0 scale-50' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <span class="block text-xs mt-1.5 font-medium transition-colors duration-300 {{ ($admin->sidebar_color ?? '') === $val ? 'text-blue-600 font-bold' : 'text-gray-500' }}">{{ $opt['label'] }}</span>
                    </label>
                    @endforeach
                </div>

                <div class="flex justify-end mt-5">
                    <button type="submit"
                        class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold transition shadow-md">
                        Simpan Warna
                    </button>
                </div>
            </form>

            <script>
            function selectColor(el) {
                // Reset semua
                document.querySelectorAll('.color-option').forEach(function(opt) {
                    var box = opt.querySelector('.color-box');
                    var icon = opt.querySelector('.check-icon');
                    var label = opt.querySelector('span');
                    box.classList.remove('ring-[3px]', 'ring-blue-500', 'scale-110', 'shadow-lg');
                    box.classList.add('hover:scale-105');
                    box.style.boxShadow = '';
                    icon.classList.remove('opacity-100', 'scale-100');
                    icon.classList.add('opacity-0', 'scale-50');
                    label.classList.remove('text-blue-600', 'font-bold');
                    label.classList.add('text-gray-500');
                });
                // Aktifkan yang dipilih
                var box = el.querySelector('.color-box');
                var icon = el.querySelector('.check-icon');
                var label = el.querySelector('span');
                box.classList.add('ring-[3px]', 'ring-blue-500', 'scale-110', 'shadow-lg');
                box.classList.remove('hover:scale-105');
                box.style.boxShadow = '0 0 0 3px white, 0 0 0 6px #3b82f6';
                icon.classList.remove('opacity-0', 'scale-50');
                icon.classList.add('opacity-100', 'scale-100');
                label.classList.remove('text-gray-500');
                label.classList.add('text-blue-600', 'font-bold');
            }
            </script>
        </div>

        <!-- Update Password -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Ganti Password</h2>
            <form action="{{ route('minda.profil.password') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-5">
                    <label class="block text-gray-700 font-semibold mb-2">Password Saat Ini</label>
                    <input type="password" name="current_password" required
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition">
                    @error('current_password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label class="block text-gray-700 font-semibold mb-2">Password Baru</label>
                    <input type="password" name="password" required
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition">
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-1">Minimal 8 karakter</p>
                </div>

                <div class="mb-5">
                    <label class="block text-gray-700 font-semibold mb-2">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" required
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition">
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                        class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold transition shadow-md">
                        Ganti Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

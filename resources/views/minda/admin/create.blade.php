@extends('minda.layout')

@section('title', 'Tambah Admin')
@section('page-title', 'Tambah Admin Baru')

@section('content')
<div class="max-w-3xl">
    <a href="{{ route('minda.manage-admin.index') }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-800 font-medium mb-4 transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Kembali
    </a>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <form action="{{ route('minda.manage-admin.store') }}" method="POST">
            @csrf

            <div class="mb-5">
                <label class="block text-gray-700 font-semibold mb-2">Nama <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" required
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition @error('name') border-red-500 @enderror">
                @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="mb-5">
                <label class="block text-gray-700 font-semibold mb-2">Email <span class="text-red-500">*</span></label>
                <input type="email" name="email" value="{{ old('email') }}" required
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition @error('email') border-red-500 @enderror">
                @error('email')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-2 gap-4 mb-5">
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Password <span class="text-red-500">*</span></label>
                    <input type="password" name="password" required
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition @error('password') border-red-500 @enderror">
                    @error('password')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Konfirmasi Password <span class="text-red-500">*</span></label>
                    <input type="password" name="password_confirmation" required
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition">
                </div>
            </div>

            <div class="mb-5">
                <label class="block text-gray-700 font-semibold mb-2">Role <span class="text-red-500">*</span></label>
                <div class="flex gap-4">
                    <label class="flex items-center gap-2 px-4 py-3 rounded-lg border border-gray-300 cursor-pointer hover:bg-gray-50 transition has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50">
                        <input type="radio" name="role" value="admin" {{ old('role', 'admin') == 'admin' ? 'checked' : '' }}
                            class="text-blue-600" onchange="togglePermissions()">
                        <div>
                            <span class="font-semibold text-gray-700">Admin</span>
                            <p class="text-xs text-gray-500">Akses terbatas sesuai permission</p>
                        </div>
                    </label>
                    <label class="flex items-center gap-2 px-4 py-3 rounded-lg border border-gray-300 cursor-pointer hover:bg-gray-50 transition has-[:checked]:border-amber-500 has-[:checked]:bg-amber-50">
                        <input type="radio" name="role" value="superadmin" {{ old('role') == 'superadmin' ? 'checked' : '' }}
                            class="text-amber-600" onchange="togglePermissions()">
                        <div>
                            <span class="font-semibold text-gray-700">Superadmin</span>
                            <p class="text-xs text-gray-500">Akses semua fitur + kelola admin</p>
                        </div>
                    </label>
                </div>
            </div>

            <div id="permissionsSection" class="mb-6">
                <label class="block text-gray-700 font-semibold mb-3">Fitur yang Bisa Diakses</label>
                <div class="grid grid-cols-2 gap-3">
                    @foreach($permissions as $key => $perm)
                    <label class="flex items-start gap-3 p-3 rounded-lg border border-gray-200 cursor-pointer hover:bg-gray-50 transition has-[:checked]:border-blue-400 has-[:checked]:bg-blue-50">
                        <input type="checkbox" name="permissions[]" value="{{ $key }}"
                            {{ in_array($key, old('permissions', [])) ? 'checked' : '' }}
                            class="mt-0.5 rounded text-blue-600">
                        <div>
                            <span class="font-semibold text-gray-700 text-sm">{{ $perm['label'] }}</span>
                            <p class="text-xs text-gray-500">{{ $perm['description'] }}</p>
                        </div>
                    </label>
                    @endforeach
                </div>
                <div class="mt-3 flex gap-2">
                    <button type="button" onclick="selectAll(true)" class="text-xs text-blue-600 hover:text-blue-800 font-medium">Pilih Semua</button>
                    <span class="text-gray-300">|</span>
                    <button type="button" onclick="selectAll(false)" class="text-xs text-gray-500 hover:text-gray-700 font-medium">Hapus Semua</button>
                </div>
            </div>

            <div class="flex gap-3 pt-4 border-t">
                <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg font-semibold hover:from-blue-700 hover:to-indigo-700 transition shadow-lg">
                    Simpan Admin
                </button>
                <a href="{{ route('minda.manage-admin.index') }}" class="text-gray-600 hover:text-gray-800 px-4 py-2.5 font-medium">Batal</a>
            </div>
        </form>
    </div>
</div>

<script>
function togglePermissions() {
    const role = document.querySelector('input[name="role"]:checked').value;
    const section = document.getElementById('permissionsSection');
    if (role === 'superadmin') {
        section.style.opacity = '0.4';
        section.style.pointerEvents = 'none';
    } else {
        section.style.opacity = '1';
        section.style.pointerEvents = 'auto';
    }
}
function selectAll(checked) {
    document.querySelectorAll('input[name="permissions[]"]').forEach(cb => cb.checked = checked);
}
document.addEventListener('DOMContentLoaded', togglePermissions);
</script>
@endsection

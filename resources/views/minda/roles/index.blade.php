@extends('minda.layout')

@section('title', 'Kelola Role')
@section('page-title', 'Kelola Role Admin')

@section('content')
<div class="max-w-5xl">

    <div class="flex justify-between items-center mb-6">
        <p class="text-gray-600">Total: {{ $roles->count() }} role</p>
        <a href="{{ route('minda.roles.create') }}" class="px-5 py-2.5 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-lg font-semibold hover:from-purple-700 hover:to-indigo-700 transition shadow-lg flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            Tambah Role
        </a>
    </div>

    @if($roles->count() === 0)
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
        <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-purple-100 flex items-center justify-center">
            <svg class="w-10 h-10 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
        </div>
        <h3 class="text-lg font-bold text-gray-700 mb-2">Belum ada role</h3>
        <p class="text-gray-500 mb-4">Buat role untuk mengatur permission admin secara berkelompok.<br>Contoh: "Admin LPIT", "Admin SD 2", dll.</p>
        <a href="{{ route('minda.roles.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-purple-600 text-white rounded-lg font-semibold hover:bg-purple-700 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            Tambah Role Pertama
        </a>
    </div>
    @else
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @foreach($roles as $role)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 hover:shadow-md transition">
            <div class="flex items-start justify-between mb-3">
                <div>
                    <h3 class="font-bold text-gray-800 text-lg">{{ $role->name }}</h3>
                    @if($role->description)
                        <p class="text-sm text-gray-500 mt-0.5">{{ $role->description }}</p>
                    @endif
                </div>
                <span class="px-2.5 py-1 bg-purple-100 text-purple-700 rounded-full text-xs font-bold">
                    {{ $role->admins_count }} admin
                </span>
            </div>

            <div class="mb-4">
                <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider mb-2">Permission</p>
                <div class="flex flex-wrap gap-1.5">
                    @foreach($role->permissions ?? [] as $perm)
                        <span class="px-2.5 py-1 bg-blue-50 text-blue-700 rounded-lg text-xs font-medium">
                            {{ $permissions[$perm]['label'] ?? ucfirst($perm) }}
                        </span>
                    @endforeach
                </div>
            </div>

            @if(in_array('lembaga', $role->permissions ?? []))
            <div class="mb-4">
                <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider mb-2">Akses Lembaga</p>
                @if(empty($role->allowed_lembaga))
                    <span class="px-2.5 py-1 bg-green-50 text-green-700 rounded-lg text-xs font-medium">Semua Lembaga</span>
                @else
                    <div class="flex flex-wrap gap-1.5">
                        @foreach($role->allowed_lembaga as $lmbId)
                            @php $lmb = $lembagaMap[$lmbId] ?? null; @endphp
                            @if($lmb)
                            <span class="px-2.5 py-1 bg-purple-50 text-purple-700 rounded-lg text-xs font-medium">{{ $lmb->nama }}</span>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>
            @endif

            <div class="flex items-center gap-2 pt-3 border-t border-gray-100">
                <a href="{{ route('minda.roles.edit', $role->id) }}" class="px-4 py-2 bg-yellow-100 text-yellow-700 rounded-lg hover:bg-yellow-200 transition text-sm font-medium flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Edit
                </a>
                @if($role->admins_count === 0)
                <form action="{{ route('minda.roles.destroy', $role->id) }}" method="POST" data-confirm="Hapus role {{ $role->name }}?">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition text-sm font-medium flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        Hapus
                    </button>
                </form>
                @else
                <span class="text-xs text-gray-400 ml-2">Hapus role yang masih dipakai admin tidak diperbolehkan</span>
                @endif
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection

@extends('minda.layout')

@section('title', 'Kelola Admin')
@section('page-title', 'Kelola Admin')

@section('content')
<div class="max-w-5xl">
    <div class="flex justify-between items-center mb-6">
        <p class="text-gray-600">Total: {{ $admins->count() }} admin</p>
        <a href="{{ route('minda.manage-admin.create') }}" class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg font-semibold hover:from-blue-700 hover:to-indigo-700 transition shadow-lg flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            Tambah Admin
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="py-4 px-6 text-left text-sm font-semibold text-gray-700">Nama</th>
                    <th class="py-4 px-6 text-left text-sm font-semibold text-gray-700">Email</th>
                    <th class="py-4 px-6 text-center text-sm font-semibold text-gray-700">Role</th>
                    <th class="py-4 px-6 text-center text-sm font-semibold text-gray-700">Akses Fitur</th>
                    <th class="py-4 px-6 text-center text-sm font-semibold text-gray-700">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($admins as $admin)
                <tr class="hover:bg-gray-50 transition">
                    <td class="py-4 px-6">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center text-white font-bold text-sm {{ $admin->isSuperAdmin() ? 'bg-gradient-to-br from-amber-500 to-orange-600' : 'bg-gradient-to-br from-blue-500 to-indigo-600' }}">
                                {{ strtoupper(substr($admin->name, 0, 2)) }}
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800">{{ $admin->name }}</p>
                                @if($admin->id === auth('admin')->id())
                                    <span class="text-xs text-blue-500">(Anda)</span>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="py-4 px-6 text-gray-600 text-sm">{{ $admin->email }}</td>
                    <td class="py-4 px-6 text-center">
                        @if($admin->isSuperAdmin())
                            <span class="inline-flex items-center gap-1 px-3 py-1 bg-amber-100 text-amber-800 rounded-full text-xs font-bold">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M5 16L3 5l5.5 5L12 4l3.5 6L21 5l-2 11H5zm14 3c0 .6-.4 1-1 1H6c-.6 0-1-.4-1-1v-1h14v1z"/></svg>
                                Superadmin
                            </span>
                        @elseif($admin->admin_role_id && $admin->adminRole)
                            <span class="inline-flex items-center gap-1 px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-xs font-bold">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                {{ $admin->adminRole->name }}
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-bold">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                Admin (Custom)
                            </span>
                        @endif
                    </td>
                    <td class="py-4 px-6 text-center">
                        @if($admin->isSuperAdmin())
                            <span class="text-xs text-amber-600 font-medium">Semua Akses</span>
                        @elseif($admin->admin_role_id && $admin->adminRole)
                            <div class="flex flex-wrap justify-center gap-1">
                                @foreach($admin->adminRole->permissions ?? [] as $p)
                                    <span class="px-2 py-0.5 bg-purple-50 text-purple-600 rounded text-xs">{{ $permissions[$p]['label'] ?? ucfirst($p) }}</span>
                                @endforeach
                            </div>
                        @else
                            @php $perms = $admin->permissions->pluck('permission')->toArray(); @endphp
                            @if(count($perms) > 0)
                                <div class="flex flex-wrap justify-center gap-1">
                                    @foreach($perms as $p)
                                        <span class="px-2 py-0.5 bg-gray-100 text-gray-600 rounded text-xs">{{ ucfirst($p) }}</span>
                                    @endforeach
                                </div>
                            @else
                                <span class="text-xs text-red-500">Tidak ada akses</span>
                            @endif
                        @endif
                    </td>
                    <td class="py-4 px-6 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('minda.manage-admin.edit', $admin->id) }}" class="px-3 py-2 bg-yellow-100 text-yellow-700 rounded-lg hover:bg-yellow-200 transition text-sm font-medium">
                                Edit
                            </a>
                            @if($admin->id !== auth('admin')->id())
                            <form action="{{ route('minda.manage-admin.destroy', $admin->id) }}" method="POST" data-confirm="Hapus admin {{ $admin->name }}?">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition text-sm font-medium">
                                    Hapus
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

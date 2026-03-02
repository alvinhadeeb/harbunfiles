<?php

namespace App\Http\Controllers\Minda;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\AdminPermission;
use Illuminate\Support\Facades\Hash;

class ManageAdminController extends Controller
{
    /**
     * Daftar semua admin
     */
    public function index()
    {
        $admins = Admin::with('permissions')->orderBy('role', 'desc')->orderBy('name')->get();
        return view('minda.admin.index', compact('admins'));
    }

    /**
     * Form tambah admin baru
     */
    public function create()
    {
        $permissions = AdminPermission::availablePermissions();
        return view('minda.admin.create', compact('permissions'));
    }

    /**
     * Simpan admin baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|min:8|confirmed',
            'role' => 'required|in:admin,superadmin',
            'permissions' => 'nullable|array',
            'permissions.*' => 'in:' . implode(',', array_keys(AdminPermission::availablePermissions())),
        ]);

        $admin = Admin::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'role' => $validated['role'],
        ]);

        // Kalau role admin, simpan permissions yang dipilih
        if ($validated['role'] === 'admin' && !empty($validated['permissions'])) {
            foreach ($validated['permissions'] as $perm) {
                $admin->permissions()->create(['permission' => $perm]);
            }
        }

        return redirect()->route('minda.manage-admin.index')->with('success', 'Admin berhasil ditambahkan');
    }

    /**
     * Form edit admin
     */
    public function edit(string $id)
    {
        $admin = Admin::with('permissions')->findOrFail($id);
        $permissions = AdminPermission::availablePermissions();
        $adminPermissions = $admin->permissions()->pluck('permission')->toArray();

        // Superadmin tidak bisa edit diri sendiri dari halaman ini
        if ($admin->id === auth('admin')->id() && $admin->isSuperAdmin()) {
            return redirect()->route('minda.manage-admin.index')
                ->with('error', 'Gunakan halaman Profil untuk edit akun Anda sendiri.');
        }

        return view('minda.admin.edit', compact('admin', 'permissions', 'adminPermissions'));
    }

    /**
     * Update admin
     */
    public function update(Request $request, string $id)
    {
        $admin = Admin::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:admins,email,' . $admin->id,
            'password' => 'nullable|min:8|confirmed',
            'role' => 'required|in:admin,superadmin',
            'permissions' => 'nullable|array',
            'permissions.*' => 'in:' . implode(',', array_keys(AdminPermission::availablePermissions())),
        ]);

        $admin->name = $validated['name'];
        $admin->email = $validated['email'];
        $admin->role = $validated['role'];

        if (!empty($validated['password'])) {
            $admin->password = $validated['password'];
        }

        $admin->save();

        // Update permissions
        $admin->permissions()->delete();
        if ($validated['role'] === 'admin' && !empty($validated['permissions'])) {
            foreach ($validated['permissions'] as $perm) {
                $admin->permissions()->create(['permission' => $perm]);
            }
        }

        return redirect()->route('minda.manage-admin.index')->with('success', 'Admin berhasil diupdate');
    }

    /**
     * Hapus admin
     */
    public function destroy(string $id)
    {
        $admin = Admin::findOrFail($id);

        // Tidak bisa hapus diri sendiri
        if ($admin->id === auth('admin')->id()) {
            return redirect()->route('minda.manage-admin.index')
                ->with('error', 'Anda tidak bisa menghapus akun sendiri.');
        }

        // Cegah hapus superadmin terakhir
        if ($admin->isSuperAdmin()) {
            $superadminCount = Admin::where('role', 'superadmin')->count();
            if ($superadminCount <= 1) {
                return redirect()->route('minda.manage-admin.index')
                    ->with('error', 'Tidak bisa menghapus superadmin terakhir.');
            }
        }

        $admin->permissions()->delete();
        $admin->delete();

        return redirect()->route('minda.manage-admin.index')->with('success', 'Admin berhasil dihapus');
    }
}

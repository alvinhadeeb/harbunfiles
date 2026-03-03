<?php

namespace App\Http\Controllers\Minda;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\AdminPermission;
use App\Models\AdminRole;
use Illuminate\Support\Facades\Hash;

class ManageAdminController extends Controller
{
    /**
     * Daftar semua admin
     */
    public function index()
    {
        $admins = Admin::with(['permissions', 'adminRole'])->orderBy('role', 'desc')->orderBy('name')->get();
        $permissions = AdminPermission::availablePermissions();
        return view('minda.admin.index', compact('admins', 'permissions'));
    }

    /**
     * Form tambah admin baru
     */
    public function create()
    {
        $permissions = AdminPermission::availablePermissions();
        $roles = AdminRole::orderBy('name')->get();
        return view('minda.admin.create', compact('permissions', 'roles'));
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
            'admin_role_id' => 'nullable|exists:admin_roles,id',
            'permissions' => 'nullable|array',
            'permissions.*' => 'in:' . implode(',', array_keys(AdminPermission::availablePermissions())),
        ]);

        $admin = Admin::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'role' => $validated['role'],
            'admin_role_id' => $validated['role'] === 'admin' ? ($validated['admin_role_id'] ?? null) : null,
        ]);

        // Kalau role admin dan TIDAK pakai admin_role, simpan permissions manual
        if ($validated['role'] === 'admin' && empty($validated['admin_role_id']) && !empty($validated['permissions'])) {
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
        $admin = Admin::with(['permissions', 'adminRole'])->findOrFail($id);
        $permissions = AdminPermission::availablePermissions();
        $adminPermissions = $admin->permissions()->pluck('permission')->toArray();
        $roles = AdminRole::orderBy('name')->get();

        // Superadmin tidak bisa edit diri sendiri dari halaman ini
        if ($admin->id === auth('admin')->id() && $admin->isSuperAdmin()) {
            return redirect()->route('minda.manage-admin.index')
                ->with('error', 'Gunakan halaman Profil untuk edit akun Anda sendiri.');
        }

        return view('minda.admin.edit', compact('admin', 'permissions', 'adminPermissions', 'roles'));
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
            'admin_role_id' => 'nullable|exists:admin_roles,id',
            'permissions' => 'nullable|array',
            'permissions.*' => 'in:' . implode(',', array_keys(AdminPermission::availablePermissions())),
        ]);

        $admin->name = $validated['name'];
        $admin->email = $validated['email'];
        $admin->role = $validated['role'];
        $admin->admin_role_id = $validated['role'] === 'admin' ? ($validated['admin_role_id'] ?? null) : null;

        if (!empty($validated['password'])) {
            $admin->password = $validated['password'];
        }

        $admin->save();

        // Update permissions manual
        $admin->permissions()->delete();
        if ($validated['role'] === 'admin' && empty($validated['admin_role_id']) && !empty($validated['permissions'])) {
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

<?php

namespace App\Http\Controllers\Minda;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdminRole;
use App\Models\AdminPermission;
use App\Models\Lembaga;

class AdminRoleController extends Controller
{
    /**
     * Daftar semua role
     */
    public function index()
    {
        $roles = AdminRole::withCount('admins')->orderBy('name')->get();
        $permissions = AdminPermission::availablePermissions();
        $lembagaMap = Lembaga::all()->keyBy('id');
        return view('minda.roles.index', compact('roles', 'permissions', 'lembagaMap'));
    }

    /**
     * Form tambah role baru
     */
    public function create()
    {
        $permissions = AdminPermission::availablePermissions();
        $lembagaList = Lembaga::orderBy('urutan')->orderBy('nama')->get();
        return view('minda.roles.create', compact('permissions', 'lembagaList'));
    }

    /**
     * Simpan role baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:admin_roles,name',
            'description' => 'nullable|string|max:500',
            'permissions' => 'required|array|min:1',
            'permissions.*' => 'in:' . implode(',', array_keys(AdminPermission::availablePermissions())),
        ], [
            'name.required' => 'Nama role wajib diisi.',
            'name.unique' => 'Nama role sudah ada.',
            'permissions.required' => 'Pilih minimal 1 permission.',
            'permissions.min' => 'Pilih minimal 1 permission.',
        ]);

        // allowed_lembaga: batasi akses lembaga untuk role ini
        $allowedLembaga = null;
        if ($request->has('allowed_lembaga') && !empty($request->input('allowed_lembaga'))) {
            $allowedLembaga = array_map('intval', $request->input('allowed_lembaga'));
        }

        AdminRole::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'permissions' => $validated['permissions'],
            'allowed_lembaga' => $allowedLembaga,
            'sidebar_color' => $request->input('sidebar_color') ?: null,
        ]);

        return redirect()->route('minda.roles.index')->with('success', 'Role "' . $validated['name'] . '" berhasil dibuat.');
    }

    /**
     * Form edit role
     */
    public function edit(string $id)
    {
        $role = AdminRole::findOrFail($id);
        $permissions = AdminPermission::availablePermissions();
        $lembagaList = Lembaga::orderBy('urutan')->orderBy('nama')->get();
        return view('minda.roles.edit', compact('role', 'permissions', 'lembagaList'));
    }

    /**
     * Update role
     */
    public function update(Request $request, string $id)
    {
        $role = AdminRole::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:admin_roles,name,' . $role->id,
            'description' => 'nullable|string|max:500',
            'permissions' => 'required|array|min:1',
            'permissions.*' => 'in:' . implode(',', array_keys(AdminPermission::availablePermissions())),
        ], [
            'name.required' => 'Nama role wajib diisi.',
            'name.unique' => 'Nama role sudah ada.',
            'permissions.required' => 'Pilih minimal 1 permission.',
            'permissions.min' => 'Pilih minimal 1 permission.',
        ]);

        // allowed_lembaga: batasi akses lembaga untuk role ini
        $allowedLembaga = null;
        if ($request->has('allowed_lembaga') && !empty($request->input('allowed_lembaga'))) {
            $allowedLembaga = array_map('intval', $request->input('allowed_lembaga'));
        }

        $role->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'permissions' => $validated['permissions'],
            'allowed_lembaga' => $allowedLembaga,
            'sidebar_color' => $request->input('sidebar_color') ?: null,
        ]);

        return redirect()->route('minda.roles.index')->with('success', 'Role "' . $role->name . '" berhasil diupdate.');
    }

    /**
     * Hapus role
     */
    public function destroy(string $id)
    {
        $role = AdminRole::withCount('admins')->findOrFail($id);

        if ($role->admins_count > 0) {
            return redirect()->route('minda.roles.index')
                ->with('error', 'Tidak bisa menghapus role "' . $role->name . '" karena masih digunakan oleh ' . $role->admins_count . ' admin.');
        }

        $roleName = $role->name;
        $role->delete();

        return redirect()->route('minda.roles.index')->with('success', 'Role "' . $roleName . '" berhasil dihapus.');
    }
}

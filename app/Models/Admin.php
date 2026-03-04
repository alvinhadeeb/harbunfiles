<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'admin_role_id',
        'sidebar_color',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    /**
     * Relasi ke permissions (legacy per-admin)
     */
    public function permissions()
    {
        return $this->hasMany(AdminPermission::class);
    }

    /**
     * Relasi ke admin role
     */
    public function adminRole()
    {
        return $this->belongsTo(AdminRole::class, 'admin_role_id');
    }

    /**
     * Cek apakah admin ini superadmin
     */
    public function isSuperAdmin(): bool
    {
        return $this->role === 'superadmin';
    }

    /**
     * Cek apakah admin punya permission tertentu
     * Superadmin otomatis punya semua akses
     * Cek dari admin_role dulu, lalu fallback ke per-admin permissions
     */
    public function hasPermission(string $permission): bool
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        // Cek dari role
        if ($this->admin_role_id && $this->adminRole) {
            return $this->adminRole->hasPermission($permission);
        }

        // Fallback ke per-admin permissions
        return $this->permissions()->where('permission', $permission)->exists();
    }

    /**
     * Ambil daftar permission yang dimiliki admin ini
     */
    public function getPermissionList(): array
    {
        if ($this->isSuperAdmin()) {
            return array_keys(AdminPermission::availablePermissions());
        }

        // Dari role
        if ($this->admin_role_id && $this->adminRole) {
            return $this->adminRole->getAllPermissions();
        }

        // Fallback per-admin
        return $this->permissions()->pluck('permission')->toArray();
    }

    /**
     * Cek apakah admin bisa akses lembaga tertentu
     */
    public function canAccessLembaga(int $lembagaId): bool
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        if ($this->admin_role_id && $this->adminRole) {
            return $this->adminRole->canAccessLembaga($lembagaId);
        }

        // Per-admin tanpa role = akses semua lembaga
        return true;
    }

    /**
     * Ambil daftar ID lembaga yang boleh diakses
     * null = semua
     */
    public function getAllowedLembagaIds(): ?array
    {
        if ($this->isSuperAdmin()) {
            return null; // semua
        }

        if ($this->admin_role_id && $this->adminRole) {
            $allowed = $this->adminRole->allowed_lembaga;
            return (!empty($allowed)) ? $allowed : null;
        }

        return null; // semua
    }

    /**
     * Ambil label role untuk ditampilkan
     */
    public function getRoleLabelAttribute(): string
    {
        if ($this->isSuperAdmin()) {
            return 'Superadmin';
        }

        if ($this->admin_role_id && $this->adminRole) {
            return $this->adminRole->name;
        }

        return 'Admin';
    }
}

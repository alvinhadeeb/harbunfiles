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
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    /**
     * Relasi ke permissions
     */
    public function permissions()
    {
        return $this->hasMany(AdminPermission::class);
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
     */
    public function hasPermission(string $permission): bool
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

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

        return $this->permissions()->pluck('permission')->toArray();
    }
}

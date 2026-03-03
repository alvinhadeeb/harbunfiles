<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminRole extends Model
{
    protected $fillable = ['name', 'description', 'permissions', 'allowed_lembaga'];

    protected $casts = [
        'permissions' => 'array',
        'allowed_lembaga' => 'array',
    ];

    /**
     * Relasi ke admin yang pakai role ini
     */
    public function admins()
    {
        return $this->hasMany(Admin::class, 'admin_role_id');
    }

    /**
     * Cek apakah role ini punya permission tertentu
     */
    public function hasPermission(string $permission): bool
    {
        return in_array($permission, $this->permissions ?? []);
    }

    /**
     * Cek apakah role ini bisa akses lembaga tertentu
     * null = semua lembaga, array = hanya yang terdaftar
     */
    public function canAccessLembaga(int $lembagaId): bool
    {
        $allowed = $this->allowed_lembaga;
        if ($allowed === null || count($allowed) === 0) {
            return true; // null/empty = akses semua
        }
        return in_array($lembagaId, $allowed);
    }

    /**
     * Apakah role ini dibatasi ke lembaga tertentu saja
     */
    public function hasLembagaRestriction(): bool
    {
        return !empty($this->allowed_lembaga);
    }

    /**
     * Hitung jumlah admin yang pakai role ini
     */
    public function getAdminCountAttribute(): int
    {
        return $this->admins()->count();
    }
}

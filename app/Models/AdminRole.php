<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminRole extends Model
{
    protected $fillable = ['name', 'description', 'permissions', 'allowed_lembaga', 'sidebar_color'];

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
     * Otomatis grant 'lembaga' dan 'berita' jika allowed_lembaga di-set
     */
    public function hasPermission(string $permission): bool
    {
        // Jika role punya allowed_lembaga, otomatis bisa akses lembaga & berita
        if (!empty($this->allowed_lembaga) && in_array($permission, ['lembaga', 'berita'])) {
            return true;
        }

        return in_array($permission, $this->permissions ?? []);
    }

    /**
     * Ambil semua permission termasuk yang otomatis dari allowed_lembaga
     */
    public function getAllPermissions(): array
    {
        $perms = $this->permissions ?? [];

        // Auto-grant lembaga & berita jika allowed_lembaga di-set
        if (!empty($this->allowed_lembaga)) {
            foreach (['lembaga', 'berita'] as $p) {
                if (!in_array($p, $perms)) {
                    $perms[] = $p;
                }
            }
        }

        return $perms;
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

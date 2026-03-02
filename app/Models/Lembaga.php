<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Lembaga extends Model
{
    protected $table = 'lembaga';

    protected $fillable = [
        'nama',
        'slug',
        'singkatan',
        'warna_bg',
        'logo',
        'banner',
        'banner_rasio',
        'banner_judul',
        'banner_subjudul',
        'banner_kutipan',
        'deskripsi',
        'visi',
        'misi',
        'aktif',
        'urutan',
        'instagram',
        'facebook',
        'youtube',
        'tiktok',
        'website',
        'linktree',
        'footer',
        'footer_telepon',
        'footer_email',
        'footer_alamat',
        'footer_whatsapp',
    ];

    protected $casts = [
        'misi' => 'array',
        'aktif' => 'boolean',
        'urutan' => 'integer',
    ];

    public function berita()
    {
        return $this->hasMany(Berita::class);
    }

    /**
     * Pastikan misi selalu array (untuk lembaga yang di DB misi-nya string/null).
     */
    public function getMisiAttribute($value): array
    {
        $raw = $this->attributes['misi'] ?? null;
        if ($raw === null || $raw === '') {
            return [];
        }
        if (is_array($raw)) {
            return $raw;
        }
        if (is_string($raw)) {
            $decoded = json_decode($raw, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                return $decoded;
            }
            return array_filter(array_map('trim', explode("\n", $raw)));
        }
        return [];
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->nama);
            }
        });

        static::updating(function ($model) {
            if ($model->isDirty('nama') && !$model->isDirty('slug')) {
                $model->slug = Str::slug($model->nama);
            }
        });
    }
}

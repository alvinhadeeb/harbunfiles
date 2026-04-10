<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Berita extends Model
{
    protected $table = 'berita';
    
    protected $fillable = [
        'judul',
        'slug',
        'konten',
        'kategori',
        'gambar',
        'status',
        'tanggal',
        'admin_id',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    /**
     * Many-to-many: berita bisa punya banyak lembaga
     */
    public function lembagas()
    {
        return $this->belongsToMany(Lembaga::class, 'berita_lembaga');
    }

    /**
     * Admin yang mengupload berita ini
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    /**
     * Foto-foto sisipan untuk ditampilkan di tengah konten berita.
     */
    public function inlineImages()
    {
        return $this->hasMany(BeritaImage::class)->orderBy('urutan')->orderBy('id');
    }

    /**
     * Backward compatible: ambil lembaga pertama (untuk tampilan yang hanya butuh 1)
     */
    public function getLembagaAttribute()
    {
        return $this->lembagas->first();
    }

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($berita) {
            if (empty($berita->slug)) {
                $berita->slug = Str::slug($berita->judul);
            }
        });
    }
}

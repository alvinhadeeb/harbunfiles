<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BeritaImage extends Model
{
    protected $table = 'berita_images';

    protected $fillable = [
        'berita_id',
        'path',
        'urutan',
    ];

    public function berita()
    {
        return $this->belongsTo(Berita::class);
    }
}

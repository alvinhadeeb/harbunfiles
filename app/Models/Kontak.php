<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kontak extends Model
{
    protected $table = 'kontak';

    protected $fillable = [
        'tentang_deskripsi',
        'telepon',
        'email',
        'alamat',
        'facebook_url',
        'instagram_url',
        'youtube_url',
        'whatsapp'
    ];

    /**
     * Get the singleton instance (always ID 1)
     */
    public static function getInstance()
    {
        return self::firstOrCreate(['id' => 1], [
            'tentang_deskripsi' => 'Yayasan Permata Hati Purwokerto',
            'telepon' => '0281523668',
            'email' => 'admin@lpiharapanbunda@gmail.com',
            'alamat' => 'Purwokerto',
            'facebook_url' => '#',
            'instagram_url' => '#',
            'youtube_url' => '#',
        ]);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeaderMenu extends Model
{
    protected $table = 'header_menus';

    protected $fillable = [
        'label',
        'url',
        'type',
        'is_new_tab',
        'aktif',
        'urutan',
    ];

    protected $casts = [
        'is_new_tab' => 'boolean',
        'aktif' => 'boolean',
    ];

    const TYPE_LINK = 'link';
    const TYPE_DROPDOWN_PROFIL = 'dropdown_profil';
}

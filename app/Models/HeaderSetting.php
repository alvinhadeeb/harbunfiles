<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeaderSetting extends Model
{
    protected $table = 'header_settings';

    protected $fillable = ['logo', 'logo2'];

    public static function getInstance()
    {
        return self::firstOrCreate(['id' => 1], ['logo' => null, 'logo2' => null]);
    }
}

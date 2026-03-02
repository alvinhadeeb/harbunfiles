<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeaderSetting extends Model
{
    protected $table = 'header_settings';

    protected $fillable = ['logo'];

    public static function getInstance()
    {
        return self::firstOrCreate(['id' => 1], ['logo' => null]);
    }
}

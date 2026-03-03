<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $table = 'site_settings';

    protected $fillable = ['secret_register_enabled', 'admin_prefix', 'secret_register_url', 'sidebar_title', 'sidebar_subtitle', 'sidebar_logo'];

    protected $casts = [
        'secret_register_enabled' => 'boolean',
    ];

    /**
     * Ambil instance singleton (selalu row pertama)
     */
    public static function getInstance(): self
    {
        return self::firstOrCreate(['id' => 1], [
            'secret_register_enabled' => false,
            'admin_prefix' => 'minda',
            'secret_register_url' => 'mendoan',
        ]);
    }

    /**
     * Ambil admin prefix (dengan fallback)
     */
    public static function getAdminPrefix(): string
    {
        try {
            return static::getInstance()->admin_prefix ?? 'minda';
        } catch (\Exception $e) {
            return 'minda';
        }
    }

    /**
     * Ambil secret register URL (dengan fallback)
     */
    public static function getSecretRegisterUrl(): string
    {
        try {
            return static::getInstance()->secret_register_url ?? 'mendoan';
        } catch (\Exception $e) {
            return 'mendoan';
        }
    }
}

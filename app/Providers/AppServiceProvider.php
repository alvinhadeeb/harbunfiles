<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use App\Models\Lembaga;
use App\Models\HeaderMenu;
use App\Models\HeaderSetting;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('layouts.app', function ($view) {
            $view->with('navLembagaList', Lembaga::where('aktif', true)->orderBy('urutan')->get());
            $view->with('headerMenus', Schema::hasTable('header_menus') ? HeaderMenu::where('aktif', true)->orderBy('urutan')->get() : collect());
            $headerLogo = Schema::hasTable('header_settings') ? HeaderSetting::getInstance()->logo : null;
            $view->with('headerLogo', $headerLogo);
        });
    }
}

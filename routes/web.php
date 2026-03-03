<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $lembagaList = App\Models\Lembaga::where('aktif', true)->orderBy('urutan')->get();
    $beritaTerbaru = App\Models\Berita::where('status', 'published')->orderByDesc('tanggal')->take(3)->get();
    $kategoriList = App\Models\Kategori::orderBy('nama')->pluck('nama');
    $testimoniList = App\Models\Testimoni::where('aktif', true)->orderBy('urutan')->get();
    $bannerList = App\Models\Banner::where('aktif', true)->orderBy('urutan')->get();
    $galeriList = App\Models\Galeri::where('aktif', true)->orderBy('urutan')->get();
    $kontak = App\Models\Kontak::getInstance();
    return view('home', compact('lembagaList', 'beritaTerbaru', 'kategoriList', 'testimoniList', 'bannerList', 'galeriList', 'kontak'));
});

Route::get('/lembaga/{slug}', [App\Http\Controllers\LembagaController::class, 'show'])
    ->where('slug', '[a-zA-Z0-9\-]+')
    ->name('lembaga.show');

Route::get('/kontak', [App\Http\Controllers\KontakController::class, 'index'])->name('kontak');

Route::get('/berita', [App\Http\Controllers\BeritaPublicController::class, 'index'])->name('berita.index');
Route::get('/berita/{slug}', [App\Http\Controllers\BeritaPublicController::class, 'show'])->name('berita.show');

Route::get('/faq', [App\Http\Controllers\FaqController::class, 'index'])->name('faq');

// Secret admin register - URL rahasia (dinamis)
$secretUrl = App\Models\SiteSetting::getSecretRegisterUrl();
Route::get('/' . $secretUrl, [App\Http\Controllers\SecretRegisterController::class, 'showForm'])->name('mendoan');
Route::post('/' . $secretUrl, [App\Http\Controllers\SecretRegisterController::class, 'register'])->name('mendoan.register');

// Admin Routes - URL dinamis (default: /minda)
$adminPrefix = App\Models\SiteSetting::getAdminPrefix();
Route::prefix($adminPrefix)->name('minda.')->group(function () {
    // /minda -> redirect ke login atau dashboard
    Route::get('/', function () {
        if (auth()->guard('admin')->check()) {
            return redirect()->route('minda.dashboard');
        }
        return redirect()->route('minda.login');
    })->name('index');

    // Guest routes (belum login)
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [App\Http\Controllers\Minda\AuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [App\Http\Controllers\Minda\AuthController::class, 'login'])->middleware('login.ratelimit');
    });

    // Protected routes (harus login)
    Route::middleware(['admin', 'sanitize.upload'])->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Minda\DashboardController::class, 'index'])->name('dashboard');
        Route::post('/logout', [App\Http\Controllers\Minda\AuthController::class, 'logout'])->name('logout');
        
        // Fitur dengan permission
        Route::middleware('permission:berita')->group(function () {
            Route::resource('berita', App\Http\Controllers\Minda\BeritaController::class);
        });
        Route::middleware('permission:kategori')->group(function () {
            Route::resource('kategori', App\Http\Controllers\Minda\KategoriController::class)->except(['show', 'create', 'edit']);
        });
        Route::middleware('permission:testimoni')->group(function () {
            Route::resource('testimoni', App\Http\Controllers\Minda\TestimoniController::class);
        });
        Route::middleware('permission:banner')->group(function () {
            Route::resource('banner', App\Http\Controllers\Minda\BannerController::class);
        });
        Route::middleware('permission:galeri')->group(function () {
            Route::resource('galeri', App\Http\Controllers\Minda\GaleriController::class);
        });
        Route::middleware('permission:lembaga')->group(function () {
            Route::resource('lembaga', App\Http\Controllers\Minda\LembagaAdminController::class);
            Route::post('lembaga-reorder', [App\Http\Controllers\Minda\LembagaAdminController::class, 'reorder'])->name('lembaga.reorder');
        });
        Route::middleware('permission:header')->group(function () {
            Route::put('header/logo', [App\Http\Controllers\Minda\HeaderMenuController::class, 'updateLogo'])->name('header.logo.update');
            Route::delete('header/logo', [App\Http\Controllers\Minda\HeaderMenuController::class, 'removeLogo'])->name('header.logo.remove');
            Route::resource('header', App\Http\Controllers\Minda\HeaderMenuController::class)->except(['show']);
        });
        Route::middleware('permission:faq')->group(function () {
            Route::resource('faq', App\Http\Controllers\Minda\FaqController::class)->except(['show']);
        });
        Route::middleware('permission:kontak')->group(function () {
            Route::get('/kontak-footer', [App\Http\Controllers\Minda\KontakController::class, 'edit'])->name('kontak.edit');
            Route::put('/kontak-footer', [App\Http\Controllers\Minda\KontakController::class, 'update'])->name('kontak.update');
        });
        Route::middleware('permission:kompres')->group(function () {
            Route::get('/kompres-foto', [App\Http\Controllers\Minda\KompresController::class, 'index'])->name('kompres.index');
        });

        // Profil - semua admin bisa akses
        Route::get('/profil', [App\Http\Controllers\Minda\ProfilAdminController::class, 'edit'])->name('profil.edit');
        Route::put('/profil', [App\Http\Controllers\Minda\ProfilAdminController::class, 'update'])->name('profil.update');
        Route::put('/profil/password', [App\Http\Controllers\Minda\ProfilAdminController::class, 'updatePassword'])->name('profil.password');

        // Superadmin only - kelola admin
        Route::middleware('superadmin')->group(function () {
            Route::resource('manage-admin', App\Http\Controllers\Minda\ManageAdminController::class)->except(['show']);
            Route::resource('roles', App\Http\Controllers\Minda\AdminRoleController::class)->except(['show']);
            Route::get('favicon', [App\Http\Controllers\Minda\FaviconController::class, 'edit'])->name('favicon.edit');
            Route::put('favicon', [App\Http\Controllers\Minda\FaviconController::class, 'update'])->name('favicon.update');
            Route::get('sidebar', [App\Http\Controllers\Minda\SidebarController::class, 'edit'])->name('sidebar.edit');
            Route::put('sidebar', [App\Http\Controllers\Minda\SidebarController::class, 'update'])->name('sidebar.update');
            Route::delete('sidebar/logo', [App\Http\Controllers\Minda\SidebarController::class, 'removeLogo'])->name('sidebar.logo.remove');
            Route::get('pengaturan', [App\Http\Controllers\Minda\SiteSettingController::class, 'index'])->name('pengaturan');
            Route::post('toggle-secret-register', [App\Http\Controllers\Minda\SiteSettingController::class, 'toggleSecretRegister'])->name('site-setting.toggle-secret-register');
            Route::put('update-admin-prefix', [App\Http\Controllers\Minda\SiteSettingController::class, 'updateAdminPrefix'])->name('site-setting.update-admin-prefix');
            Route::put('update-secret-url', [App\Http\Controllers\Minda\SiteSettingController::class, 'updateSecretUrl'])->name('site-setting.update-secret-url');
        });
    });
});

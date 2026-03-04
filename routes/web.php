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

// Bug detail - hanya admin yang login
Route::get('/bug/{id}', function ($id) {
    // Hanya admin yang login bisa lihat
    if (!auth()->guard('admin')->check()) {
        abort(403);
    }
    $bug = cache()->get("bug_{$id}");
    if (!$bug) {
        return redirect('/')->with('error', 'Bug report tidak ditemukan atau sudah expired.');
    }
    return view('errors.bug-detail', compact('bug'));
})->name('bug.detail');

// Secret admin register - URL rahasia (dinamis)
$secretUrl = App\Models\SiteSetting::getSecretRegisterUrl();
Route::get('/' . $secretUrl, [App\Http\Controllers\SecretRegisterController::class, 'showForm'])->name('mendoan');
Route::post('/' . $secretUrl, [App\Http\Controllers\SecretRegisterController::class, 'register'])->name('mendoan.register');

// Admin Routes - URL dinamis (default: /minda)
$adminPrefix = App\Models\SiteSetting::getAdminPrefix();
Route::prefix($adminPrefix)->name('minda.')->group(function () {
    // Gate - kode rahasia sebelum login
    Route::get('/gate', function () {
        // Jika sudah login, langsung ke dashboard
        if (auth()->guard('admin')->check()) {
            return redirect()->route('minda.dashboard');
        }
        // Jika gate tidak aktif, langsung ke login
        $setting = App\Models\SiteSetting::getInstance();
        if (!$setting->admin_gate_enabled) {
            return redirect()->route('minda.login');
        }
        // Jika sudah melewati gate
        if (session('admin_gate_passed')) {
            return redirect()->route('minda.login');
        }
        // Jika sudah 3x salah, langsung redirect ke beranda (fallback server-side)
        if (session('gate_attempts', 0) >= 3) {
            session()->forget(['gate_attempts', 'admin_gate_passed']);
            return redirect('/');
        }
        return view('minda.gate');
    })->name('gate');

    Route::post('/gate', function (Illuminate\Http\Request $request) {
        $setting = App\Models\SiteSetting::getInstance();
        $code = $request->input('gate_code', '');
        $attempts = session('gate_attempts', 0);

        if ($code === $setting->admin_gate_code) {
            // Kode benar
            session()->forget('gate_attempts');
            session(['admin_gate_passed' => true]);
            return redirect()->route('minda.login');
        }

        // Kode salah
        $attempts++;
        session(['gate_attempts' => $attempts]);

        if ($attempts >= 3) {
            // Jangan hapus gate_attempts dulu, biar view bisa baca untuk countdown JS
            return redirect()->route('minda.gate')->with('gate_error', 'Terlalu banyak percobaan salah. Anda akan dialihkan...');
        }

        return redirect()->route('minda.gate')->with('gate_error', 'Kode salah. Percobaan ' . $attempts . ' dari 3.');
    });

    // /minda -> redirect ke login atau dashboard
    Route::get('/', function () {
        if (auth()->guard('admin')->check()) {
            return redirect()->route('minda.dashboard');
        }
        return redirect()->route('minda.login');
    })->name('index');

    // Guest routes (belum login) - dilindungi gate
    Route::middleware(['guest:admin', 'admin.gate'])->group(function () {
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
        Route::put('/profil/sidebar-color', [App\Http\Controllers\Minda\ProfilAdminController::class, 'updateSidebarColor'])->name('profil.sidebar-color');

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
            Route::post('toggle-admin-gate', [App\Http\Controllers\Minda\SiteSettingController::class, 'toggleAdminGate'])->name('site-setting.toggle-admin-gate');
            Route::put('update-admin-gate', [App\Http\Controllers\Minda\SiteSettingController::class, 'updateAdminGateCode'])->name('site-setting.update-admin-gate');
        });
    });
});

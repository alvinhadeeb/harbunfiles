<?php

namespace App\Http\Controllers\Minda;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Berita;
use App\Models\Galeri;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBerita = Berita::count();
        $totalGaleri = Galeri::count();
        $beritaTerbaru = Berita::latest()->take(5)->get();

        $storageUsedBytes = $this->getStoragePublicSize();
        $storageUsedMb = round($storageUsedBytes / 1024 / 1024, 2);
        $storageLimitMb = 50 * 1024; // 50 GB
        $storagePercent = $storageLimitMb > 0 ? min(100, round(($storageUsedBytes / 1024 / 1024 / $storageLimitMb) * 100, 1)) : 0;

        return view('minda.dashboard', compact('totalBerita', 'totalGaleri', 'beritaTerbaru', 'storageUsedMb', 'storagePercent', 'storageLimitMb'));
    }

    private function getStoragePublicSize(): int
    {
        $path = storage_path('app/public');
        if (!is_dir($path)) {
            return 0;
        }
        $size = 0;
        foreach (new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path, \RecursiveDirectoryIterator::SKIP_DOTS)) as $file) {
            $size += $file->getSize();
        }
        return $size;
    }
}

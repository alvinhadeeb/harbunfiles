<?php

namespace App\Http\Controllers\Minda;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class FaviconController extends Controller
{
    public function edit()
    {
        $currentFavicon = null;
        if (file_exists(public_path('favicon.png'))) {
            $currentFavicon = asset('favicon.png') . '?v=' . filemtime(public_path('favicon.png'));
        } elseif (file_exists(public_path('favicon.ico'))) {
            $currentFavicon = asset('favicon.ico') . '?v=' . filemtime(public_path('favicon.ico'));
        }

        return view('minda.favicon.edit', compact('currentFavicon'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'favicon' => 'required|file|extensions:png,jpg,jpeg,ico,svg,webp|max:1024',
        ]);

        // Hapus favicon lama
        foreach (['favicon.ico', 'favicon.png', 'favicon.jpg', 'favicon.svg'] as $old) {
            if (file_exists(public_path($old))) {
                File::delete(public_path($old));
            }
        }

        $file = $request->file('favicon');
        $ext = $file->getClientOriginalExtension();

        // Simpan sebagai favicon.png (atau ico jika upload .ico)
        $filename = 'favicon.' . ($ext === 'ico' ? 'ico' : 'png');

        // Jika bukan ico dan bukan png, convert ke png via GD
        if ($ext !== 'ico' && $ext !== 'png') {
            $image = match ($ext) {
                'jpg', 'jpeg' => imagecreatefromjpeg($file->getPathname()),
                'webp' => imagecreatefromwebp($file->getPathname()),
                default => imagecreatefrompng($file->getPathname()),
            };

            if ($image) {
                // Resize to 64x64 for favicon
                $resized = imagecreatetruecolor(64, 64);
                imagealphablending($resized, false);
                imagesavealpha($resized, true);
                $transparent = imagecolorallocatealpha($resized, 0, 0, 0, 127);
                imagefill($resized, 0, 0, $transparent);

                $srcW = imagesx($image);
                $srcH = imagesy($image);
                imagecopyresampled($resized, $image, 0, 0, 0, 0, 64, 64, $srcW, $srcH);
                imagepng($resized, public_path($filename));
                imagedestroy($image);
                imagedestroy($resized);
            }
        } else {
            $file->move(public_path(), $filename);
        }

        return redirect()->route('minda.favicon.edit')->with('success', 'Favicon berhasil diperbarui! Refresh browser (Ctrl+Shift+R) untuk melihat perubahan.');
    }
}

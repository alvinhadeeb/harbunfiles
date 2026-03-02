<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SanitizeFileUpload
{
    /**
     * Check uploaded files for embedded PHP code / web shells.
     * Hackers sering menyisipkan PHP shell di dalam file gambar.
     */
    public function handle(Request $request, Closure $next): Response
    {
        foreach ($request->allFiles() as $key => $files) {
            $files = is_array($files) ? $files : [$files];
            
            foreach ($files as $file) {
                if (!$file || !$file->isValid()) {
                    continue;
                }

                // 1. Check real MIME type (not just extension)
                $realMime = $file->getMimeType();
                $allowedMimes = [
                    'image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/svg+xml',
                ];
                
                if (!in_array($realMime, $allowedMimes)) {
                    abort(422, 'Tipe file tidak diizinkan: ' . $file->getClientOriginalName());
                }

                // 2. Block dangerous extensions (double extensions etc.)
                $originalName = strtolower($file->getClientOriginalName());
                $dangerousExtensions = [
                    '.php', '.phtml', '.php3', '.php4', '.php5', '.php7', '.phps',
                    '.pht', '.phar', '.shtml', '.htaccess', '.cgi', '.pl', '.py',
                    '.jsp', '.asp', '.aspx', '.sh', '.bash', '.exe', '.bat', '.cmd',
                ];

                foreach ($dangerousExtensions as $ext) {
                    if (str_contains($originalName, $ext)) {
                        abort(422, 'File dengan ekstensi berbahaya tidak diizinkan.');
                    }
                }

                // 3. Scan file content for PHP code injection (skip binary image files)
                $binaryImageMimes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                
                if (!in_array($realMime, $binaryImageMimes)) {
                    $content = file_get_contents($file->getRealPath());
                    $suspiciousPatterns = [
                        '<?php',
                        '<?=',
                        '<script',
                        'eval(',
                        'base64_decode(',
                        'exec(',
                        'system(',
                        'passthru(',
                        'shell_exec(',
                        'popen(',
                        'proc_open(',
                        'assert(',
                        '$_GET',
                        '$_POST',
                        '$_REQUEST',
                        '$_FILES',
                        'file_put_contents(',
                        'fwrite(',
                        'move_uploaded_file(',
                    ];

                    foreach ($suspiciousPatterns as $pattern) {
                        if (stripos($content, $pattern) !== false) {
                            abort(422, 'File mengandung konten yang tidak diizinkan.');
                        }
                    }
                }
            }
        }

        return $next($request);
    }
}

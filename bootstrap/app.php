<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Global middleware - applies to ALL requests
        $middleware->append(\App\Http\Middleware\SecurityHeaders::class);
        $middleware->append(\App\Http\Middleware\BlockSuspiciousRequests::class);

        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminAuth::class,
            'admin.gate' => \App\Http\Middleware\AdminGate::class,
            'login.ratelimit' => \App\Http\Middleware\LoginRateLimiter::class,
            'sanitize.upload' => \App\Http\Middleware\SanitizeFileUpload::class,
            'permission' => \App\Http\Middleware\CheckPermission::class,
            'superadmin' => \App\Http\Middleware\SuperAdminOnly::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (\Throwable $e, $request) {
            // Skip untuk response JSON (API)
            if ($request->expectsJson()) {
                return null;
            }

            // Skip untuk error validasi (422) agar redirect back with errors tetap jalan
            if ($e instanceof \Illuminate\Validation\ValidationException) {
                return null;
            }

            // Skip untuk redirect responses
            if ($e instanceof \Illuminate\Http\Exceptions\HttpResponseException) {
                return null;
            }

            // Skip untuk 404 ModelNotFoundException (biar tetap 404)
            if ($e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
                return null;
            }

            // Skip untuk 404 NotFoundHttpException (halaman tidak ditemukan)
            if ($e instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
                return null;
            }

            // Simpan detail bug ke cache
            $bugId = \Illuminate\Support\Str::random(16);
            $bugData = [
                'code' => method_exists($e, 'getStatusCode') ? $e->getStatusCode() : 500,
                'exception' => get_class($e),
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'url' => $request->fullUrl(),
                'method' => $request->method(),
                'time' => now()->format('d M Y H:i:s'),
            ];
            cache()->put("bug_{$bugId}", $bugData, now()->addHours(6));

            $errorCode = $bugData['code'];

            return response()->view('errors.custom', compact('bugId', 'errorCode'), $errorCode);
        });
    })->create();

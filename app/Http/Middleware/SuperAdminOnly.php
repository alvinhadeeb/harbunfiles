<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SuperAdminOnly
{
    /**
     * Hanya superadmin yang bisa akses.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $admin = auth()->guard('admin')->user();

        if (!$admin || !$admin->isSuperAdmin()) {
            abort(403, 'Hanya Superadmin yang bisa mengakses halaman ini.');
        }

        return $next($request);
    }
}

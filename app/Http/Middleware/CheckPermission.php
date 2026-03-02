<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Cek apakah admin punya permission untuk fitur tertentu.
     * Superadmin selalu lolos.
     *
     * Usage di route: ->middleware('permission:berita')
     */
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        $admin = auth()->guard('admin')->user();

        if (!$admin) {
            return redirect()->route('minda.login');
        }

        if (!$admin->hasPermission($permission)) {
            abort(403, 'Anda tidak memiliki akses ke fitur ini.');
        }

        return $next($request);
    }
}

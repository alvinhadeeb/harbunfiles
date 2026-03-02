<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class LoginRateLimiter
{
    /**
     * Rate limit login attempts to prevent brute force attacks.
     * Max 5 attempts per 5 minutes per IP.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->isMethod('POST')) {
            $ip = $request->ip();
            $key = 'login_attempts:' . $ip;
            $maxAttempts = 5;
            $decayMinutes = 5;

            $attempts = Cache::get($key, 0);

            if ($attempts >= $maxAttempts) {
                $ttl = Cache::get($key . ':timer', 0);
                $remaining = max(1, ceil(($ttl - time()) / 60));
                
                return back()->withErrors([
                    'email' => "Terlalu banyak percobaan login. Coba lagi dalam {$remaining} menit.",
                ])->onlyInput('email');
            }

            $response = $next($request);

            // If login failed (redirected back with errors), increment counter
            if ($response->isRedirection() && session()->has('errors')) {
                $attempts++;
                Cache::put($key, $attempts, now()->addMinutes($decayMinutes));
                Cache::put($key . ':timer', now()->addMinutes($decayMinutes)->timestamp, now()->addMinutes($decayMinutes));
            } else {
                // Successful login - reset counter
                Cache::forget($key);
                Cache::forget($key . ':timer');
            }

            return $response;
        }

        return $next($request);
    }
}

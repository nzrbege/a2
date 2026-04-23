<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SecureHeaders
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        $csp = "default-src 'self'; " .
            "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.jsdelivr.net https://unpkg.com; " .
            "style-src 'self' 'unsafe-inline' https://fonts.bunny.net https://cdn.jsdelivr.net; " .
            "font-src 'self' https://fonts.bunny.net https://cdn.jsdelivr.net; " .
            "img-src 'self' data: https:; " .
            "connect-src 'self' https://cdn.jsdelivr.net ws://localhost:* http://localhost:*;";

        $response->headers->set('Content-Security-Policy', $csp);
        
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // 1. Mencegah kebocoran informasi alamat asal saat klik link keluar
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // 2. Menghapus header X-Powered-By (PHP) agar tidak terbaca ZAP
        if (function_exists('header_remove')) {
            header_remove('X-Powered-By');
        }

        $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', 'Sat, 01 Jan 2000 00:00:00 GMT');

        return $response;
    }
}
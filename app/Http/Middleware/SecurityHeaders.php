<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $cspValues = [
            "base-uri 'self'",
            "connect-src 'self'",
            "default-src 'self'",
            "img-src 'self' data:",
            "media-src 'self'",
            "object-src 'none'",
            "script-src 'self'",
            "style-src 'self'",
            "font-src 'self'"
        ];

        if (app()->isProduction()) {
            $response->headers->set('Content-Security-Policy', implode(";", $cspValues));
        }

        return $response;
    }
}

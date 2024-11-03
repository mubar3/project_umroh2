<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAjaxSource
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Jika permintaan adalah AJAX, lanjutkan
        if ($request->ajax() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            return $next($request);
        }

        // Jika bukan AJAX, tolak akses
        return response()->json(['error' => 'Unauthorized'], 403);
    }
}

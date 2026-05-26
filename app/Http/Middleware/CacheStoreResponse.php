<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CacheStoreResponse
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($request->isMethod('GET') && !$request->user() && $response->isSuccessful()) {
            $response->headers->set('Cache-Control', 'public, max-age=60, stale-while-revalidate=300');
        }

        return $response;
    }
}

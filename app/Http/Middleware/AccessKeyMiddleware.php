<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AccessKeyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return Response
     * @throws Exception
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->header('access_key')) {
            throw new Exception("access_key required");
        }

        if ($request->header('access_key') !== config('auth.access_key')) {
            throw new Exception("access_key incorrect");
        }

        return $next($request);
    }
}

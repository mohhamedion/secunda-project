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
        $accessKey = $request->header('x-access-key');
        if (!$accessKey) {
            throw new Exception("Access-token required");
        }

        if ($accessKey !== config('auth.access_key')) {
            throw new Exception("Access-token incorrect");
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class JwtLogged
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $u = $request->user();

        if (!isset($u)) {
            return response()->json([
                'errors' => [
                    '_' => 'Unauthorized',
                ]
            ], 401);
        }

        return $next($request);
    }
}

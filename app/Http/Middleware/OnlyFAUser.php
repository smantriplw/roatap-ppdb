<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OnlyFAUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (isset($user) && $user->status === 2) {
            return $next($request);
        } else {
            return response()->json([
                'errors' => ['_' => 'Unauthorized'],
            ], 401);
        }
    }
}

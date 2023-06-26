<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PesertaLogged
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth('archive')->check()) {
            return response()->json([
                'error' => 'Unauthorized',
            ], 401);
        }

        $now = Carbon::now(config('app.timezone'));
        $user = auth('archive')->user();

        if ($now >= Carbon::createFromFormat('Y-m-d', config('app.ppdb.registerClosed'), config('app.timezone')) || $now >= Carbon::createFromFormat('Y-m-d', config('app.ppdb.closed'), config('app.timezone'))) {
            return response()->json([
                'error' => 'PPDB registration closed',
            ], 401);
        } else if ($now >= Carbon::createFromFormat('Y-m-d', config('app.ppdb.preRegistration'), config('app.timezone')) && !isset($user->verificator_id)) {
            return response()->json([
                'error' => 'Not eligible',
            ], 401);
        }
        
        return $next($request);
    }
}

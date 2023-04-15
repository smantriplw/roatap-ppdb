<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\ApiController;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProfileController extends ApiController
{
    public function self(Request $request)
    {
        $u = $request->user();
        return response()->json([
            'data' => $u,
        ], isset($u) ? 200 : 401);
    }

    public function refresh()
    {
        $new_token = auth()->refresh(true);

        return response()->json([
            'data' => [
                'token' => $new_token,
                'expires_at' => Carbon::now(config('APP_TIMEZONE'))->timestamp + auth()->factory()->getTTL() * 60,
            ],
        ]);
    }
}

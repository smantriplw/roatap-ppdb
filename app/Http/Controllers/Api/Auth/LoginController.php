<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\ApiController;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class LoginController extends ApiController
{
    public function login(LoginRequest $request)
    {
        $creds = $request->collect();
        $user = User::where('email', $creds->get('email'))->orWhere(
            'username', strtolower($creds->get('username'))
        );
        if (!$user->exists()) {
            return response()->json([
                'error' => 'user doesn\'t exist',
            ], 401);
        }
        $user = $user->first();

        if (!Hash::check($creds['password'], $user->password)) {
            return response()->json([
                'errors' => 'Unauthorized',
            ], 401);
        }

        $token = auth()->login($user);
        return $this->respondWithToken($token);
    }

    protected function respondWithToken(string $token)
    {
        return response()->json([
            'data' => [
                'token' => $token,
                'expires_at' => Carbon::now(config('app.timezone'))->timestamp + auth()->factory()->getTTL() * 60,
            ],
        ]);
    }
}

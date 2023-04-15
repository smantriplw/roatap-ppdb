<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends ApiController
{
    public function login(Request $request)
    {
        $this->validate_request($request);

        $creds = $request->all();
        $user = User::where('username', '=', $creds['username']);
        if (!$user->exists()) {
            return response()->json([
                'errors' => ['_' => 'user doesn\'t exist'],
            ], 401);
        }
        $user = $user->first();

        if (!Hash::check($creds['password'], $user->password)) {
            return response()->json([
                'errors' => ['_' => 'Unauthorized'],
            ], 401);
        }

        $token = auth()->login($user);
        return $this->respondWithToken($token);
    }

    public function rules(): array
    {
        return [
            'username' => 'required',
            'password' => 'required|min:7'
        ];
    }

    protected function respondWithToken(string $token)
    {
        return response()->json([
            'data' => [
                'token' => $token,
                'expires' => auth()->factory()->getTTL() * 60,
            ],
        ]);
    }
}

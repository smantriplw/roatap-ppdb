<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\ApiController;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends ApiController
{
    public function register(RegisterRequest $request)
    {
        $this->validate_request($request);

        $creds = $request->collect();

        $user = User::where('email', $creds->get('email'))->orWhere('username', strtolower($creds->get('username')));
        if ($user->exists()) {
            return response()->json([
                'error' => 'user is exists',
            ], 400);
        }

        $user = new User();
        $user->username = strtolower($creds->get('username'));
        $user->email = $creds['email'];
        $user->status = 1;
        $user->password = Hash::make($creds->get('password'));

        if ($user->save()) {
            return response()->json([
                'data' => $user,
            ], 200);
        } else {
            return response()->json([
                'errors' => 'couldn\'t create the user',
            ], 400);
        }
    }
}

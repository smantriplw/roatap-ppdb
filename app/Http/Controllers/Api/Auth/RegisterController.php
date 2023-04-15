<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\ApiController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends ApiController
{
    public function rules(): array {
        return [
            'username' => 'required_without:email|min:4|max:20',
            'password' => 'required|min:7|max:30',
            'email' => 'required_without:username|unique|max:255',
        ];
    }

    public function register(Request $request)
    {
        $this->validate_request($request);

        $creds = $request->collect();

        $user = User::where('email', $creds->get('email'))->orWhere('username', strtolower($creds->get('username')));
        if ($user->exists()) {
            return response()->json([
                'errors' => [
                    '_' => 'user is exists',
                ],
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
                'errors' => ['_' => 'couldn\'t create the user'],
            ], 400);
        }
    }
}

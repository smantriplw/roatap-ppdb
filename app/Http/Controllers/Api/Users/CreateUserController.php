<?php
namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\ApiController;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateUserController extends ApiController
{
    public function create(RegisterRequest $request)
    {
        $rows = $request->all();

        $rows['password'] = Hash::make($rows['password']);
        $user = User::create($rows);

        return response()->json([
            'data' => $user,
        ]);
    }
}
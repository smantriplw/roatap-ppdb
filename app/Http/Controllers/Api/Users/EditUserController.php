<?php
namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\ApiController;
use App\Http\Requests\EditUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class EditUserController extends ApiController
{
    public function edit(EditUserRequest $request, int $id)
    {
        $rows = $request->all();

        $user = User::find($id);
        if (!isset($user))
        {
            return response('', 404);
        }

        if (isset($rows['password']))
            $rows['password'] = Hash::make($rows['password']);
        $user->update($rows);
        return response()->json([
            'data' => $user,
        ]);
    }
}
<?php
namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\ApiController;
use App\Models\User;
use Illuminate\Http\Request;

class DeleteUserController extends ApiController
{
    public function delete(Request $request, string $user_id)
    {
        $user = User::find($user_id);
        if (!isset($user)) {
            return response()->json([
                'errors' => ['_' => 'user doesn\'t exist']
            ], 400);
        } else if ($user->id === $request->user()->id) {
            return response()->json([
                'errors' => ['_' => 'you couldn\'t delete yourself'],
            ], 400);
        }

        if (User::destroy($user->id)) {
            return response()->json([
                'data' => $user,
            ], 200);
        } else {
            return response()->json([
                'errors' => ['_' => 'couldn\'t delete this user'],
            ], 400);
        }
    }
}
?>

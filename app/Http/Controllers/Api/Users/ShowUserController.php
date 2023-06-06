<?php
namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\ApiController;
use App\Models\User;
use Illuminate\Http\Request;

class ShowUserController extends ApiController
{
    public function show(Request $request, string $user_id)
    {
        $self = $request->user();

        if (strval($self->id) === $user_id || $self->status === 2) {
            $self = User::find($user_id);
            return response()->json([
                'data' => $self,
            ], isset($self) ? 200 : 404);
        } else {
            return response()->json([
                'errors' => ['_' => 'user doesn\'t exist'],
            ], 404);
        }
    }

    public function shows()
    {
        return response()->json([
            'data' => User::all(),
        ]);
    }
}
?>

<?php
namespace App\Http\Controllers\Api\Auth;
use App\Http\Controllers\ApiController;

class LogoutController extends ApiController {
    public function logout()
    {
        auth()->logout();

        return response()->json([
            'data' => [],
            'message' => 'OK',
        ]);
    }
}
?>

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
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
}

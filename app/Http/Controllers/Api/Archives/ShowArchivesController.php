<?php
namespace App\Http\Controllers\Api\Archives;

use App\Http\Controllers\ApiController;
use App\Models\Archive;
use Illuminate\Http\Request;

class ShowArchivesController extends ApiController
{
    public function show(Request $request)
    {
        $user = auth()->user();
        $isVerified = $request->exists('verified');

        $archives = Archive::where('verificator_id', $isVerified ? '!=' : '=', null)->cursorPaginate(
            request('limit', 25)
        );

        return response()->json([
            'data' => $archives,
        ]);
    }
}
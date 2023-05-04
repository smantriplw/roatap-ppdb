<?php
namespace App\Http\Controllers\Api\Archives;

use App\Http\Controllers\ApiController;
use App\Models\Archive;
use Illuminate\Http\Request;

class VerifyArchiveController extends ApiController
{
    public function verify(Request $request, string $id)
    {
        $user = $request->user();
        $archive = Archive::find($id);
        if (!isset($archive)) {
            return response()->json([
                'error' => 'Archive doesn\'t exist',
            ], 400);
        }

        $archive->update([
            'verificator_id' => $user->id,
        ]);

        return response()->json([
            'data' => 'Verified',
        ]);
    }
}
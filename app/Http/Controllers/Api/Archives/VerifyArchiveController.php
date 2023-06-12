<?php
namespace App\Http\Controllers\Api\Archives;

use App\Http\Controllers\Controller;
use App\Http\Requests\VerifyRequest;
use App\Models\Archive;
use App\Models\VerifyModel;

class VerifyArchiveController extends Controller
{
    public function verify(VerifyRequest $request, string $id)
    {
        $user = $request->user();
        $archive = Archive::find($id);
        if (!isset($archive) || $archive->verificator_id !== null) {
            return response()->json([
                'error' => 'Archive doesn\'t exist',
            ], 400);
        }

        $verifyMod = VerifyModel::create(array_merge($request->all(), [
            'archive_id' => $id,
        ]));

        $archive->update([
            'verificator_id' => $user->id,
        ]);

        return response()->json([
            'data' => $verifyMod,
        ]);
    }
}
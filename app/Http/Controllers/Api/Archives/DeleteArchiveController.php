<?php
namespace App\Http\Controllers\Api\Archives;

use App\Http\Controllers\ApiController;
use App\Models\Archive;
use Illuminate\Http\Request;

class DeleteArchiveController extends ApiController
{
    public function delete(Request $request, string $id)
    {
        $archive = Archive::find($id);

        if (!isset($archive)) {
            return response()->json([
                'error' => 'Couldn\'t find archive',
            ], 400);
        }

        if (isset($archive['verificator_id'])) {
            return response()->json([
                'error' => 'This archive is already verified, couldn\'t delete',
            ], 400);
        }

        if ($archive->delete()) {
            return response()->json([
                'data' => [],
                'message' => 'OK',
            ]);
        } else {
            return response()->json([
                'error' => 'Couldn\'t delete this archive',
            ], 500);
        }
    }
}
<?php
namespace App\Http\Controllers\Api\Archives;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckArchiveRequest;
use App\Models\Archive;

class CheckArchiveController extends Controller
{
    public function check(CheckArchiveRequest $request)
    {
        $archive = Archive::where('nisn', $request->input('nisn'));
        if ($archive->exists()) {
            return response()->json([
                'error' => 'This NISN is already registered',
            ], 400);
        }

        return response()->json([
            'error' => null,
            'data' => [],
            'message' => 'Pass',
        ]);
    }
}
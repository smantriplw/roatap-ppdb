<?php
namespace App\Http\Controllers\Api\Archives;

use App\Http\Controllers\ApiController;
use App\Http\Requests\AddArchiveRequest;
use App\Models\Archive;

class AddArchiveController extends ApiController
{
    public function store(AddArchiveRequest $request)
    {
        $rows = $request->input('*');

        $archive = Archive::where('nisn', $rows['nisn']);
        if ($archive->exists()) {
            return response()->json([
                'error' => 'This archive which contains NISN is exists',
            ], 400);
        }

        $archive = Archive::create([
            // ...
        ]);
        return response()->json([
            'error' => null,
            'data' => $archive,
        ]);
    }
}
<?php
namespace App\Http\Controllers\Api\Archives;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddArchiveRequest;
use App\Models\Archive;

class AddArchiveController extends Controller
{
    public function store(AddArchiveRequest $request)
    {
        $rows = $request->all();

        $archive = Archive::where('nisn', $rows['nisn']);
        if ($archive->exists()) {
            return response()->json([
                'error' => 'This archive which contains NISN is exists',
            ], 400);
        }

        unset($rows['_gtoken']);
        $archive = Archive::create($rows);
        return response()->json([
            'error' => null,
            'data' => $archive,
        ]);
    }
}
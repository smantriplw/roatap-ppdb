<?php
namespace App\Http\Controllers\Api\NilaiSemester;

use App\Http\Controllers\ApiController;
use App\Http\Requests\SetNilaiSemesterRequest;
use App\Models\Archive;
use App\Models\NilaiSemester;

class SetNilaiSemesterController extends ApiController
{
    public function store(SetNilaiSemesterRequest $request, string $nisn)
    {
        $rows = $request->all();
        $archive = Archive::where('nisn', $nisn);
        if (!isset($archive)) {
            return response()->json([
                'error' => 'Archive doesn\'t exist',
            ]);
        } else if (strtotime($rows['birthday']) != strtotime($archive->value('birthday'))) {
            return response()->json([
                'error' => 'Birth doesn\'t match',
            ]);
        }

        unset($rows['birthday']);
        
        $result = NilaiSemester::upsert($rows, ['lesson'], ['s1', 's2', 's3', 's4', 's5']);

        return response()->json([
            'data' => $result,
            'message' => 'OK',
        ]);
    }
}
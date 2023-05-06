<?php
namespace App\Http\Controllers\Api\NilaiSemester;

use App\Http\Controllers\ApiController;
use App\Http\Requests\SetNilaiSemesterRequest;
use App\Models\NilaiSemester;

class SetNilaiSemesterController extends ApiController
{
    public function store(SetNilaiSemesterRequest $request)
    {
        $rows = $request->all();
        $rows['archive_id'] = auth('archive')->user()->id;
        $result = NilaiSemester::upsert($rows, ['lesson', 'archive_id'], ['s1', 's2', 's3', 's4', 's5']);

        return response()->json([
            'data' => $result,
            'message' => 'OK',
        ]);
    }
}
<?php
namespace App\Http\Controllers\Api\NilaiSemester;

use App\Http\Controllers\ApiController;
use App\Http\Requests\SetNilaiSemesterRequest;
use App\Http\Requests\SetsNilaiSemesterRequest;
use App\Models\NilaiSemester;

class SetNilaiSemesterController extends ApiController
{
    public function store(SetNilaiSemesterRequest $request)
    {
        $rows = $request->all();
        $result = NilaiSemester::upsert(array_merge($rows, [
            'archive_id' => auth('archive')->user()->id,
        ]), ['lesson', 'archive_id'], ['s1', 's2', 's3', 's4', 's5']);

        return response()->json([
            'data' => $result,
            'message' => 'OK',
        ]);
    }

    public function store_array(SetsNilaiSemesterRequest $request)
    {
        $user = auth('archive')->user();

        $rows = $request->all();
        $rows = collect($rows);

        $rows->each(function(mixed $value) {
            NilaiSemester::upsert(array_merge($value, [
                'archive_id' => $value,
            ]), ['lesson', 'archive_id'], ['s1', 's2', 's3', 's4', 's5']);
        });

        return response()->json([
            'data' => $rows->toArray(),
            'message' => 'OK',
        ]);
    }
}
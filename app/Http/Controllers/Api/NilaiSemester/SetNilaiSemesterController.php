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
        $rows['archive_id'] = auth('archive')->user()->id;
        $result = NilaiSemester::upsert($rows, ['lesson', 'archive_id'], ['s1', 's2', 's3', 's4', 's5']);

        return response()->json([
            'data' => $result,
            'message' => 'OK',
        ]);
    }

    public function store_array(SetsNilaiSemesterRequest $request)
    {
        $rows = $request->all();
        $rows = collect($rows);

        $rows->transform(function (mixed $value) {
            $value['archive_id'] = auth('archive')->user()->id;
            if (isset($value['_key']))
                unset($value['_key']);

            return $value;
        });

        $result = NilaiSemester::upsert($rows->toArray(), ['lesson', 'archive_id'], ['s1', 's2', 's3', 's4', 's5']);
        return response()->json([
            'data' => $result,
            'message' => 'OK',
        ]);
    }
}
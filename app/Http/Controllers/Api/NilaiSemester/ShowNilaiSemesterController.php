<?php
namespace App\Http\Controllers\Api\NilaiSemester;

use App\Http\Controllers\Controller;
use App\Models\NilaiSemester;

class ShowNilaiSemesterController extends Controller
{
    public function show()
    {
        $u = auth('archive')->user();
        $data = NilaiSemester::all()->whereStrict('archive_id', $u->id)->toArray();
        return response()->json([
            'error' => null,
            'data' => array_values($data),
            'message' => 'fetched',
        ]);
    }
}
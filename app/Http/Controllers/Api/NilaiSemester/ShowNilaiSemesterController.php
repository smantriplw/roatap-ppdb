<?php
namespace App\Http\Controllers\Api\NilaiSemester;

use App\Http\Controllers\Controller;
use App\Models\Archive;
use App\Models\NilaiSemester;

class ShowNilaiSemesterController extends Controller
{
    public function show()
    {
        $u = auth('archive')->user();

        return response()->json([
            'error' => null,
            'data' => NilaiSemester::all()->where('archive_id', '=', $u->id),
            'message' => 'fetched',
        ]);
    }
}
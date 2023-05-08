<?php
namespace App\Http\Controllers\Api\NilaiSemester;

use App\Http\Controllers\Controller;
use App\Models\Archive;

class ShowNilaiSemesterController extends Controller
{
    public function show()
    {
        $u = auth('archive')->user();

        $archive = Archive::find($u->id);
        return response()->json([
            'error' => null,
            'data' => $archive->nilai(),
            'message' => 'fetched',
        ]);
    }
}
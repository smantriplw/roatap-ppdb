<?php
namespace App\Http\Controllers\Api\Peserta;

use App\Http\Controllers\Controller;
use App\Models\NilaiSemester;

class ShowPesertaController extends Controller
{
    public function show()
    {
        $user = auth('archive')->user();
        $zeroPoints = NilaiSemester::where('archive_id', $user->id)->where(function ($query) {
            return $query->where('s1', 0)->orWhere('s2', 0)->orWhere('s3', 0)->orWhere('s4', 0)->orWhere('s5', 0);
        });

        return response()->json([
            'error' => null,
            'data' => array_merge(json_decode(json_encode($user), true), [
                'nilai_completed' => !$zeroPoints->exists(), 
            ]),
            'message' => 'OK',
        ]);
    }
}
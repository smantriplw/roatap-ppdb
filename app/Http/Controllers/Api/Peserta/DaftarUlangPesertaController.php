<?php
namespace App\Http\Controllers\Api\Peserta;

use App\Http\Controllers\Controller;
use App\Http\Requests\DaftarUlangRequest;
use App\Models\DaftarUlangModel;

class DaftarUlangPesertaController extends Controller
{
    public function currentState()
    {
        $user = auth('archive')->user();
        if ($user->verificator_id === null) {
            return response()->json([
                'error' => 'You aren\'t able to fill this form',
            ]);
        }
        

        return response()->json([
            'data' => $user->daftarUlang,
        ]);
    }

    public function updateState(DaftarUlangRequest $request)
    {
        $user = auth('archive')->user();
        if ($user->verificator_id === null) {
            return response()->json([
                'error' => 'You aren\'t able to fill this form',
            ]);
        }
    
        $daftarUlang = DaftarUlangModel::updateOrCreate([
            'archive_id' => auth('archive')->user()->id,
        ], $request->all());

        return response()->json([
            'data' => $daftarUlang,
        ]);
    }
}
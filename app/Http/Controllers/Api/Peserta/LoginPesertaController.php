<?php
namespace App\Http\Controllers\Api\Peserta;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginPesertaRequest;
use App\Models\Archive;
use Carbon\Carbon;

class LoginPesertaController extends Controller
{
    protected function __todatestr(string $birth): string
    {
        $date = trim(explode(',', $birth)[1]);
        $datec = Carbon::parseFromLocale($date, 'id_ID');
        return $datec->format('dmY');
    }

    public function login(LoginPesertaRequest $request)
    {
        $archive = Archive::where('nisn', $request->input('nisn'));
        if (!$archive->exists()) {
            return response()->json([
                'error' => 'This NISN doesn\'t exist',
            ]);
        }

        if ($this->__todatestr($archive->value('birthday')) !== $request->input('birth')) {
            return response()->json([
                'error' => 'Birthday doesn\'t match',
            ]);
        }

        $token = auth('archive')->login($archive);
        return response()->json([
            'error' => null,
            'data' => [
                'token' => $token,
                'expires_at' => Carbon::now(config('app.timezone'))->timestamp + auth()->factory()->getTTL() * 60,
            ],
        ]);
    }

    public function refresh()
    {
        if (!auth('archive')->check()) {
            return response('Unauthorized', 401);
        }

        $token = auth('archive')->refresh(true);

        return response()->json([
            'error' => null,
            'data' => [
                'token' => $token,
                'expires_at' => Carbon::now(config('app.timezone'))->timestamp + auth()->factory()->getTTL() * 60,
            ],
        ]);
    }
}
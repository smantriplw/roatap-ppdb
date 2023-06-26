<?php
namespace App\Http\Controllers\Api\Archives;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddArchiveRequest;
use App\Models\Archive;
use Carbon\Carbon;

class AddArchiveController extends Controller
{
    public function store(AddArchiveRequest $request)
    {
        $rows = $request->all();

        $now = Carbon::now(config('app.timezone'));
        $registerClosed = Carbon::createFromFormat('Y-m-d', config('app.ppdb.registerClosed'), config('app.timezone'));

        if ($now->gt($registerClosed)) {
            return response()->json([
                'error' => 'registration closed',
            ], 401);
        }

        $archive = Archive::where('nisn', $rows['nisn']);
        if ($archive->exists()) {
            return response()->json([
                'error' => 'This archive which contains NISN is exists',
            ], 400);
        }

        unset($rows['_gtoken']);
        $archive = Archive::create($rows);
        return response()->json([
            'error' => null,
            'data' => $archive,
        ]);
    }
}
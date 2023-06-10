<?php
namespace App\Http\Controllers\Api\Archives;

use App\Http\Controllers\Controller;
use App\Http\Requests\ConfirmRequest;
use App\Models\WawancaraConfirmModel;

class ConfirmArchiveController extends Controller
{
    public function confirm(ConfirmRequest $request)
    {
        $confirmed = WawancaraConfirmModel::where('archive_id', auth('archive')->user()->id);
        if (!$confirmed->exists()) {
            $confirmed = WawancaraConfirmModel::create(array_merge($request->all(), [
                'archive_id' => auth('archive')->user()->id,
            ]));

            return response()->json([
                'data' => $confirmed,
            ]);
        } else {
            return response()->json([
                'error' => 'Response exists',
            ], 401);
        }
    }

    public function showConfirmResponse()
    {
        $confirmed = WawancaraConfirmModel::where('archive_id', auth('archive')->user()->id);
        if (!$confirmed->exists()) {
            return response()->json([
                'data' => null,
            ]);
        }

        return response()->json([
            'data' => $confirmed->value('confirm'),
        ]);
    }
}
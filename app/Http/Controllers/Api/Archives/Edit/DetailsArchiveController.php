<?php
namespace App\Http\Controllers\Api\Archives\Edit;

use App\Http\Controllers\Controller;
use App\Http\Requests\EditDetailsArchiveRequest;
use App\Models\Archive;

class DetailsArchiveController extends Controller
{
    public function edit(EditDetailsArchiveRequest $request)
    {
        $archive = Archive::find(auth('archive')->user()->id);
        $rows = $request->all();

        $archive->update($rows);
        return response()->json([
            'message' => 'Details updated',
            'error' => null,
            'data' => [],
        ]);
    }
}
<?php
namespace App\Http\Controllers\Api\Archives;

use App\Http\Controllers\ApiController;
use App\Models\Archive;
use Illuminate\Http\Request;

class ShowArchivesController extends ApiController
{
    public function show(Request $request)
    {
        $user = auth()->user();
        $isVerified = $request->exists('verified');

        $perPage = request('offset', 25);
        $page    = request('page', 1);

        $paginator = Archive::where('verificator_id', $isVerified ? '!=' : '=', null)->paginate(
            $perPage,
            '*',
            'archives',
            $page
        );

        $currPage = $paginator->currentPage();

        return response()->json([
            'data' => [
                'archives' => $paginator->items(),
                'prev' => $currPage === 1 ? 1 : $currPage-1,
                'next' => $currPage === $paginator->lastPage() ? $currPage : $currPage+1,
            ]
        ]);
    }
}
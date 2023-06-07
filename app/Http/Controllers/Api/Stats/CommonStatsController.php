<?php
namespace App\Http\Controllers\Api\Stats;

use App\Http\Controllers\ApiController;
use App\Models\Archive;
use Carbon\Carbon;

class CommonStatsController extends ApiController
{
    public function view()
    {
        $users = Archive::all();

        return [
            'archives' => [
                'all' => $users->count(),
                'complete' => $users->where('skhu_path', '!=', null)->count(),
                'daily' => [
                    'todayCount' => $users->where('created_at', '>=', Carbon::today())->count(),
                    'lastWeek' => $users->where('created_at', '>=', Carbon::today()->subDays(7))->count(),

                    'todayVerified' => $users->where('updated_at', '>=', Carbon::today())->where('verificator_id', '!=', null)->count(),
                ],
                'specified' => $users->countBy('type'),
                'verified' => $users->where('verificator_id', '!=', null)->count(),
                'nonVerified' => $users->where('verificator_id', '=', null)->count(),
            ],
        ];
    }
}
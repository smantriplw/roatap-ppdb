<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class ApiController extends Controller
{
    use ValidatesRequests, AuthorizesRequests, DispatchesJobs;

    public function __invoke()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }
}

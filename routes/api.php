<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\ProfileController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Middleware\JwtLogged;
use App\Http\Middleware\OnlyActiveUser;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function() {
    Route::post('register', [RegisterController::class, 'register'])->middleware([
        JwtLogged::class,
        OnlyActiveUser::class,
    ]);
    Route::post('login', [LoginController::class, 'login'])->middleware('guest');
    Route::get('profile', [ProfileController::class, 'self'])->middleware([
        JwtLogged::class,
    ]);
});

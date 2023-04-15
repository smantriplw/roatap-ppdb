<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\ProfileController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Users\DeleteUserController;
use App\Http\Controllers\Api\Users\ShowUserController;
use App\Http\Middleware\JwtLogged;
use App\Http\Middleware\OnlyFAUser;
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

// /api/auth
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function() {
    Route::post('register', [RegisterController::class, 'register'])->middleware([
        JwtLogged::class,
        OnlyFAUser::class,
    ]);
    Route::post('login', [LoginController::class, 'login'])->middleware('guest');
    Route::get('logout', [LogoutController::class, 'logout'])->middleware([
        JwtLogged:: class,
    ]);
    Route::get('profile', [ProfileController::class, 'self'])->middleware([
        JwtLogged::class,
    ]);
    Route::post('refresh', [ProfileController::class, 'refresh'])->middleware([
        JwtLogged::class,
    ]);
});

// /api/users
Route::group([
    'middleware' => 'api',
    'prefix' => 'users',
], function() {
    Route::delete('{id}', [DeleteUserController::class, 'delete'])->middleware([
        JwtLogged::class,
        OnlyFAUser::class,
    ]);
    Route::get('{id}', [ShowUserController::class, 'show'])->middleware([
        JwtLogged::class,
    ]);
});

<?php

use App\Http\Controllers\Api\Archives\AddArchiveController;
use App\Http\Controllers\Api\Archives\CheckArchiveController;
use App\Http\Controllers\Api\Archives\DeleteArchiveController;
use App\Http\Controllers\Api\Archives\Edit\DetailsArchiveController;
use App\Http\Controllers\Api\Archives\Edit\UploadArchiveController;
use App\Http\Controllers\Api\Archives\EditArchiveController;
use App\Http\Controllers\Api\Archives\VerifyArchiveController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\ProfileController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\NilaiSemester\SetNilaiSemesterController;
use App\Http\Controllers\Api\NilaiSemester\ShowNilaiSemesterController;
use App\Http\Controllers\Api\Peserta\KartuPendaftaranController;
use App\Http\Controllers\Api\Peserta\LoginPesertaController;
use App\Http\Controllers\Api\Users\DeleteUserController;
use App\Http\Controllers\Api\Users\ShowUserController;
use App\Http\Middleware\JwtLogged;
use App\Http\Middleware\OnlyActiveUser;
use App\Http\Middleware\PesertaLogged;
use App\Models\NilaiSemester;
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
        OnlyActiveUser::class,
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
        OnlyActiveUser::class,
    ]);
    Route::get('{id}', [ShowUserController::class, 'show'])->middleware([
        JwtLogged::class,
    ]);
});

// /api/archives
Route::group([
    'middleware' => 'api',
    'prefix' => 'archives',
], function() {
    Route::post('/check', [CheckArchiveController::class, 'check']);
    Route::post('/', [AddArchiveController::class, 'store'])->middleware('guest');
    Route::delete('/{id}', [DeleteArchiveController::class, 'delete'])->middleware([
        JwtLogged::class,
        OnlyActiveUser::class,
    ]);
    Route::post('/{id}/verify', [VerifyArchiveController::class, 'verify'])->middleware([
        JwtLogged::class,
        OnlyActiveUser::class,
    ]);
    Route::post('/edit', [EditArchiveController::class, 'edit'])->middleware([
        PesertaLogged::class,
    ]);
    Route::post('/edit/files', [UploadArchiveController::class, 'upload'])->middleware([
        PesertaLogged::class,
    ]);
    Route::post('/edit/details', [DetailsArchiveController::class, 'edit'])->middleware([
        PesertaLogged::class,
    ]);
    Route::post('/edit/nilai', [SetNilaiSemesterController::class, 'store'])->middleware([
        PesertaLogged::class,
    ]);
});

// /api/peserta
Route::group([
    'middleware' => 'api',
    'prefix'     => 'peserta',
], function() {
    Route::post('/login', [LoginPesertaController::class, 'login'])->middleware('guest');
    Route::post('/refresh', [LoginPesertaController::class, 'refresh'])->middleware([
        PesertaLogged::class,
    ]);
    Route::get('/', function() {
        $user = auth('archive')->user();
        $zeroPoints = NilaiSemester::where('archive_id', $user->id)->where(function ($query) {
            return $query->where('s1', 0)->orWhere('s2', 0)->orWhere('s3', 0)->orWhere('s4', 0)->orWhere('s5', 0);
        });

        return response()->json([
            'error' => null,
            'data' => array_merge(json_decode(json_encode($user), true), [
                'nilai_completed' => !$zeroPoints->exists(), 
            ]),
            'message' => 'OK',
        ]);
    })->middleware([
        PesertaLogged::class,
    ]);

    Route::get('/card', [KartuPendaftaranController::class, 'show'])->middleware([
        PesertaLogged::class,
    ]);

    Route::get('/nilai', [ShowNilaiSemesterController::class, 'show'])->middleware([
        PesertaLogged::class,
    ]);
    Route::post('/nilai', [SetNilaiSemesterController::class, 'store_array'])->middleware([
        PesertaLogged::class,
    ]);
});

<?php

use App\Http\Resources\Centers\CenterProfileCollection;
use App\Http\Resources\UserResource;
use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\User\UserController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'postLogin']);

    Route::middleware('auth:api')->group(function () {
        Route::get('me', [AuthController::class, 'getMe']);
        Route::post('logout', [AuthController::class, 'postLogout']);
    });
});

Route::prefix('user')->group(function () {
    Route::post('save', [UserController::class, 'postRegister']);
});



<?php

use App\Http\Controllers\API\RaftCompany\RaftCompany;
use App\Http\Controllers\API\TaslemMaintenance\TaslemMaintainance;
use App\Http\Controllers\API\User\UserController;
use App\Http\Resources\UserResource;
use App\Http\Controllers\API\Auth\AuthController;
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

    Route::middleware('APIUserAuth')->group(function () {
        Route::get('me', [AuthController::class, 'getMe']);
        Route::post('logout', [AuthController::class, 'postLogout']);


    });

});
Route::middleware(['APIUserAuth', 'MaintenanceAuth'])->prefix('maintenance')->group(function () {
    Route::get('sessions/{list_type?}', [TaslemMaintainance::class, 'sessions']);
    Route::get('not_published_sessions', [TaslemMaintainance::class, 'not_published_sessions']);
    Route::get('company_box', [TaslemMaintainance::class, 'company_box']);
    Route::post('save_session', [TaslemMaintainance::class, 'save_session']);
    Route::post('publish_sessions', [TaslemMaintainance::class, 'publish_sessions']);
    Route::post('upload_file', [TaslemMaintainance::class, 'upload_file']);
    Route::post('save_note', [TaslemMaintainance::class, 'save_note']);
    Route::post('delete_session', [TaslemMaintainance::class, 'delete_session']);
});
Route::middleware(['APIUserAuth', 'RaftCompanyAuth'])->prefix('raft')->group(function () {
    Route::get('sessions',[RaftCompany::class, 'sessions']);
    Route::get('file',[RaftCompany::class, 'docx_file']);
    Route::post('seen',[RaftCompany::class, 'seen_maintain_file']);
});
Route::prefix('user')->group(function () {
    Route::post('save', [UserController::class, 'postRegister']);
});






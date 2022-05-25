<?php

use App\Http\Resources\Centers\CenterProfileCollection;
use App\Http\Resources\UserResource;
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



Route::post('test/login', function (Request $request) {
    $user = User::query()->where('name', $request['user_name'])->first();
    if (!$user) {
        return api(false, 400, 'الرجاء إدخال كلمة مرور صحيحة')->get();
    }

    if ($user->enabled == 0) {

        return api(false, 400, 'حسابك معلق حاليا الرجاء التواصل مع الإدارة')->get();
    }

    if (!Hash::check($request['password'], $user->password)) {

        return api(false, 400, 'الرجاء إدخال كلمة مرور صحيحة')->get();
    }


    $user = User::query()->where('name', request('user_name'))->first();
    $token = $user->createToken('Token Name',['centers'])->accessToken;
    $user->access_token = 'Bearer ' . $token->token;
    $token->save();
    return api(true, 200, __('api.success_login'))
        ->add('user', new UserResource($user))
        ->get();

});

<?php
namespace App\Http\Controllers\API\Auth;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function postLogin(Request $request)
    {
        $user = User::query()->where('name', $request->username)->first();
        if (!$user) {
            return api(false, 400, 'الرجاء إدخال كلمة مرور صحيحة')->get();
        }

        if ($user->enabled == 0) {

            return api(false, 400, 'حسابك معلق حاليا الرجاء التواصل مع الإدارة')->get();
        }

        if (!Hash::check($request['password'], $user->password)) {

            return api(false, 400, 'الرجاء إدخال كلمة مرور صحيحة')->get();
        }


        $tokenResult = $user->createToken('users', ['users']);
        $token = $tokenResult->token;
        $token->save();
        $user->access_token = 'Bearer ' . $tokenResult->accessToken;

        return api(true, 200,'تم تسجيل الدخول بنجاح')
            ->add('user', new UserResource($user))
            ->get();
    }

    public function postLogout(Request $q) {
        $user = Auth::user()->token();
        $user->revoke();
        return api(true, 200,'تم تسجيل الخروج بنجاح')
            ->get();
    }

    public function getMe(Request $q)
    {

        $User = new UserResource(auth('users')->user());
        return api(true, 200,null)
            ->add('user', $User)
            ->get();
    }

}

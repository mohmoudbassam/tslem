<?php

namespace App\Http\Controllers\CP;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index()
    {
        if(auth()->check()){
            if(auth()->user()->type == 'admin'){
                return redirect()->route('users.dashboard');
            }
            $user_type=auth()->user()->type;

            if(auth()->user()->type == 'admin'){
                return redirect()->route('users.dashboard');
            }
            if(auth()->user()->type=='service_provider'){

                return redirect()->route('services_providers');

            }
            if(auth()->user()->type=='Delivery'){
                return redirect()->route('delivery');
            }
            return redirect()->route($user_type);
        }
        return view('CP.login');
    }

    public function login(Request $request)
    {
        $user=User::query()->where('name' , $request['user_name'])->first();
        if(!$user){
            return back()->with('validationErr','الرجاء إدخال كلمة مرور صحيحة');
        }

        if( !Hash::check($request['password'], $user->password)){
            return back()->with('validationErr','الرجاء إدخال كلمة مرور صحيحة');
        }

        if($user->enabled ==0){
            return back()->with('validationErr','حسابك معلق حاليا الرجاء التواصل مع الإدارة');
        }
        if (Auth::attempt(['name' => $request['user_name'], 'password' => $request['password'], 'enabled' => 1], isset($request->remember))) {
            $user_type=auth()->user()->type;
            if(auth()->user()->type == 'admin'){
                return redirect()->route('users.dashboard');
            }
            if(auth()->user()->type=='service_provider'){
                return redirect()->route('services_providers.orders');
            }
            if(auth()->user()->type=='Delivery'){
                return redirect()->route('delivery');
            }
            if(auth()->user()->type=='design_office'){
                return redirect()->route('design_office.orders');
            }

            return redirect()->route($user_type);
        } else {
            return back()->with('validationErr','الرجاء إدخال كلمة مرور صحيحة');
        }
    }

    public function logout()
    {
        auth()->logout();

        return redirect()->route('login_page');
    }
    public function dashboard(Request $request)
    {
        $data['number_of_user']=User::query()->count();
        $data['number_of_user_under_approve']=User::query()->where('verified',0)->count();
        $data['number_of_approve_user']=User::query()->where('verified',1)->count();
        $data['number_of_service_providers']=User::query()->where('type','service_provider')->where('verified',1)->count();
        $data['number_of_contractors']=User::query()->where('type','contractor')->where('verified',1)->count();
        $data['number_of_consulting_office']=User::query()->where('type','consulting_office')->where('verified',1)->count();
        return view('CP.dashboard',$data);

    }
}

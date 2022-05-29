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
                return redirect()->route('dashboard');
            }
            $user_type=auth()->user()->type;

            if(auth()->user()->type == 'admin'){
                return redirect()->route('dashboard');
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
                return redirect()->route('dashboard');
            }
            if(auth()->user()->type=='service_provider'){
                return redirect()->route('services_providers');
            }
            if(auth()->user()->type=='Delivery'){
                return redirect()->route('delivery');
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
        $all_user = User::count();
        $not_verified = User::where('verified',0)->count();
        $verified = User::where('verified',1)->count();
        $service_providers = User::where('type','service_provider')->count() + User::where('type','raft_center')->count() ;
        $contractors= User::where('type','contractor')->count();
        $design_offices = User::where('type','design_office')->count();

        
        return view('CP.master', compact('all_user','not_verified','verified','service_providers','contractors','design_offices'));
    }
}

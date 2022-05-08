<?php

namespace App\Http\Controllers\CP;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {

        if(auth()->check()){

            return redirect()->route('dashboard');
        }
        return view('CP.login');
    }

    public function login(Request $request)
    {

        if (Auth::attempt(['name' => $request['user_name'], 'password' => $request['password'], 'enabled' => 1], isset($request->remember))) {

            return redirect()->route('dashboard');
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
        return view('CP.master');
    }
}

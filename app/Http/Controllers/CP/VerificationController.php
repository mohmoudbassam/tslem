<?php

namespace App\Http\Controllers\CP;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Mail; 
use App\Models\EmailVerification;
use App\Mail\VerifyUserEmail;

class VerificationController extends Controller{

    public function verify(){

        if(auth()->user()->email_verified_at != NULL){
            return redirect()->route('dashboard');
        }

        $token = Str::random(64);
        
        $verification = EmailVerification::where('user_id', auth()->user()->id)->first();
        if(is_null($verification)){

            EmailVerification::create([
                'user_id' => auth()->user()->id, 
                'token' => $token
          ]);
          
          Mail::to(auth()->user()->email)->send(new VerifyUserEmail($token));


        }
            return view('CP.verify');
       
        
    }


    public function verify_account($token){

        $verification = EmailVerification::where('token', $token)->first();
        if(!is_null($verification)){
            $user = User::find($verification->user_id);
            if(is_null($user->email_verified_at)){
                $user->update([
                    'email_verified_at' => now()
                ]);
                $verification->delete();
                return redirect()->route('dashboard');
            }

        }
        abort(404);
    }

}

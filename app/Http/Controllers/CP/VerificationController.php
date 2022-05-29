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
use App\Http\Requests\CP\User\UploadFilesRequest;
use Illuminate\Support\Facades\Storage;
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


    public function upload_files(){

        if(auth()->user()->is_file_uploaded == true){
            return redirect()->route('dashboard');
        }

        $type = (is_null(auth()->user()->type)) ? 'service_provider' : auth()->user()->type;
        $record = \App\Models\BeneficiresCoulumns::query()->where('type', $type)->first();

        $col_file = get_user_column_file($type);
        if(empty($col_file)){
            auth()->user()->update(['is_file_uploaded' => true]);
            return redirect()->route('dashboard');
        }
        return view('CP.upload_files', compact('type','record','col_file'));
    }

    public function save_upload_files(UploadFilesRequest $request)
    {

        auth()->user()->update([
            'commercial_file_end_date' => request('commercial_file_end_date'),
            'rating_certificate_end_date' => request('rating_certificate_end_date'),
            'profession_license_end_date' => request('profession_license_end_date'),
            'business_license_end_date' => request('business_license_end_date'),
            'social_insurance_certificate_end_date' => request('social_insurance_certificate_end_date'),
            'date_of_zakat_end_date' => request('date_of_zakat_end_date'),
            'saudization_certificate_end_date' => request('saudization_certificate_end_date'),
            'chamber_of_commerce_certificate_end_date' => request('chamber_of_commerce_certificate_end_date'),
            'hajj_service_license_end_date' => request('hajj_service_license_end_date'),
            'is_file_uploaded' => 1
        ]);

        $this->uploadUserFiles(auth()->user(), $request);
        // if(auth()->user()->type == 'contractor'){
        //     $path = Storage::disk('public')->put('user_files', $request->cv_file);
        //     auth()->user()->update([
        //        'cv_file' => $path
        //     ]);
        // }
        return back()->with(['success' => 'تم رفع الملفات بنجاح']);
    }

    private function uploadUserFiles($user, $file)
    {
        $columns_name = get_user_column_file($user->type);
        if (!empty($columns_name)) {
            $files = request()->all(array_keys(get_user_column_file($user->type)));

            foreach ($files as $col_name => $file) {

                if(!is_null($file)){
                    $file_name = $file->getClientOriginalName();
                    $path = Storage::disk('public')->put('user_files', $file);
                    $user->{$col_name} = $path;
                }

            }
            $user->save();
        }

    }


}

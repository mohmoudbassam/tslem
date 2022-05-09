<?php

namespace App\Http\Controllers\CP;

use App\Http\Controllers\Controller;
use App\Http\Requests\CP\User\StoreUserRequest;
use App\Models\BeneficiresCoulumns;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RegisterController extends Controller
{

    public function index(Request $request) {
        if(auth()->check()){
            redirect()->route('dashboard');
        }
        $data['record'] = BeneficiresCoulumns::query()->where('type', $request->type)->firstOrFail();
        return view('CP.register', $data);
    }

    public function add_edit(StoreUserRequest $request)
    {
        $user = User::query()->create([
            'type' => request('type'),
            'name' => request('name'),
            'company_name' => request('company_name'),
            'company_type' => request('company_type'),
            'company_owner_name' => request('company_owner_name'),
            'commercial_record' => request('commercial_record'),
            'website' => request('website'),
            'responsible_name' => request('responsible_name'),
            'id_number' => request('id_number'),
            'id_date' => request('id_date'),
            'source' => request('source'),
            'email' => request('email'),
            'phone' => request('phone'),
            'address' => request('address'),
            'telephone' => request('telephone'),
            'city' => request('city'),
            'employee_number' => request('employee_number'),
            'password' => request('password'),
            'verified'=>0
        ]);
        $this->uploadUserFiles($user,$request);
        return back()->with(['success' => 'تمت عمليه الإضافة بنجاح']);
    }

    private function uploadUserFiles($user,$file){
        $columns_name =get_user_column_file($user->type);
        if(!empty($columns_name)){
            $files=request()->all(array_keys(get_user_column_file($user->type)));
            foreach ($files as $col_name=>$file) {
                $file_name = $file->getClientOriginalName();

                $path = Storage::disk('public')->put('user_files', $file);

                $user->{$col_name}=$path;

            }
            $user->save();
        }

    }
}

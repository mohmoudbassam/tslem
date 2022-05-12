<?php

namespace App\Http\Controllers\CP;

use App\Http\Controllers\Controller;
use App\Http\Requests\CP\User\StoreUserRequest;
use App\Models\BeneficiresCoulumns;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RegisterController extends Controller
{

    public function index(Request $request)
    {

        if (auth()->check()) {

            redirect()->route('dashboard');
        }
              if($request->type){
                  $type=request('type');
              }else{
                  $type='service_provider';
              }
        $data['record'] = BeneficiresCoulumns::query()->where('type',$type)->firstOrFail();

//        $record = BeneficiresCoulumns::query()->where('type', $type)->firstOrFail();
        $data['col_file'] = get_user_column_file($type);

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
            'id_date' => Carbon::parse(request('id_date'))->format('Y-m-d'),
            'source' => request('source'),
            'email' => request('email'),
            'phone' => request('phone'),
            'address' => request('address'),
            'telephone' => request('telephone'),
            'city' => request('city'),
            'employee_number' => request('employee_number'),
            'password' => request('password'),
            'verified' => 0,
            'commercial_file_end_date' => request('commercial_file_end_date'),
            'rating_certificate_end_date' => request('rating_certificate_end_date'),
            'profession_license_end_date' => request('profession_license_end_date'),
            'business_license_end_date' => request('business_license_end_date'),
            'social_insurance_certificate_end_date' => request('social_insurance_certificate_end_date'),
            'date_of_zakat_end_date' => request('date_of_zakat_end_date'),
            'saudization_certificate_end_date' => request('saudization_certificate_end_date'),
            'chamber_of_commerce_certificate_end_date' => request('chamber_of_commerce_certificate_end_date'),

        ]);
        $this->uploadUserFiles($user, $request);
        return back()->with(['success' => 'تمت عمليه الإضافة بنجاح']);
    }

    private function uploadUserFiles($user, $file)
    {
        $columns_name = get_user_column_file($user->type);
        if (!empty($columns_name)) {
            $files = request()->all(array_keys(get_user_column_file($user->type)));
            foreach ($files as $col_name => $file) {
                $file_name = $file->getClientOriginalName();

                $path = Storage::disk('public')->put('user_files', $file);

                $user->{$col_name} = $path;

            }
            $user->save();
        }

    }
}

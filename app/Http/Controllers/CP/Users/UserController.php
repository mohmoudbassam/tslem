<?php

namespace App\Http\Controllers\CP\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\CP\User\StoreUserRequest;
use App\Http\Requests\CP\User\UpdateUserRequest;
use App\Models\BeneficiresCoulumns;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;
use Hash;
class UserController extends Controller
{
    public function index()
    {
        return view('CP.users.index');
    }

    public function add()
    {

        return view('CP.users.select_form');
    }

    public function get_form(Request $request, $id = null)
    {
        dd($request->all());
        $data['record'] = BeneficiresCoulumns::query()->where('type', $request->type)->firstOrFail();
        $data['type'] =  $request->type;

        return view('CP.users.form', $data);
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
        ]);

        if($user->type == 'raft_company'){
            $user->update([
                'is_file_uploaded' => 1,
                'verified' => 1
            ]);
        }
        $this->uploadUserFiles($user, $request);
        return back()->with(['success' => 'تمت عمليه الإضافة بنجاح']);
    }

    public function edit_profile()
    {

        $data['record'] = BeneficiresCoulumns::query()->where('type',auth()->user()->type)->firstOrFail();
        $data['user'] =auth()->user();
        $col_file = get_user_column_file(auth()->user()->type);
        $data['col_file']= $col_file;
        $data['verified']=auth()->user()->verified;
        return view('CP.users.edit_profile',$data);

    }

    public function update_profile()
    {
        return view('CP.users.edit_profile');

    }

    public function change_password_form(User $user){
        return view('CP.users.change_password', ['user' => $user]);

    }

    public function change_password(Request $request){


        $request->validate([
            'password' => 'required|min:6|confirmed'
        ]);

        $user = User::query()->findOrFail($request->id);
        $user->update([
            'password' =>$request->password
        ]);

        return back()->with('success', 'تم تعديل كلمة المرور بنجاح');

    }

//    public function save_profile(UpdateUserRequest $request)
//    {
//
//        auth()->user()->update([
//            'email' => request('email'),
//            'phone' => request('phone'),
//        ]);
//        if (request('password')) {
//            auth()->user()->update([
//                'password' => bcrypt(request('password'))
//            ]);
//        }
//
//        return back()->with('success', 'تمت عمليه التعديل بنجاح');
//    }

    public function list(Request $request)
    {

        $users = User::query()->where('verified',1)->when(request('name'), function ($q) {
            $q->where('name', 'like', '%' . request('name') . '%')->where('type', '!=', 'admin');
            $q->orwhere('email', 'like', '%' . request('name') . '%')->where('type', '!=', 'admin');
            $q->orwhere('phone', 'like', '%' . request('name') . '%')->where('type', '!=', 'admin');
        })->when(request('type'), function ($q) {
            $q->where('type', request('type'));
        })->where('type', '!=', 'admin');
        return DataTables::of($users)
            ->addColumn('type', function ($user) {
                return $user->user_type;
            })
            ->addColumn('enabled', function ($user) {
                if ($user->enabled) {
                    $element = '<div class="form-check form-switch form-switch-lg mb-3 d-flex justify-content-center" dir="rlt">';
                    $element .= '<input onclick="change_status(' . $user->id . ',\'' . route('users.status') . '\')" type="checkbox" class="form-check-input" id="customSwitchsizelg" checked="">';
                    $element .= '  </div>';
                } else {
                    $element = '<div class="form-check form-switch form-switch-lg mb-3 d-flex justify-content-center" dir="rlt">';
                    $element .= '<input onclick="change_status(' . $user->id . ',\'' . route('users.status') . '\')" type="checkbox" class="form-check-input" id="customSwitchsizelg" >';
                    $element .= '  </div>';
                }

                return $element;
            })->addColumn('actions', function ($user) {
                $element = '<div class="btn-group me-1 mt-2">
                                            <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                خيارات<i class="mdi mdi-chevron-down"></i>
                                            </button>
                                            <div class="dropdown-menu" style="">
                                                <a class="dropdown-item" href="' . route('users.update_from', ['user' => $user->id]) . '">تعديل</a>
                                                <a class="dropdown-item" href="' . route('users.change_password_form', ['user' => $user->id]) . '">تغيير كلمة المرور</a>
                                                <a class="dropdown-item" href="#" onclick="delete_user(' . $user->id . ', \'' . route('users.delete') . '\')" >حذف</a>
                                            </div>
                                        </div>';

                return $element;
            })->rawColumns(['enabled', 'actions'])
            ->make(true);
    }

    public function status(Request $request)
    {
        $user = User::query()->find($request->id);
        $user->enabled = !$user->enabled;
        $user->save();
        return response()->json([
            'message' => 'تمت عمليه التعديل بنجاح',
            'success' => true
        ]);
    }

    public function delete(Request $request)
    {

        User::query()->find(request('id'))->delete();
        return response()->json([
            'message' => 'تمت عمليه الحذف بنجاخ بنجاح',
            'success' => true
        ]);
    }


    public function update_from(Request $request, User $user)
    {

        $data['user'] = $user;
        $data['record'] = BeneficiresCoulumns::query()->where('type', $user->type)->firstOrFail();
        return view('CP.users.update_form', $data);
    }

    public function update(Request $request)
    {
        User::query()->where('id', $request->id)->first()->update($request->all());
        return back()->with('success', 'تمت عمليه التعديل بنجاح');

    }

    private function uploadUserFiles($user, $file)
    {
        $columns_name = get_user_column_file($user->type);

        if (!empty($columns_name)) {
            $files = request()->all(array_keys(get_user_column_file($user->type)));
            foreach ($files as $col_name => $file) {

                if($file){
                    $file_name = $file->getClientOriginalName();

                    $path = Storage::disk('public')->put('user_files', $file);

                    $user->{$col_name} = $path;
                }


            }
            $user->save();
        }

    }
    public function after_reject(Request $request)
    {
        $user =tap(auth()->user()->update([
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

            'verified' => 0,
            'commercial_file_end_date' => request('commercial_file_end_date'),
            'rating_certificate_end_date' => request('rating_certificate_end_date'),
            'profession_license_end_date' => request('profession_license_end_date'),
            'business_license_end_date' => request('business_license_end_date'),
            'social_insurance_certificate_end_date' => request('social_insurance_certificate_end_date'),
            'date_of_zakat_end_date' => request('date_of_zakat_end_date'),
            'saudization_certificate_end_date' => request('saudization_certificate_end_date'),
            'chamber_of_commerce_certificate_end_date' => request('chamber_of_commerce_certificate_end_date'),
        ]));
        $this->uploadUserFiles(auth()->user(), $request);
        return back()->with(['success' => 'تمت عمليه التعديل بنجاح']);

    }

    public function save_profile(UpdateUserRequest $request)
    {
        $user =tap(auth()->user()->update([
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

            'commercial_file_end_date' => request('commercial_file_end_date'),
            'rating_certificate_end_date' => request('rating_certificate_end_date'),
            'profession_license_end_date' => request('profession_license_end_date'),
            'business_license_end_date' => request('business_license_end_date'),
            'social_insurance_certificate_end_date' => request('social_insurance_certificate_end_date'),
            'date_of_zakat_end_date' => request('date_of_zakat_end_date'),
            'saudization_certificate_end_date' => request('saudization_certificate_end_date'),
            'chamber_of_commerce_certificate_end_date' => request('chamber_of_commerce_certificate_end_date'),
        ]));
        $this->uploadUserFiles(auth()->user(), $request);
        return back()->with(['success' => 'تمت عمليه التعديل بنجاح']);
    }

}

<?php

namespace App\Http\Controllers\CP\Users;

use App\Exports\UserExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\CP\User\StoreUserRequest;
use App\Http\Requests\CP\User\UpdateUserRequest;
use App\Models\BeneficiresCoulumns;
use App\Models\RaftCompanyLocation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

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

        $data['record'] = BeneficiresCoulumns::query()->where('type', $request->type)->firstOrFail();
        $data['type'] = $request->type;

        $data['raft_companies'] = RaftCompanyLocation::all();

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
            'raft_company_type' => request('raft_company_type'),
        ]);

        if (in_array($user->type, ["raft_company", "taslem_maintenance", "Kdana", "Delivery", "Sharer"])) {
            $user->update([
                'is_file_uploaded' => 1,
                'verified' => 1,
            ]);
        }
        $this->uploadUserFiles($user, $request);
        return back()->with(['success' => 'تمت عمليه الإضافة بنجاح']);
    }

    private function uploadUserFiles($user, $file)
    {
        $columns_name = get_user_column_file($user->type);

        if (!empty($columns_name)) {
            $files = request()->all(array_keys(get_user_column_file($user->type)));
            foreach ($files as $col_name => $file) {

                if ($file) {
                    $file_name = $file->getClientOriginalName();

                    $path = Storage::disk('public')->put('user_files', $file);

                    $user->{$col_name} = $path;
                }


            }
            $user->save();
        }

    }

    public function edit_profile()
    {
        $data['record'] = BeneficiresCoulumns::query()->where('type', auth()->user()->type)->firstOrFail();
        $data['user'] = auth()->user();
        $col_file = get_user_column_file(auth()->user()->type);
        $data['col_file'] = $col_file;
        $data['verified'] = auth()->user()->verified;
        return view('CP.users.edit_profile', $data);
    }

    public function update_profile()
    {
        return view('CP.users.edit_profile');
    }

    public function change_password_form(User $user)
    {
        return view('CP.users.change_password', ['user' => $user]);
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

    public function change_password(Request $request)
    {


        $request->validate([
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::query()->findOrFail($request->id);
        $user->update([
            'password' => $request->password,
        ]);

        return back()->with('success', 'تم تعديل كلمة المرور بنجاح');

    }

    public function list(Request $request, $flag = false)
    {
        $users = User::query()
            ->where('verified', 1)
            ->where('type', '!=', 'admin')
            ->when(request('name'), function ($query) {
                return $query->where(function (Builder $q) {
                    $columns = [
//                                 'name',
                        'id',
                        'email',
                        'phone',
                        'license_number',
                        'commercial_record',
                        'company_name',
//                                 'company_owner_name',
//                                 'website',
//                                 'responsible_name',
//                                 'id_number',
//                                 'source',
//                                 'address',
//                                 'telephone',
//                                 'city',
//                                 'employee_number',
//                                 'personalization_record',
//                                 'nomination_letter',
//                                 'gis_sketch',
//                                 'center_sketch',
//                                 'camp_number',
//                                 'box_number',
//                                 'hajj_service_license',
//                                 'previous_works',
//                                 'confidentiality_obligation',
//                                 'service_provider_obligation',
                    ];
                    foreach ($columns as $column) {
                        $q = $q->orWhere($column, 'like', '%' . request('name') . '%');
                    }
                    return $q;
                });
            })
            ->when(request('type'), function ($q) {
                $q->where('type', request('type'));
            });
        if ($flag) {
            return $users->get();
        }
        return DataTables::of($users)
            ->addColumn('type', function ($user) {
                return $user->user_type;
            })
            ->addColumn('enabled', function ($user) {
                if ($user->enabled) {
                    $element =
                        '<div class="form-check form-switch form-switch-lg mb-3 d-flex justify-content-center" dir="rlt">';
                    $element .= '<input onclick="change_status(' . $user->id . ',\'' . route(
                            'users.status'
                        ) . '\')" type="checkbox" class="form-check-input" id="customSwitchsizelg" checked="">';
                    $element .= '  </div>';
                } else {
                    $element =
                        '<div class="form-check form-switch form-switch-lg mb-3 d-flex justify-content-center" dir="rlt">';
                    $element .= '<input onclick="change_status(' . $user->id . ',\'' . route(
                            'users.status'
                        ) . '\')" type="checkbox" class="form-check-input" id="customSwitchsizelg" >';
                    $element .= '  </div>';
                }

                return $element;
            })->addColumn('actions', function ($user) {
                $hasUploadFiles = false;
                foreach (array_keys(get_user_column_file($user->type)) as $fileName) {
                    if (!empty($user->{$fileName}) or !is_null($user->{$fileName})) {
                        $hasUploadFiles = true;
                    }
                }
                if (in_array($user->type, ["design_office", "contractor"])) {
                    $designerType =
                        '<a class="dropdown-item view-designer-types-btn" href="#" data-user="' . $user->id . '">التخصصات</a>';
                } else {
                    $designerType = "";
                }
                if ($hasUploadFiles) {
                    $element = '<div class="btn-group me-1 mt-2">
                                            <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                خيارات<i class="mdi mdi-chevron-down"></i>
                                            </button>
                                            <div class="dropdown-menu" style="">
                                                <a class="dropdown-item" href="#" onclick="delete_user(' . $user->id . ', \'' . route(
                            'users.delete'
                        ) . '\')" >حذف</a>
                                                <a class="dropdown-item" href="' . route(
                            'users.update_from',
                            ['user' => $user->id]
                        ) . '">تعديل</a>
                                                ' . $designerType . '
                                                <a class="dropdown-item view-files" href="" data-user="' . $user->id . '">عرض المرفقات</a>
                                                <a class="dropdown-item" href="' . route(
                            'users.change_password_form',
                            ['user' => $user->id]
                        ) . '">تغيير كلمة المرور</a>
                                            </div>
                                        </div>';
                } else {
                    $element = '<div class="btn-group me-1 mt-2">
                                            <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                خيارات<i class="mdi mdi-chevron-down"></i>
                                            </button>
                                            <div class="dropdown-menu" style="">
                                                <a class="dropdown-item" href="#" onclick="delete_user(' . $user->id . ', \'' . route(
                            'users.delete'
                        ) . '\')" >حذف</a>
                                                <a class="dropdown-item" href="' . route(
                            'users.update_from',
                            ['user' => $user->id]
                        ) . '">تعديل</a>
                                                ' . $designerType . '
                                                <a class="dropdown-item" href="' . route(
                            'users.change_password_form',
                            ['user' => $user->id]
                        ) . '">تغيير كلمة المرور</a>
                                            </div>
                                        </div>';
                }

                return $element;
            })->rawColumns(['enabled', 'actions'])
            ->make(true);
    }

    public function user_export(Request $request)
    {
        $data=$this->list($request,true);
        return Excel::download(new UserExport($data), 'users.xlsx');
    }

    public function status(Request $request)
    {
        $user = User::query()->find($request->id);
        $user->enabled = !$user->enabled;
        $user->save();
        return response()->json([
            'message' => 'تمت عمليه التعديل بنجاح',
            'success' => true,
        ]);
    }

    public function delete(Request $request)
    {

        User::query()->find(request('id'))->delete();
        return response()->json([
            'message' => 'تمت عمليه الحذف بنجاخ بنجاح',
            'success' => true,
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

    public function after_reject(Request $request)
    {
        $user = tap(
            auth()->user()->update([
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
                'commercial_file_end_date' => request(
                    'commercial_file_end_date'
                ),
                'rating_certificate_end_date' => request(
                    'rating_certificate_end_date'
                ),
                'profession_license_end_date' => request(
                    'profession_license_end_date'
                ),
                'business_license_end_date' => request(
                    'business_license_end_date'
                ),
                'social_insurance_certificate_end_date' => request(
                    'social_insurance_certificate_end_date'
                ),
                'date_of_zakat_end_date' => request('date_of_zakat_end_date'),
                'saudization_certificate_end_date' => request(
                    'saudization_certificate_end_date'
                ),
                'chamber_of_commerce_certificate_end_date' => request(
                    'chamber_of_commerce_certificate_end_date'
                ),
            ])
        );
        $this->uploadUserFiles(auth()->user(), $request);
        return back()->with(['success' => 'تمت عمليه التعديل بنجاح']);

    }

    public function save_profile(UpdateUserRequest $request)
    {
        $user = tap(
            auth()->user()->update([
                'company_name' => request('company_name'),
                'company_type' => request('company_type'),
                'company_owner_name' => request('company_owner_name'),
                'commercial_record' => request('commercial_record'),
                'website' => request('website'),
                'responsible_name' => request('responsible_name'),
                'id_number' => request('id_number'),
                'id_date' => Carbon::parse(request('id_date'))
                    ->format(
                        'Y-m-d'
                    ),
                'source' => request('source'),
                'email' => request('email'),
                'phone' => request('phone'),
                'address' => request('address'),
                'telephone' => request('telephone'),
                'city' => request('city'),
                'employee_number' => request('employee_number'),
                'commercial_file_end_date' => request(
                    'commercial_file_end_date'
                ),
                'rating_certificate_end_date' => request(
                    'rating_certificate_end_date'
                ),
                'profession_license_end_date' => request(
                    'profession_license_end_date'
                ),
                'business_license_end_date' => request(
                    'business_license_end_date'
                ),
                'social_insurance_certificate_end_date' => request(
                    'social_insurance_certificate_end_date'
                ),
                'date_of_zakat_end_date' => request('date_of_zakat_end_date'),
                'saudization_certificate_end_date' => request(
                    'saudization_certificate_end_date'
                ),
                'chamber_of_commerce_certificate_end_date' => request(
                    'chamber_of_commerce_certificate_end_date'
                ),
            ])
        );
        $this->uploadUserFiles(auth()->user(), $request);
        return back()->with(['success' => 'تمت عمليه التعديل بنجاح']);
    }

    public function get_user_files(User $user)
    {
        try {
            $hasUploadFiles = false;
            foreach (array_keys(get_user_column_file(User::find(13)->type)) as $fileName) {
                if (!empty($user->{$fileName}) or !is_null($user->{$fileName})) {
                    $hasUploadFiles = true;
                }
            }

            if (!$hasUploadFiles) {
                return response()->json([
                    'message' => 'لاتوجد مرفقات ',
                    'success' => false,
                ]);
            }

            $files = [];
            $extensions = ["pdf", "png", "jpg", "jpeg", "xlsx", "xlsm", "xlsb", "xltx", "dwg"];
            foreach (array_keys(get_user_column_file($user->type)) as $fileName) {
                if (is_null($user->$fileName)) continue;
                $exception = last(explode(".", $user->$fileName));
                switch (strtolower($exception)) {
                    case "png":
                    case "jpg":
                    case "jpeg":
                        $icon = asset("assets/images/png.png");
                        break;
                    case "pdf":
                        $icon = asset("assets/images/pdf.png");
                        break;
                    case "xlsx":
                    case "xlsm":
                    case "xlsb":
                    case "xltx":
                        $icon = asset("assets/images/xlsx.png");
                        break;
                    case "dwg":
                        $icon = asset("assets/images/dwg.png");
                        break;
                    default:
                        $icon = asset("assets/images/default.png");
                }
                $files[] = [
                    "name" => file_name_by_column($fileName),
                    "file" => $user->$fileName,
                    "icon" => $icon,
                    "path" => asset("storage/" . $user->{$fileName}),
                    "extension" => $exception,
                ];
            }

            return response()->json([
                'data' => $files,
                'message' => '',
                'success' => true,
            ]);
        } catch (\Exception|\Error $exception) {
            return response()->json([
                'message' => 'خطأ تقني الرجاء المحاولة لاحقا',
                'success' => false,
            ]);
        }
    }

    public function get_design_types(User $user)
    {
        try {

            if (!in_array($user->type, ["design_office", "contractor"])) {
                return response()->json([
                    'message' => 'المستخدم ليس مكتب تصاميم او مقاول',
                    'success' => false,
                ]);
            }

            $data = [];

            if ($user->type == "design_office") {

                foreach ($user->designer_types as $designerType) {
                    $data[] = [
                        "id" => $designerType->id,
                        "type" => $designerType->type,
                    ];
                }
            } else {
                foreach ($user->contractor_types as $contractorType) {
                    $data[] = [
                        "id" => $contractorType->id,
                        "type" => $contractorType->specialty->name_en,
                    ];
                }
            }


            return response()->json([
                'user_type' => $user->type,
                'data' => $data,
                'message' => '',
                'success' => true,
            ]);
        } catch (\Exception|\Error $exception) {
            return response()->json([
                'message' => 'خطأ تقني الرجاء المحاولة لاحقا',
                'success' => false,
            ]);
        }
    }

    public function agree_to_obligation()
    {
        try {
            User::where("id", auth()->id())->update([
                "agree_to_obligation" => 1,
            ]);

            return response()->json([
                'message' => 'تمت الموافقة على الإرار بنجاح',
                'success' => true,
            ]);
        } catch (\Exception|\Error $exception) {
            return response()->json([
                'message' => 'خطا تقني الرجاء المحاولة لاحقا',
                'success' => false,
            ]);
        }
    }

    public function update_licence_number(Request $request)
    {
        auth()->user()->update([
            'license_number' => $request->license_number
        ]);

        return redirect()->route("services_providers.orders");
    }


}

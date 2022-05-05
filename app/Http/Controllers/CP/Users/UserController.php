<?php

namespace App\Http\Controllers\CP\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\CP\User\StoreUserRequest;
use App\Http\Requests\CP\User\UpdateUserRequest;
use App\Models\BeneficiresCoulumns;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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

        return view('CP.users.form', $data);
    }

    public function add_edit(StoreUserRequest $request)
    {
        User::query()->create($request->all());
        return back()->with(['success' => 'تمت عمليه الإضافة بنجاح']);
    }

    public function edit_profile()
    {
        return view('CP.users.edit_profile');

    }

    public function update_profile()
    {
        return view('CP.users.edit_profile');

    }

    public function save_profile(UpdateUserRequest $request)
    {

        auth()->user()->update([
            'email' => request('email'),
            'phone' => request('phone'),
        ]);
        if (request('password')) {
            auth()->user()->update([
                'password' => bcrypt(request('password'))
            ]);
        }


        return back()->with('success', 'تمت عمليه التعديل بنجاح');
    }

    public function list(Request $request)
    {

        $users = User::query()->when(request('name'), function ($q) {
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
                    $element = '<div class="form-check form-switch form-switch-lg mb-3 align-content-lg-center" dir="rlt">';
                    $element .= '<input onclick="change_status(' . $user->id . ',\'' . route('users.status') . '\')" type="checkbox" class="form-check-input" id="customSwitchsizelg" checked="">';
                    $element .= '  </div>';
                } else {
                    $element = '<div class="form-check form-switch form-switch-lg mb-3 align-content-lg-center" dir="rlt">';
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
                                                <a class="dropdown-item" href="'.route('users.update_from',['user'=>$user->id]).'">تعديل</a>
                                                <a class="dropdown-item" href="#" onclick="delete_user(' . $user->id . ', \'' . route('users.delete') . '\')" >حذف</a>
                                            </div>
                                        </div>';

                return $element;
            })
            ->rawColumns(['enabled', 'actions'])
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


    public function update_from(Request $request,User $user)
    {
        $data['user']=$user;
        $data['record'] = BeneficiresCoulumns::query()->where('type', $user->type)->firstOrFail();
         return view('CP.users.update_form', $data);
    }
    public function update(Request $request)
    {
        User::query()->where('id', $request->id)->first()->update($request->all());
        return back()->with('success', 'تمت عمليه التعديل بنجاح');

    }
}

<?php

namespace App\Http\Controllers\CP\RaftCompany;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BeneficiresCoulumns;
use App\Models\User;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Storage;

class RaftCompanyController extends Controller{
    public function index() {
        return view("CP.raft_company.index");
    }

    public function add_center() {
        $data['record'] = BeneficiresCoulumns::query()->where('type', 'raft_center')->first();
        $data['type'] =  'raft_center';
        return view("CP.raft_company.add_center",$data);
    }
    public function save_center(Request $request) {

        $request->validate([
            'email' => 'required|email|unique:users,email',
            'name' => 'required|string|unique:users,name',
            'phone' => 'required|numeric|unique:users,phone',
        ]);

        $user = User::create([
            'type' => 'raft_center',
            'parent_id' => auth()->user()->id,
            'name' => request('name'),
            'company_name' => request('company_name'),
            'company_owner_name' => request('company_owner_name'),
            'email' => request('email'),
            'box_number' => request('box_number'),
            'camp_number' => request('camp_number'),
            'phone' => request('phone'),
            'employee_number' => request('employee_number'),
            'password' => bcrypt(request('password')),
        ]);
        $this->uploadUserFiles($user, $request);
        return back()->with(['success' => 'تمت عمليه الإضافة بنجاح']);
    }

    public function list(Request $request)
    {

        $users = User::query()->where('parent_id',auth()->user()->id)->when(request('name'), function ($q) {
            $q->where('name', 'like', '%' . request('name') . '%')->where('type','raft_center');
            $q->orwhere('email', 'like', '%' . request('name') . '%')->where('type','raft_center');
            $q->orwhere('phone', 'like', '%' . request('name') . '%')->where('type','raft_center');
        });

        return DataTables::of($users)->make(true);
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

}

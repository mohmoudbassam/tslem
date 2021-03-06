<?php

namespace App\Http\Controllers\CP\Users;

use App\Http\Controllers\Controller;
use App\Models\BeneficiresCoulumns;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class UserRequestController extends Controller
{
    public function index()
    {
        return view('CP.users.request.index');
    }

    public function list()
    {

        //->where('email_verified_at', '!=' ,null)
        $users = User::query()
                     ->where('is_file_uploaded', 1)
                     ->whereIn('verified', [ 0, 2 ])
                     ->where('type', '!=', 'admin')
                     ->when(request('name'), function ($query) {
                         return $query->where(function (Builder $q) {
                             $columns = [
                                 'name',
                                 'email',
                                 'phone',
                                 'license_number',
                                 'commercial_record',
//                                 'company_name',
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
                             foreach( $columns as $column ) {
                                 $q = $q->orWhere($column, 'like', '%' . request('name') . '%');
                             }
                             return $q;
                         });
                     })
                     ->when(request('type'), function ($q) {
                         if ( request('type') == "service_provider" ) {
                             $q->where('type', request('type'))
                                 ->whereNull("parent_id");
                         } elseif ( request('type') == "raft_center" ) {
                             $q->where('type', "service_provider")
                                 ->whereNotNull("parent_id");
                         } else {
                             $q->where('type', request('type'));
                         }
                     });

        return DataTables::of($users)
                         ->addColumn('type', function ($user) {
                             return ($user->type == "service_provider" and !is_null($user->parent_id)) ? "?????????? ???????? ????????????": $user->user_type;
                         })
                         ->addColumn('enabled', function ($user) {
                             if( $user->enabled ) {
                                 $element =
                                     '<div class="form-check form-switch form-switch-lg mb-3 d-flex justify-content-center" dir="rlt">';
                                 $element .= '<input onclick="change_status(' . $user->id . ',\'' . route(
                                         'users.status'
                                     ) . '\')" type="checkbox" class="form-check-input" id="customSwitchsizelg" checked="">';
                                 $element .= '  </div>';
                             } else {
                                 $element =
                                     '<div class="form-check form-switch form-switch-lg d-flex justify-content-center" dir="rlt">';
                                 $element .= '<input onclick="change_status(' . $user->id . ',\'' . route(
                                         'users.status'
                                     ) . '\')" type="checkbox" class="form-check-input" id="customSwitchsizelg" >';
                                 $element .= '  </div>';
                             }

                             return $element;
                         })
                         ->addColumn('actions', function ($user) {
                             $show =
                                 ' <a class="dropdown-item" href="' . route(
                                     'users.request.show',
                                     [ 'user' => $user->id ]
                                 ) . '"><i class="fa fa-eye mx-1"></i> ??????</a>';
                             $accept = '';
                             $reject = '';
                             if( in_array($user->type, [ "design_office", "contractor" ]) ) {
                                 $designerType =
                                     '<a class="dropdown-item view-designer-types-btn" href="#" data-user="' . $user->id . '"><i class="fa fa-list mx-1"></i>????????????????</a>';
                             } else {
                                 $designerType = "";
                             }
                             if( $user->verified == 0 ) {
                                 $accept =
                                     '<a class="dropdown-item" href="javascript:;" onclick="accept(' . $user->id . ')" ><i class="fa fa-check mx-1"></i>????????????</a>';
                                 $reject =
                                     '<a class="dropdown-item rejection-user-btn" href="#" data-user="' . $user->id . '"> <i class="fa fa-times mx-1"></i>??????</a>';
                             }
                             $element = '<div class="btn-group me-1 mt-2">
                                            <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                ????????????<i class="mdi mdi-chevron-down"></i>
                                            </button>
                                            <div class="dropdown-menu" style="">
                                               ' . $show . '
                                               ' . $accept . '
                                               ' . $reject . '
                                               ' . $designerType . '
                                            </div>
                                        </div>';

                             return $element;
                         })
                         ->addColumn('verified_status', function ($user) {
                             return $user->verified_status;
                         })
                         ->rawColumns([ 'enabled', 'actions' ])
                         ->make(true);
    }

    public function show(User $user)
    {
        $record = BeneficiresCoulumns::query()->where('type', $user->type)->firstOrFail();
        $col_file = get_user_column_file($user->type);

        return view('CP.users.show', [
            'user'     => $user,
            'record'   => $record,
            'col_file' => $col_file,
        ]);
    }

    public function accept(Request $request)
    {
        $user = User::query()->findOrFail($request->id);
        $user->verified = 1;
        $user->save();
        return response()->json([
                                    'success' => true,
                                    'message' => '???? ???????????? ???????????????? ??????????',
                                ]);
    }

    public function reject_form(Request $request)
    {
        $user = User::query()->find($request->id);
        return response()->json([
                                    'success' => true,
                                    'page'    => view('CP.users.request.reject_reason_form', [ 'user' => $user ]
                                    )->render(),
                                ]);
    }

    public function reject(Request $request)
    {

        $user = User::query()->findOrFail($request->user_id);
        $user->reject_reason = $request->rejection_reason;
        $user->verified = 2;
        $user->save();
        return redirect()
            ->route("users.request")
            ->with("success", "???? ?????? ??????  ???????????????? ??????????");
    }
}

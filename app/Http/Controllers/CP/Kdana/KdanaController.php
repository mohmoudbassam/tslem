<?php

namespace App\Http\Controllers\CP\Kdana;

use App\Helpers\Calendar;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CP\Delivery\DeliveryController;
use App\Models\License;
use App\Models\LoginNumber;
use App\Models\Order;
use App\Models\RaftCompanyBox;
use App\Models\RaftCompanyLocation;
use App\Models\Session;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class KdanaController extends Controller
{

    public function index()
    {

        $data['number_of_user'] = User::query()->count();
        $data['number_of_user_under_approve'] = User::query()->where('verified', 0)->count();
        $data['number_of_approve_user'] = User::query()->where('verified', 1)->count();
        $data['donat']['number_of_service_providers_out'] = User::query()->where('type', 'service_provider')->whereNotNull('parent_id')->count();
        $data['donat']['number_of_service_providers_in'] = User::query()->where('type', 'service_provider')->where('verified', 1)->whereNull('parent_id')->count();
        $data['donat']['design_office'] = User::query()->where('type', 'design_office')->where('verified', 1)->count();
        $data['donat']['number_of_contractors'] = User::query()->where('type', 'contractor')->where('verified', 1)->count();
        $data['number_of_consulting_office'] = User::query()->where('type', 'consulting_office')->where('verified', 1)->count();
        $data['session_for_boxes'] = Session::query()
            ->select(DB::raw('count(*) as session_count'), DB::raw("DATE_FORMAT(start_at,'%M-%d') as days"))
            ->groupBy('days')->get();
        $data['session_for_boxes'] = $data['session_for_boxes']->pluck('session_count', 'days')->toArray();
        $data['session_count'] = Session::query()->count();
        $data['number_of_login'] = LoginNumber::query()->count();
        $data['number_of_login_per_day'] = LoginNumber::query()
            ->select(DB::raw('count(*) as login_count'), DB::raw("DATE_FORMAT(created_at,'%M-%d') as days"))
            ->groupBy('days')->get()->pluck('login_count', 'days')->toArray();
        ///////////// المحاضر المسلمة لشركات حجاج الداخل
        $data['count_box_with_files_in'] = RaftCompanyBox::query()
            ->whereNotNull('license_number')
            ->whereNotNull('file_first')
            ->whereNotNull('file_second')
            ->whereNotNull('file_third')->count();
        $data['box_with_files_in'] = RaftCompanyBox::query()
            ->select(DB::raw('count(*) as count'), DB::raw("DATE_FORMAT(updated_at,'%M-%d') as days"))
            ->whereNotNull('license_number')
            ->whereNotNull('file_first')
            ->whereNotNull('file_second')
            ->whereNotNull('file_third')
            ->groupBy('days')->get()->pluck('count', 'days')->toArray();
        if (!count($data['box_with_files_in'])) {
            $data['box_with_files_in'] = [];
        }
////////////// المحاضر المسلمة لشركات حجاج الخارج
        $data['count_box_with_files_out'] = RaftCompanyBox::query()
            ->whereNull('license_number')
            ->whereNotNull('file_first')
            ->whereNotNull('file_second')
            ->whereNotNull('file_third')->count();
        $data['box_with_files_out'] = RaftCompanyBox::query()
            ->select(DB::raw('count(*) as count'), DB::raw("DATE_FORMAT(updated_at,'%M-%d') as days"))
            ->whereNull('license_number')
            ->whereNotNull('file_first')
            ->whereNotNull('file_second')
            ->whereNotNull('file_third')
            ->groupBy('days')->get()->pluck('count', 'days')->toArray();
        /////////////////عدد الإجراءات المنفذة
        $data['count_actions_performed'] = Order::query()
            ->where('status', 5)->count();
        $data['count_actions_performed_per_day'] = Order::query()
            ->where('status', 5)
            ->select(DB::raw('count(*) as count'), DB::raw("DATE_FORMAT(updated_at,'%M-%d') as days"))
            ->groupBy('days')->get()->pluck('count', 'days')->toArray();
        ///////////الاجراءات الصادرة
        $data['count_actions_outing'] = Order::query()
            ->where('status', 6)->count();
        $data['count_actions_outing_per_day'] = Order::query()
            ->where('status', 6)
            ->select(DB::raw('count(*) as count'), DB::raw("DATE_FORMAT(updated_at,'%M-%d') as days"))
            ->groupBy('days')->get()->pluck('count', 'days')->toArray();

        //////////order count
        $data['order_count'] = Order::query()->count();
        //////complete orders
        $data['complete_orders'] = Order::query()->where('status', '>=', Order::COMPLETED)->count();
        ///not complete
        $data['not_complete_orders'] = Order::query()->where('status', '<', Order::COMPLETED)->count();
        ///all orders
        $data['all_order'] = Order::query()->count();

        ///bar chart
        $data['bar'] = RaftCompanyLocation::query()->select('name')
            ->withCount(['box' => function ($q) {
                $q->where('seen_notes', 1);
            }])->get()->map(function ($location) {
                return [
                    'x' => $location->name,
                    'y' => $location->box_count
                ];
            });
        ///order per designer office
        $data['order_count_per_designer'] = Order::query()->whereNotNull('designer_id')->count();
        $data['order_count_per_taslem'] = DeliveryController::getOrdersQuery()->count();
        $data['license_number'] = License::query()->whereNotNull('box_raft_company_box_id')->whereNotNull('camp_raft_company_box_id')->count();
        $data['wasteContractors'] = wasteContractorsList()->count();

        return view('CP.kdana_layout.dashboard', $data);


    }

    public function orders()
    {
        return View('CP.kdana_layout.orders');
    }

    public function orders_list(Request $request)
    {
        //dd($request->all());

        if (request('params') == 'tasleem') {
            $order = DeliveryController::getOrdersQuery();

        } else {
            $order = Order::query()
                ->when(!is_null($request->query("order_identifier")), function ($query) use ($request) {
                    $query->where("identifier", "LIKE", "%" . $request->query("order_identifier") . "%");
                })
                ->when(!is_null($request->query("from_date")), function ($query) use ($request) {
                    $query->whereDate("created_at", ">=", $request->query("from_date"));
                })
                ->when(!is_null($request->query("to_date")), function ($query) use ($request) {
                    $query->whereDate("created_at", "<=", $request->query("to_date"));
                })
                ->whereOrderId($request->order_id)
                ->whereDesignerId($request->designer_id)
                ->whereConsultingId($request->consulting_id)
                ->whereContractorId($request->contractor_id)
                ->whereDate($request->from_date, $request->to_date)
                ->orderByDesc('created_at')
                ->with('designer')
                ->with('service_provider')
                ->with(['designer', 'contractor', 'consulting']);
            $order->when($request->params == 'designe_office_orders', function ($q) {
                $q->whereNotNull('designer_id');
            });
        }

        if ($request->waste_contractor) {
            $order = $order->whereWasteContractor($request->waste_contractor);
        }


        return DataTables::of($order)
            ->addColumn('created_at', function ($order) {
                return $order->created_at->format('Y-m-d');
            })
            ->addColumn('updated_at', function ($order) {
                return $order->updated_at->format('Y-m-d');
            })
            ->addColumn('order_status', function ($order) {
                return $order->order_status;
            })
            ->make(true);
    }

    public function show_users(Request $request)
    {
        return View('CP.kdana_layout.users');
    }

    public function users_list(Request $request)
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
                if (request('type') == "service_provider") {
                    $q->where('type', request('type'))
                        ->whereNull("parent_id");
                } elseif (request('type') == "raft_center") {
                    $q->where('type', "service_provider")
                        ->whereNotNull("parent_id");
                } else {
                    $q->where('type', request('type'));
                }
            });

        return DataTables::of($users)
            ->addColumn('type', function ($user) {
                return ($user->type == "service_provider" and !is_null($user->parent_id)) ? "شركات حجاج الخارج" : $user->user_type;
            })
            ->make(true);
    }

    public function show_license()
    {
        return view('CP.licenses.index');
    }

    public function license_list(Request $request)
    {
        $licenses = License::query()
            ->onlyFullyCreated()
            ->orderBy('created_at', data_get(collect($request->get('order', ['desc']))->first(), 'dir', 'desc'))
            ->when(request('name'), function ($query) {
                return $query->where(function (Builder $q) {
                    $columns = [
                        'id',
                        'tents_count',
                        'person_count',
                        'camp_space',
                    ];
                    foreach ($columns as $column) {
                        $q = $q->orWhere($column, 'like', '%' . request('name') . '%');
                    }

                    return $q;
                });
            });

        return DataTables::of($licenses)
            ->addColumn('id', fn(License $license) => $license->id)
            ->addColumn('order_id', fn(License $license) => $license->order()->value('identifier'))
            ->addColumn(
                'date',
                fn(License $license) => $license->date ? Calendar::make(str_before($license->getDateFormat(), ' '))->hijriDate($license->date) : "-"
            )
            ->addColumn(
                'expiry_date',
                fn(License $license) => $license->expiry_date ? Calendar::make(str_before($license->getDateFormat(), ' '))->hijriDate($license->expiry_date) : "-"
            )
            ->addColumn('raft_company', fn(License $license) => $license->raft_company_name ?? "")
            ->addColumn('box_raft_company_box_id', fn(License $license) => $license->box()->value('box'))
            ->addColumn('camp_raft_company_box_id', fn(License $license) => $license->camp()->value('camp'))
            ->addColumn('actions', function ($license) {
                $title = __('general.datatable.fields.actions');
                $delete_title = License::crudTrans('delete');
                $delete_route = route('licenses.delete', ['license' => $license->id]);
                $update_title = License::crudTrans('update');
                $update_route = route('licenses.edit', ['license' => $license->id]);

                if ($license->isFullyCreated() && $license->order_id) {
                    $print_title = License::trans('download_for_service_provider');
                    $print_route = route('licenses.view_pdf', ['order' => $license->order_id]);
                    $print_license = <<<HTML
<a class="dropdown-item" target="_blank" href="{$print_route}">{$print_title}</a>
HTML;
                } else {
                    $print_license = "";
                }

                $crud_options_tpl = <<<HTML
        <a class="dropdown-item" href="#" onclick="delete_model({$license->id}, '{$delete_route}')" >{$delete_title}</a>
        <a class="dropdown-item" href="{$update_route}">{$update_title}</a>
HTML;
                $crud_options = currentUser()->isAdmin() ? $crud_options_tpl : "";

                return <<<HTML
<div class="btn-group me-1 mt-2">
    <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        {$title}<i class="mdi mdi-chevron-down"></i>
    </button>

    <div class="dropdown-menu" style="">
{$crud_options}
{$print_license}
    </div>
</div>
HTML;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }
}

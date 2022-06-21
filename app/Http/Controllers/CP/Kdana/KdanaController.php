<?php

namespace App\Http\Controllers\CP\Kdana;

use App\Http\Controllers\Controller;
use App\Models\License;
use App\Models\LoginNumber;
use App\Models\Order;
use App\Models\RaftCompanyBox;
use App\Models\RaftCompanyLocation;
use App\Models\Session;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $data['order_count_per_taslem'] = Order::query()->where('status', '>', Order::DESIGN_REVIEW)->count();
        $data['license_number'] = License::query()->whereNotNull('box_raft_company_box_id')->whereNotNull('camp_raft_company_box_id')->count();
        $data['wasteContractors'] = wasteContractorsList()->count();

        return view('CP.kdana_layout.dashboard', $data);


    }
}
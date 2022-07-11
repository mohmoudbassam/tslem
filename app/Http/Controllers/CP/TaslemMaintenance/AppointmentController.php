<?php

namespace App\Http\Controllers\CP\TaslemMaintenance;

use App\Http\Controllers\Controller;
use App\Models\Appointment as Model;
use App\Models\RaftCompanyBox;
use App\Models\User;
use App\Notifications\TasleemMaintenanceNotification;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Carbon\Carbon;
use Error;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use niklasravnsborg\LaravelPdf\Facades\Pdf;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Yajra\DataTables\DataTables;

class AppointmentController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $data = ['isToday' => request()->input('today')];
        return view('CP.taslem_maintenance.Appointment.index', $data);
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     *
     * @return mixed
     * @throws \Exception
     */
    public function list(Request $request)
    {
        $toDay = $request->input('today');
        /** @var \Illuminate\Database\Eloquent\Builder $query */
        $query = Model::query()->published()->where('support_id', auth()->id())->with('RaftCompanyLocation.user', 'RaftCompanyBox');

        if ($toDay) {
            $query->whereDate('start_at', now()->format('Y-m-d'));
        }

        if (($i = $request->input('raft_company_location_id'))) {
            $query->where('raft_company_location_id', $i);
        }


        if (($i = $request->input('from_date'))) {
            $query->whereDate('start_at', '>=', $i);
        }
        if (($i = $request->input('to_date'))) {
            $query->whereDate('start_at', '<=', $i);
        }
        $query->latest('start_at');

        return DataTables::of($query)
            ->editColumn('name', fn(Model $model) => $model->service_provider_name)
            ->editColumn('start_at', fn(Model $model) => $model->start_at_to_string)
            ->addColumn('actions', function (Model $model) {
                return '<div class="d-flex justify-content-end">
    <div class="btn-group me-1 mt-2">
        <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="mdi mdi-chevron-down"></i>
            خيارات
        </button>
        <div class="dropdown-menu" style="">
<a class="dropdown-item" href="'.route('taslem_maintenance.Appointment.show', $model).'">عرض التفاصيل</a>
<a class="dropdown-item" href="javascript:;" onclick="send_sms('.$model->id.')">إعادة إرسال الرسالة</a>
        </div>
    </div>
</div>';
            })->rawColumns(['actions'])
            ->make();
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $users = User::query()->where('type', User::SERVICE_PROVIDER_TYPE)
            ->has('orders')
            ->where(fn(Builder $builder) => $builder->whereNotNull(['box_number', 'camp_number'])->orWhereNotNull('license_number'))
            ->get();
        //dd($users->toArray());
        $boxes = RaftCompanyBox::query()->select('box')->groupBy('box')->get()->toArray();
        return view('CP.taslem_maintenance.Appointment.create', compact('users', 'boxes'));
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        /** @var User $user */
        if (!($id = $request->input('service_provider_id'))) {
            $camp = $request->input('camp_number');
            $box = $request->input('box_number');
            $user = Model::serviceProviderByBoxes($box, $camp)->first();
        }
        else {
            $user = User::query()->where([
                'type' => User::SERVICE_PROVIDER_TYPE,
                'id'   => $id,
            ])->first();
        }

        if (!$user || !$user->getRaftCompanyBox()) {
            return response()->json([
                'message' => 'لم يتم العثور على مركز خدمة في البيانات',
                'success' => false,
            ]);
        }
        $raftCompany = $user->getRaftCompanyBox();
        $camp = $raftCompany->camp;
        $box = $raftCompany->box;
        if (!($raftCompanyBox = RaftCompanyBox::where([['camp', $camp], ['box', $box]])->first())) {
            return response()->json([
                'message' => 'لم يتم العثور على رقم المربع والمخيم في قاعدة البيانات',
                'success' => false,
            ]);
        }

        $model = Model::where(['support_id' => auth()->user()->id, 'raft_company_box_id' => $raftCompanyBox->id])->notPublished()->first();
        if (!$model) {
            $model = new Model;
            $model->raft_company_box_id = $raftCompanyBox->id;
            $model->raft_company_location_id = $raftCompanyBox->raft_company_location_id;
            $model->support_id = auth()->user()->id;
        }
        $model->start_at = Carbon::parse($request->input('start_at'))->format("Y-m-d h:i");
        $model->save();

        return response()->json([
            'message' => 'تمت عمليه الاضافة  بنجاح',
            'success' => true,
        ]);
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function notPublished()
    {
        $q = Model::where('support_id', auth()->user()->id)->notPublished()->with('raftCompanyLocation', 'raftCompanyLocation.user', 'raftCompanyBox');
        $q->latest('start_at');
        return DataTables::of($q)
            ->editColumn('name', fn(Model $model) => $model->service_provider_name)
            ->editColumn('start_at', fn(Model $model) => $model->start_at_to_string)
            ->addColumn('actions', function ($model) {
                return '<div class="justify-content-end d-flex">
<button type="button" class="btn btn-info btn-sm" onclick="delete_row('.$model->id.' )">
  <i class="fa fa-trash mx-1"></i>
  حذف
  </button>
</div>';
            })->rawColumns(['actions'])
            ->make();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function publish(): JsonResponse
    {
        try {
            $models = Model::where('support_id', auth()->user()->id)->notPublished()->with('RaftCompanyLocation', 'RaftCompanyBox')->get();
            //$raftUsers = [];
            //foreach ($models as $model) {
            //    if (!isset($raftUsers[$model->raft_company_location_id])) {
            //        $raftUsers[$model->raft_company_location_id] = 0;
            //    }
            //    $raftUsers[$model->raft_company_location_id]++;
            //}
            /** @var Model $model */
            foreach ($models as $model) {
                //$user = User::where('type', 'raft_company')->where('raft_company_type', $model->raft_company_location_id)->first();
                $user = $model->getServiceProvider()->first();
                if ($user && $user->phone) {
                    //$box = RaftCompanyBox::query()->where('id', $model->raft_company_box_id)->first();
                    $user->phone && sms($user->phone, __('message.appointment_sms', [
                        'camp'         => optional($model->raftCompanyBox)->camp,
                        'box'          => optional($model->raftCompanyBox)->box,
                        'company_name' => $user->company_name,
                    ]));
                    $user->notify(new TasleemMaintenanceNotification('لديك مواعيد إعادة تسليم جديدة يرجى منك متابعتها', auth()->id()));
                }
            }

            //$Users = User::where('type', 'raft_company')->whereIn('raft_company_type', array_keys($raftUsers))->get();
            //foreach ($Users as $User) {
            //    $User->notify(new TasleemMaintenanceNotification('لديك مواعيد استلام جديدة يرجى منك متابعتها', auth()->user()->id));
            //}
            Model::where('support_id', auth()->id())->notPublished()->update(['is_published' => !0]);
            return response()->json([
                'message' => 'تمت عمليه النشر  بنجاح',
                'success' => true,
            ]);
        }
        catch (Exception|Error $exception) {
            return response()->json([
                'message' => 'خطا تقني الرجاء المحاولة لاحقا',
                'success' => false,
                'error'   => $exception->getMessage(),
            ]);
        }
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request): JsonResponse
    {
        Model::where(['support_id' => auth()->user()->id, 'id' => $request->input('id')])->delete();
        return response()->json([
            'message' => 'تم الحذف بنجاح',
            'success' => true,
        ]);
    }

    /**
     * @param  \App\Models\Appointment  $model
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Model $model)
    {
        return view('CP.taslem_maintenance.Appointment.show', compact('model'));
    }

    /**
     * @param  \App\Models\Appointment  $model
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function upload(Model $model, Request $request): JsonResponse
    {
        if ($request->file('file')) {
            try {
                $model->addMediaFromRequest('file')->toMediaCollection(Model::MEDIA_COLLECTION_NAME);
            }
            catch (FileDoesNotExist|FileIsTooBig $e) {
                //dd($e);
            }
        }
        return response()->json([
            'message' => 'تم الرفع بنجاح',
            'success' => true,
        ]);
    }

    /**
     * @param  \App\Models\Appointment  $model
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Model $model, Request $request): JsonResponse
    {
        //if (!($model->RaftCompanyBox->file_first_name && $model->RaftCompanyBox->file_second_name && $model->RaftCompanyBox->file_third_name)) {
        //    return response()->json([
        //        'success' => false,
        //        'message' => 'الرجاء إرفاق جميع الملفات',
        //    ]);
        //}
        //RaftCompanyBox::where('id', $model->raft_company_box_id)->update(['tasleem_notes' => $request->note]);
        //dd($request->all());
        $model->update(['notes' => $request->input('note')]);
        return response()->json([
            'success' => true,
            'message' => 'تمت العملية بنجاح',
        ]);
    }

    /**
     * @return mixed
     */
    public function export()
    {
        $rows = Model::query()->whereDate('start_at', '=', now())->get();
        $pdf = PDF::loadView('CP.taslem_maintenance.Appointment.pdf_list', compact('rows'));
        return $pdf->download('Today-List.pdf');
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function send_sms(Request $request): JsonResponse
    {
        /** @var Model $model */
        $model = Model::query()->where('id', $request->id)->first();
        //$user = User::query()->where('type', 'raft_company')->where('raft_company_type', $model->raft_company_location_id)->first();
        //$box = RaftCompanyBox::query()->where('id', $model->raft_company_box_id)->first();
        $user = $model->getServiceProvider()->first();
        $box = $model->raftCompanyBox();
        if ($user && $user->phone) {
            sms($user->phone, __('message.appointment_sms', [
                'camp'         => optional($box)->camp,
                'box'          => optional($box)->box,
                'company_name' => $user->company_name,
            ]));
        }
        return response()->json([
            'message' => 'تم ارسال الرسالة بنجاح',
            'success' => true,
        ]);
    }

    public function generatePdf(User $user){
        //d(3);
        $pdf = SnappyPdf::loadView('CP.taslem_maintenance.Appointment.generate_pdf', compact('user'));
        return $pdf->inline('Pdf.pdf');
    }
}

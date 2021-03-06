<?php

namespace App\Http\Controllers\CP\TaslemMaintenance;

use App\Exports\AppointmentExport;
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
use Maatwebsite\Excel\Facades\Excel;
use niklasravnsborg\LaravelPdf\Facades\Pdf;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Yajra\DataTables\DataTables;

class AppointmentController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        //$boxes = RaftCompanyBox::query()->has('licenses')->select('box')->groupBy('box')->get()->toArray();
        [$boxes] = Model::getCampsOfCreate();
        $data = [
            'isToday' => request()->input('today'),
            'boxes'   => $boxes,
        ];
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

        if (($i = $request->input('camp_number'))) {
            $query->whereHas('raftCompanyBox', fn(Builder $builder) => $builder->where('camp', $i));
        }
        if (($i = $request->input('box_number'))) {
            $query->whereHas('raftCompanyBox', fn(Builder $builder) => $builder->where('box', $i));
        }
        $query->latest();

        return DataTables::of($query)
            ->editColumn('name', fn(Model $model) => $model->service_provider_name)
            ->editColumn('start_at', fn(Model $model) => $model->start_at_to_string)
            ->addColumn('actions', function (Model $model) {
                return '<div class="d-flex justify-content-end">
    <div class="btn-group me-1 mt-2">
        <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="mdi mdi-chevron-down"></i>
            ????????????
        </button>
        <div class="dropdown-menu" style="">
<a class="dropdown-item" href="'.route('taslem_maintenance.Appointment.show', $model).'">?????? ????????????????</a>
<a class="dropdown-item" href="javascript:;" onclick="send_sms('.$model->id.')">?????????? ?????????? ??????????????</a>
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
        [$boxes] = Model::getCampsOfCreate();
        return view('CP.taslem_maintenance.Appointment.create', compact('users', 'boxes'));
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        ///** @var User $user */
        //if (!($id = $request->input('service_provider_id'))) {
        //$camp = $request->input('camp_number');
        //$box = $request->input('box_number');
        /** @var RaftCompanyBox $raftCompanyBox */
        if (!($raftCompanyBox = RaftCompanyBox::query()->find($request->input('camp_id')))) {
            return response()->json([
                'message' => '???? ?????? ???????????? ?????? ?????? ???????????? ?????????????? ???? ?????????? ????????????????',
                'success' => !1,
            ]);
        }
        //d($raftCompanyBox);
        //d($request->all());
        //$user = Model::serviceProviderByBoxes($box, $camp)->first();
        //}
        //else {
        //    $user = User::query()->where([
        //        'type' => User::SERVICE_PROVIDER_TYPE,
        //        'id'   => $id,
        //    ])->first();
        //}

        //if (!$user || !$user->getRaftCompanyBox()) {
        //    return response()->json([
        //        'message' => '???? ?????? ???????????? ?????? ???????? ???????? ???? ????????????????',
        //        'success' => false,
        //    ]);
        //}
        //$raftCompany = $user->getRaftCompanyBox();
        //$camp = $raftCompanyBox->camp;
        //$box = $raftCompanyBox->box;
        //if (!($raftCompanyBox = RaftCompanyBox::where([['camp', $camp], ['box', $box]])->first())) {
        //    return response()->json([
        //        'message' => '???? ?????? ???????????? ?????? ?????? ???????????? ?????????????? ???? ?????????? ????????????????',
        //        'success' => false,
        //    ]);
        //}

        //if (($model = Model::where(['raft_company_box_id' => $raftCompanyBox->id])->first())) {
        //    if ($model->is_published) {
        //        return response()->json([
        //            'message' => '???? ?????? ???????? ???????????? ???????? ????????????',
        //            'success' => !1,
        //        ]);
        //    }
        //}

        if (!($model = Model::where(['raft_company_box_id' => $raftCompanyBox->id])->notPublished()->first())) {
            //d(2);
            $model = new Model;
            $model->raft_company_box_id = $raftCompanyBox->id;
            $model->raft_company_location_id = $raftCompanyBox->raft_company_location_id;
            $model->support_id = auth()->id();
        }
        $model->service_provider_id = $model->searchOnServiceProviderId();
        $model->start_at = Carbon::parse($request->input('start_at'))->format("Y-m-d h:i");
        //d($model);
        $model->save();

        return response()->json([
            'message'             => '?????? ?????????? ??????????????  ??????????',
            'service_provider_id' => $model->service_provider_id,
            'success'             => !0,
        ]);
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function notPublished()
    {
        $q = Model::where('support_id', auth()->user()->id)->notPublished()->with('raftCompanyLocation', 'raftCompanyLocation.user', 'raftCompanyBox');
        $q->latest();
        return DataTables::of($q)
            ->editColumn('name', fn(Model $model) => $model->service_provider_name)
            ->editColumn('start_at', fn(Model $model) => $model->start_at_to_string)
            ->addColumn('actions', function ($model) {
                return '<div class="justify-content-end d-flex">
<button type="button" class="btn btn-info btn-sm" onclick="delete_row('.$model->id.' )">
  <i class="fa fa-trash mx-1"></i>
  ??????
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
                $user = $model->serviceProvider;
                if ($user && $user->phone) {
                    //$box = RaftCompanyBox::query()->where('id', $model->raft_company_box_id)->first();
                    $user->phone && sms($user->phone, __('message.appointment_sms', [
                        'camp'         => optional($model->raftCompanyBox)->camp,
                        'box'          => optional($model->raftCompanyBox)->box,
                        'company_name' => $user->company_name,
                    ]));
                    $user->notify(new TasleemMaintenanceNotification('???????? ???????????? ?????????? ?????????? ?????????? ???????? ?????? ????????????????', auth()->id()));
                }
            }

            //$Users = User::where('type', 'raft_company')->whereIn('raft_company_type', array_keys($raftUsers))->get();
            //foreach ($Users as $User) {
            //    $User->notify(new TasleemMaintenanceNotification('???????? ???????????? ???????????? ?????????? ???????? ?????? ????????????????', auth()->user()->id));
            //}
            Model::where('support_id', auth()->id())->notPublished()->update(['is_published' => !0]);
            return response()->json([
                'message' => '?????? ?????????? ??????????  ??????????',
                'success' => true,
            ]);
        }
        catch (Exception|Error $exception) {
            return response()->json([
                'message' => '?????? ???????? ???????????? ???????????????? ??????????',
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
            'message' => '???? ?????????? ??????????',
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
            'message' => '???? ?????????? ??????????',
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
        //        'message' => '???????????? ?????????? ???????? ??????????????',
        //    ]);
        //}
        //RaftCompanyBox::where('id', $model->raft_company_box_id)->update(['tasleem_notes' => $request->note]);
        //dd($request->all());
        $model->update(['notes' => $request->input('note')]);
        return response()->json([
            'success' => true,
            'message' => '?????? ?????????????? ??????????',
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
     * @return mixed
     */
    public function excel(Request $request)
    {
        //d($request->all());
        $q = Model::query();
        if ($request->input('today')) {
            $q->whereDate('start_at', '=', now())->get();
        }
        $data = $q->get();
        $fileName = 'Appointments.xlsx';
        return Excel::download(new AppointmentExport($data), $fileName)->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, $fileName);
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
        $user = $model->serviceProvider;
        if ($user && $user->phone) {
            $box = $model->raftCompanyBox();
            sms($user->phone, __('message.appointment_sms', [
                'camp'         => optional($box)->camp,
                'box'          => optional($box)->box,
                'company_name' => $user->company_name,
            ]));
        }
        return response()->json([
            'message' => '???? ?????????? ?????????????? ??????????',
            'success' => true,
        ]);
    }

    /**
     * @param  \App\Models\User  $user
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function generatePdf(User $user)
    {
        $view = 'CP.taslem_maintenance.Appointment.generate_pdf';
        $model = null;
        if (($box = $user->getRaftCompanyBox())) {
            $model = Model::query()->where('raft_company_box_id', $box->id)->first();
        }
        $data = ['user' => $user, 'model' => $model];
        //return view($view, $data);
        //d($data,$user->getRaftCompanyBox());
        try {
            $pdf = SnappyPdf::loadView($view, $data);
            return $pdf->inline(trans_choice('choice.Appointments', 1).'.pdf');
        }
        catch (\Exception $exception) {
            config('app.debug') && d($exception);
        }
        return view($view, $data);
    }
}

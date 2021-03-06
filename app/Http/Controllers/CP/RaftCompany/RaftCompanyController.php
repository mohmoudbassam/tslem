<?php

namespace App\Http\Controllers\CP\RaftCompany;

use Alkoumi\LaravelHijriDate\Hijri;
use App\Http\Controllers\Controller;
use App\Models\BeneficiresCoulumns;
use App\Models\RaftCompanyBox;
use App\Models\Session;
use App\Models\User;
use ConvertApi\ConvertApi;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PhpOffice\PhpWord\TemplateProcessor;
use Yajra\DataTables\DataTables;

class RaftCompanyController extends Controller
{
    public function index()
    {
        return view("CP.raft_company.index");
    }

    public function add_center()
    {
        $data['record'] = BeneficiresCoulumns::query()->where('type', 'raft_center')->first();
        $data['type'] = 'raft_center';
        $data['boxes'] = RaftCompanyBox::query()->select('box')->where('raft_company_location_id', auth()->user()->raft_company_type)->groupBy('box')->get()->toArray();

        return view("CP.raft_company.add_center", $data);
    }

    public function save_center(Request $request)
    {

        $request->validate([
            'email' => 'required|email|unique:users,email',
            'name'  => 'required|string|unique:users,name',
            'phone' => 'required|numeric|unique:users,phone',
        ]);

        $user = User::query()->create([
            'type'               => 'service_provider',
            'parent_id'          => auth()->user()->id,
            'name'               => request('name'),
            'company_name'       => request('company_name'),
            'company_owner_name' => request('company_owner_name'),
            'email'              => request('email'),
            'box_number'         => request('box_number'),
            'camp_number'        => request('camp_number'),
            'phone'              => request('phone'),
            'employee_number'    => request('employee_number'),
            'password'           => request('password'),
            'verified'           => 1,
            'is_file_uploaded'   => 1,
        ]);
        $this->uploadUserFiles($user, $request);
        return back()->with(['success' => '?????? ?????????? ?????????????? ??????????']);
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

    public function centers_list(Request $request)
    {
        $users = User::query()->where('parent_id', auth()->user()->id)->when(request('name'), function ($q) {
            $q->where('name', 'like', '%'.request('name').'%')->where('type', 'raft_center');
            $q->orwhere('email', 'like', '%'.request('name').'%')->where('type', 'raft_center');
            $q->orwhere('phone', 'like', '%'.request('name').'%')->where('type', 'raft_center');
        });
        return DataTables::of($users)->make(true);
    }

    public function list(Request $request)
    {

        $session = Session::query()->with('RaftCompanyBox')
            ->where('raft_company_location_id', auth()->user()->raft_company_type)->published()->get();

        return DataTables::of($session)
            ->addColumn('actions', function ($session) {
                $view_files_and_appoitment = '';
                $view_maintainance_files = '';

                if ($session->RaftCompanyBox->file_first) {
                    $view_maintainance_files = '<a class="dropdown-item"  href="'.route('raft_company.view_maintainance_files', ['session' => $session->id]).'" href="javascript:;"><i class="fa fa-eye mx-2"></i>?????? ?????????????? ?? ?????????????????? </a>';
                }
                if ($session->RaftCompanyBox->file_first == null) {
                    $view_files_and_appoitment = '<a class="dropdown-item"  href="'.route('raft_company.view_files_and_appointment', ['session' => $session->id]).'" href="javascript:;"><i class="fa fa-eye mx-2"></i>?????? ???????????? ???????????????? </a>';
                }
                $element = '<div class="btn-group me-1 mt-2">
                                            <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                ????????????<i class="mdi mdi-chevron-down"></i>
                                            </button>
                                            <div class="dropdown-menu" style="">

                                               '.$view_files_and_appoitment.'
                                               '.$view_maintainance_files.'

                                                </div>
                              </div>';
                return $element;
            })->rawColumns(['actions'])
            ->make(true);
    }

    public function get_camp_by_box($box)
    {
        $camps = RaftCompanyBox::query()->where('box', $box)->get()->pluck('camp');

        return response()->json([
            'success' => true,
            'page'    => view('CP.raft_company._select_camp', ['camps' => $camps])->render(),
        ]);
    }

    public function campsByBoxNumber($box): JsonResponse
    {
        $camps = RaftCompanyBox::query()->where('box', $box)->get()->pluck('camp','id');
        return response()->json([
            'success' => !0,
            'page'    => view('CP.raft_company._select_camps_with_ids', ['camps' => $camps])->render(),
        ]);
    }

    public function view_files_and_appointment(Session $session)
    {

        $files = [
            [
                'name'     => '???????? ?????????? ???????? ???????????????? ?????????? ??????????????',
                'path'     => 'Mechanical.pdf',
                'url_type' => 1,
            ], [
                'name'     => '?????? ???????????????????? ?????????????????? ???????????????????? ?????? ?????????? ???????????????? ???????????? ?????????????????? ?????????? ???? 1443 ????',
                'path'     => 'Mechanical.pdf',
                'url_type' => 2,
            ], [
                'name'     => '???????? ?????????? ????????????????',
                'path'     => 'Mechanical.pdf',
                'url_type' => 3,
            ],
        ];
        return view('CP.raft_company.show_appoitment', [
            'session' => $session,
            'files'   => $files,
        ]);
    }

    public function docx_file($fileType, Session $session)
    {

        $file_type = $this->fileType($fileType);

        $file_name = uniqid(auth()->user()->id.'_').'.docx';

        $templateProcessor = new TemplateProcessor(Storage::disk('public')->path($file_type));

        $templateProcessor->setValues([
            'box'  => $session->RaftCompanyBox->box,
            'cmp'  => $session->RaftCompanyBox->camp,
            'date' => Hijri::Date('Y/m/d'),
            'time' => now()->format('H:i'),
        ]);
        $templateProcessor->saveAs(Storage::disk('public')->path('service_provider_generator/'.$file_name));

        ConvertApi::setApiSecret('uVAzHfhZAhfyQ1mZ');
        $result = ConvertApi::convert('pdf', [
            'File' => Storage::disk('public')->path('service_provider_generator/'.$file_name),
        ], 'docx'
        );

        $result->saveFiles(Storage::disk('public')->path('service_provider_generator/'.Str::replace('.docx', '.pdf', $file_name)));


        return Response::download(Storage::disk('public')->path('service_provider_generator/'.Str::replace('.docx', '.pdf', $file_name)), Str::replace('.docx', '.pdf', $file_type));

    }

    public function fileType($type)
    {

        if (!in_array($type, [1, 2, 3])) {
            abort(404);
        }
        return [
            '1' => '???????? ?????????? ???????? ???????????????? ?????????? ??????????????.docx',
            '2' => '?????? ???????????????????? ?????????????????? ???????????????????? ?????? ?????????? ???????????????? ???????????? ?????????????????? ?????????? ???? 1443 ????.docx',
            '3' => '???????? ?????????? ????????????????.docx',
        ][$type];
    }

    public function view_maintainance_files(Session $session)
    {

        return view('CP.raft_company.view_maintainance_files', compact('session'));
    }

    public function seen_maintain_file(Session $session)
    {
        //        $session->RaftCompanyBox->update([
        //            'seen_notes'=>1
        //        ]);
        RaftCompanyBox::where("box", $session->RaftCompanyBox->box)->where("camp", $session->RaftCompanyBox->camp)->update([
            'seen_notes' => 1,
        ]);
        return redirect()->route('raft_company');
    }

}

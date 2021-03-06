<?php

namespace App\Http\Controllers\CP\ServiceProviders;

use Alkoumi\LaravelHijriDate\Hijri;
use App\Http\Controllers\Controller;
use App\Models\License;
use App\Models\Order;
use App\Models\OrderSharer;
use App\Models\RaftCompanyBox;
use App\Models\ServiceProviderFiles;
use App\Models\Session;
use App\Models\User;
use App\Notifications\OrderNotification;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use NcJoes\OfficeConverter\OfficeConverter;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Settings;
use PhpOffice\PhpWord\TemplateProcessor;
use Yajra\DataTables\DataTables;

class OrdersController extends Controller
{
    public function orders()
    {
        $data['designers'] = User::query()->whereHas('designer_orders', function ($q) {
            $q->where('owner_id', auth()->user()->id);
        })->get();
        $data['consulting'] = User::query()->whereHas('consulting_orders', function ($q) {
            $q->where('owner_id', auth()->user()->id);
        })->get();
        $data['contractors'] = User::query()->whereHas('contractors_orders', function ($q) {
            $q->where('owner_id', auth()->user()->id);
        })->get();

        if(auth()->user()->license_number){
            $box=RaftCompanyBox::query()->where('license_number',auth()->user()->license_number)->first();
            if(isset($box)){
                 $data['can_create_order']=$box->seen_notes;
            }else{
                $data['can_create_order']=0;
            }
        }else{
            $box = RaftCompanyBox::query()->where('box',auth()->user()->box_number)->where('camp',auth()->user()->camp_number)->first();
            if(isset($box)){
                $data['can_create_order']=$box->seen_notes;
            }else{
                $data['can_create_order']=0;
            }
        }

        if(isset($box)){
            $data['box']= $box;
        }
        return view('CP.service_providers.orders', $data);
    }

    public function create_order()
    {
        $data['designers'] = User::query()->whereVitrified() ->where("enabled", 1)->where('type', 'design_office')->get();

        return view('CP.service_providers.create_order', $data);
    }

    public function save_order(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'designer_id' => Rule::exists("users", "id")->where(function ($query) {
                $query->where("type", "design_office");
            }),
//            'agree_to_designer_has_no_fire_specialty' => ['required', Rule::in([1,"1"])],
        ]);

        if ($validator->fails()) {
            return redirect()->route('services_providers.create_order')->with([
                'error' => '?????? ???? ?????????? ??????????',
                'errors' => $validator->errors()
            ]);
        }

        $order = Order::query()->create([
            "title" => Str::random(15),
            "description" => Str::random(15),
            "date" => date("Y-m-d"),
            "owner_id" => auth()->user()->id,
            "designer_id" => $request->designer_id,
            "identifier" => randomIntIdentifier()
        ]);
        $order->save();

        $sharers = User::query()->where("type", User::SHARER_TYPE)->pluck('id');
        $order->orderSharer()->saveMany($sharers->map(function ($item) {
            return new OrderSharer(["user_id" => $item]);
        }));

        $order->saveLog("created", $request->designer_id);
        $user = User::query()->find($request->designer_id);

        $user->notify(new OrderNotification('???? ?????????? ?????????? #'.$order->identifier.' ?????? ?????????? ???????????? ????????????????  ', auth()->user()->id));
        return redirect()->route('services_providers.orders')->with(['success' => '???? ?????????? ?????????? ??????????']);
    }

    public function list(Request $request)
    {

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
            ->whereServiceProvider(auth()->user()->id)
            ->with(['designer', 'contractor', 'consulting']);

            if($request->waste_contractor){
                $order = $order->whereWasteContractor($request->waste_contractor);
            }

        return DataTables::of($order)
            ->addColumn('created_at', function ($order) {
                return $order->created_at->format('Y-m-d');
            })
            ->addColumn('order_status', function ($order) {
                return $order->order_status;
            })
            ->addColumn('actions', function (Order $order) {
                $add_designer = '';
                $add_contractor_and_consulting_office = '';
                $actions = '';
                if ($order->designer_id == null) {
                    $add_designer = '<a class="dropdown-item" href="' . route('services_providers.edit_order', ['order' => $order->id]) . '" href="javascript:;"><i class="fa fa-file mx-2"></i>?????????? ???????? ?????????? </a>';
                }

                if (($order->status == Order::DESIGN_APPROVED || $order->status == Order::PENDING_LICENSE_ISSUED) && ($order->contractor_id == null || $order->consulting_office_id == null)) {
                    $add_contractor_and_consulting_office = '<a class="dropdown-item" onclick="showModal(\'' . route('services_providers.add_constructor_form', ['order' => $order->id]) . '\')" href="javascript:;"><i class="fa fa-plus mx-2"></i>?????????? ?????????????? ????????????</a>';
                }

                if( $order->status >= Order::PENDING_OPERATION ) {
                    $_title = \App\Models\License::trans('download_for_service_provider');
                    $_route = route('licenses.view_pdf', [ 'order' => $order->id ]);
                    $view = <<<HTML
    <a class="dropdown-item "  type="button"  href="{$_route}">
        {$_title}
    </a>
HTML;
                    $actions .= $view;
                }

                if( $order->status >= Order::FINAL_LICENSE_GENERATED ) {
                    $_title = \App\Models\License::trans('download_execution_license_for_service_provider');
                    $_route = route('licenses.view_pdf_execution_license', [ 'order' => $order->id ]);
                    $view = <<<HTML
    <a class="dropdown-item "  type="button"  href="{$_route}">
        {$_title}
    </a>
HTML;
                    $actions .= $view;
                }

                if (empty($add_designer) && empty($add_contractor_and_consulting_office) && empty($actions)) {
                    $element = '';
                } else {

                    $element = '<div class="btn-group me-1 mt-2">
                                            <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                ????????????<i class="mdi mdi-chevron-down"></i>
                                            </button>
                                            <div class="dropdown-menu" style="">
                                               ' . $add_designer . '
                                               ' . $add_contractor_and_consulting_office . '
                                               ' . $actions . '
                                                </div>
                              </div>';
                }

                return $element;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function upload_files($order, $request)
    {

        foreach ((array)$request->file('files') as $file) {
            $path = Storage::disk('public')->put('order/' . $order->id, $file);
            $file_name = $file->getClientOriginalName();
            $order->file()->create([
                'path' => $path,
                'real_name' => $file_name
            ]);
        }
    }

    public function edit_order(Order $order)
    {
        $data['designers'] = User::query()
            ->whereVitrified() ->where("enabled", 1)->where('type', 'design_office')->get();
        $data['order'] = $order;

        return view('CP.service_providers.edit_order', $data);
    }

    public function update_order(Request $request)
    {
        $orderDetails = Order::query()->where('id', $request->order_id)->first();
        $order = tap($orderDetails)
            ->update($request->except('files', '_token', 'order_id'));

        $order->saveLog("created", $request->designer_id);
        $user = User::query()->find($request->designer_id);

        $user->notify(new OrderNotification('???????? ???????? ?????? #'.$orderDetails->identifier.' ?????????????? ?????????????? ', auth()->user()->id));
        return redirect()->route('services_providers.orders')->with(['success' => '???? ?????????? ?????????? ??????????']);


    }

    public function add_constructor_form(Order $order)
    {
        $contractors = User::query()->where('type', '=', 'contractor')
            ->where("verified", 1)
            ->where("enabled", 1)
            ->get();
            $consulting_offices = User::query()->where('type', '=', 'design_office')
            ->where("verified", 1)
                ->where("enabled", 1)
            ->whereHas("designer_types", function ($query) {
                $query
                    ->where("type", "consulting");
            })
            ->get();
        $wasteContractors = wasteContractorsList();



        return response()->json([
            'success' => true,
            'page' => view('CP.service_providers.chice_constractor', [
                'order' => $order,
                'contractors' => $contractors,
                'consulting_offices' => $consulting_offices,
                'waste_contractors' => $wasteContractors
            ])->render()
        ]);

    }

    public function choice_constructor_action(Request $request)
    {
        $order = Order::query()->findOrFail($request->id);

        $old_contractor_id = $order->contractor_id;
        $old_consulting_office_id = $order->consulting_office_id;

        $update = [
            'status' => Order::PENDING_LICENSE_ISSUED
        ];
        if($request->waste_contractor){
            $update['waste_contractor'] = $request->waste_contractor;
        }
        if($request->consulting_office_id){
            $update['consulting_office_id'] = $request->consulting_office_id;
        }
        if($request->contractor_id){
            $update['contractor_id'] = $request->contractor_id;
        }

        $order->update($update);
        $order->saveLog("filled");

        if($old_contractor_id != $request->contractor_id){
            optional($order->consulting)->notify(new OrderNotification('???? ?????????????? ?????????? ?????????????? ?????? ?????????? #'.$order->identifier.' ???????? ?????????????? ???? ???????? ?????????? ?????????????? ???? ?????????????? ????????????', auth()->user()->id));
        }
        if($old_consulting_office_id != $request->consulting_office_id){
            optional($order->contractor)->notify(new OrderNotification('???? ?????????????? ?????????? ?????????????? ?????? ?????????? #'.$order->identifier.' ???????? ?????????????? ???? ???????? ?????????????? ???? ???? ????????????????', auth()->user()->id));
        }
        return response()->json([
            'success' => true,
            'message' => '???? ???????????????? ??????????'
        ]);
    }

    public function show_appointment()
    {
        $session = Session::query()->where('user_id', auth()->user()->id)->first();

        $files = [
            [
                'name' => '???????? ?????????? ???????? ???????????????? ?????????? ??????????????',
                'path' => 'Mechanical.pdf',
                'url_type'=>1
            ], [
                'name' =>'?????? ???????????????????? ?????????????????? ???????????????????? ?????? ?????????? ???????????????? ???????????? ?????????????????? ?????????? ???? 1443 ????',
                'path' => 'Mechanical.pdf',
                'url_type'=>2
            ], [
                'name' =>'???????? ?????????? ????????????????',
                'path' => 'Mechanical.pdf',
                'url_type'=>3
            ]
        ];
        return view('CP.service_providers.show_appointment', [
            'session' => $session,
            'files' => $files
        ]);
    }

    public function show_main_files()
    {
        $files = ServiceProviderFiles::query()->where('service_providers_id', auth()->user()->id)->get();
        return view('CP.service_providers.view_maintainance_files', [
            'files' => $files
        ]);
    }

    public function seen_maintain_file()
    {
        auth()->user()->update([
            'service_provider_status' => 3
        ]);
        return redirect()->route('services_providers.orders');
    }

    public function docx_file($fileType)
    {
          $file_type=$this->fileType($fileType);

        $file_name = uniqid(auth()->user()->id . '_') . '.docx';
        $this->getWordToPDF($file_name);
        $templateProcessor = new TemplateProcessor(Storage::disk('public')->path($file_type));

        $templateProcessor->setValues([
            'name' => auth()->user()->company_name,
            'box'=>auth()->user()->box_number,
            'cmp'=>auth()->user()->camp_number,
            'date'=>Hijri::Date('Y/m/d'),
            'time'=>now()->format('H:i')
        ]);
        $this->getWordToPDF($file_name);
        $templateProcessor->saveAs(Storage::disk('public')->path('service_provider_generator/' . $file_name));

        return Response::download(Storage::disk('public')->path('service_provider_generator/'. $file_name),$file_type);

    }

    public function fileType($type){

        if(!in_array($type,[1,2,3])){abort(404);}
        return [
            '1'=>'???????? ?????????? ???????? ???????????????? ?????????? ??????????????.docx',
            '2'=>'?????? ???????????????????? ?????????????????? ???????????????????? ?????? ?????????? ???????????????? ???????????? ?????????????????? ?????????? ???? 1443 ????.docx',
            '3'=>'???????? ?????????? ????????????????.docx'
        ][$type];
    }

    public static function getWordToPDF($file_name)
    {

        $unoconv = exec('/usr/bin/unoconv -f pdf ' );
//to specify output directory, specify it as the second argument to the constructor
       // $converter = new OfficeConverter('test-file.docx', 'path-to-outdir');
//        $domPdfPath = base_path('vendor/dompdf/dompdf');
//
//        Settings::setPdfRendererPath($domPdfPath);
//
//        Settings::setPdfRendererName('DomPDF');
//
//        $Content = IOFactory::load(Storage::disk('public')->path('service_provider_generator/'.$file_name));
//
//        $PDFWriter = IOFactory::createWriter($Content, 'PDF');
//
//        $file_name=str_replace('docx','pdf',$file_name);
//
//        $PDFWriter->save(Storage::disk('public')->path('service_provider_generator/'.$file_name));

    }

}

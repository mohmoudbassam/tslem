<?php

namespace App\Http\Controllers\CP\Designer;

use App\Http\Controllers\Controller;
use App\Models\DesignerRejected;
use App\Models\License;
use App\Models\Order;
use App\Models\OrderService;
use App\Models\OrderSharer;
use App\Models\OrderSpecialtyObligation;
use App\Models\OrderSpecilatiesFiles;
use App\Models\Service;
use App\Models\Specialties;
use App\Models\User;
use App\Notifications\OrderNotification;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class DesignerOrderController extends Controller
{

    public function orders()
    {
        $data[ 'services_providers' ] = User::query()->whereHas('orders', function($q) {
            $q->where('designer_id', auth()->user()->id);
        })->get();

        return view('CP.designer.orders', $data);
    }

    public function list(Request $request)
    {
        $order = Order::query()
                      ->when(!is_null($request->query("order_identifier")), function($query) use ($request) {
                          $query->where("identifier", "LIKE", "%" . $request->query("order_identifier") . "%");
                      })
                      ->when(!is_null($request->query("from_date")), function($query) use ($request) {
                          $query->whereDate("created_at", ">=", $request->query("from_date"));
                      })
                      ->when(!is_null($request->query("to_date")), function($query) use ($request) {
                          $query->whereDate("created_at", "<=", $request->query("to_date"));
                      })
                      ->with('service_provider')
                      ->whereOrderId($request->order_id)
                      ->whereDate($request->from_date, $request->to_date)
                      ->whereServiceProviderId($request->service_provider_id)
                      ->orderByDesc('created_at')
                      ->whereDesigner(auth()->user()->id)
                      ->with('designer');

        return
            DataTables::of($order)
                      ->addColumn('identifier', function(Order $order) {
                          return ($order->final_report()->value('consulting_office_final_report_note') ?
                                  '<i class="fa fa-star-of-life mx-2 text-danger" style="font-size: 8px !important;"></i>' : '') .
                              $order->identifier;
                      })
                      ->addColumn('actions', function(Order $order) {
                          $add_file_design = '';
                          $edit_files = '';
                          $element = "";

                          if( $order->status >= Order::PENDING_OPERATION ) {
                              $_title = \App\Models\License::trans('download_for_service_provider');
                              $_route = route('licenses.view_pdf', [ 'order' => $order->id ]);
                              $view = <<<HTML
    <a class="dropdown-item " type="button" target="_blank" href="{$_route}">
        {$_title}
    </a>
HTML;
                              $element .= $view;
                          }

                          if( $order->status >= Order::FINAL_LICENSE_GENERATED ) {
                              $_title = \App\Models\License::trans('download_execution_license_for_service_provider');
                              $_route = route('licenses.view_pdf_execution_license', [ 'order' => $order->id ]);
                              $view = <<<HTML
    <a class="dropdown-item " type="button" target="_blank" href="{$_route}">
        {$_title}
    </a>
HTML;
                              $element .= $view;
                          }

                          $view = '<a class="dropdown-item" href="' . route('design_office.view_file', [ 'order' => $order->id ]) . '" href="javascript:;"><i class="fa fa-eye mx-2"></i>?????? ?????????? </a>';

                          if( $order->status == Order::REQUEST_BEGIN_CREATED ) {
                              $add_file_design = '<a class="dropdown-item" href="' . route('design_office.add_files', [ 'order' => $order->id ]) . '" href="javascript:;"><i class="fa fa-file mx-2"></i>?????????? ????????????  </a>';
                          }

                          if( $order->lastDesignerNote()->where('status', 0)->exists()
                              || ($order->orderSharerRegected()->exists() && $order->delivery_notes == 1)
                          ) {
                              $edit_files = '<a class="dropdown-item" href="' . route('design_office.edit_files', [ 'order' => $order->id ]) . '" href="javascript:;"><i class="fa fa-file mx-2"></i>?????????? ?????????????? </a>';
                          }

                          $element = $element ?: '
   ' . $add_file_design . '
   ' . $edit_files . '
   ';
                          return <<<HTML
<div class="btn-group me-1 mt-2">
    <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        ????????????<i class="mdi mdi-chevron-down"></i>
    </button>
    <div class="dropdown-menu" style="">
    {$view}
    {$element}
    </div>
</div>
HTML;
                      })
                      ->addColumn('created_at', function($order) {
                          return $order->created_at->format('Y-m-d');
                      })
                      ->addColumn('order_status', function($order) {
                          return $order->order_status;
                      })
                      ->rawColumns([ 'actions', 'identifier' ])
                      ->setRowClass(fn(Order $o) => $o->hasDesignerWarning() ? 'alert-warning' : '')
                      ->make(true);
    }

    public function accept(Order $order)
    {

        if( $order->status == Order::PENDING ) {
            $order->status = Order::REQUEST_BEGIN_CREATED;
            $order->save();
            $order->saveLog("approved-designer");

            optional($order->service_provider)->notify(new OrderNotification('??????????????, ???? ???????? ???????? #' . $order->identifier . ' ???? ???????? ??????????????', $order->designer_id));

            return redirect()->route('design_office.orders');
        }

        return redirect()->route('design_office.orders')->with([ 'success' => '?????? ???????????????? ?????? ?????????? ??????????' ]);

    }

    public function reject(Request $request, Order $order)
    {
        $validation = Validator::make($request->all(), [
            'rejection_note' => 'required|string|max:1000',
        ]);

        if( $validation->fails() ) {
            return back('post/create')
                ->withErrors([ "???? ???????? ???????? ?????????????? ?????? ??????????" ]);
        }

        if( $order->status == Order::PENDING ) {
            $order->status = Order::PENDING;
            // save_logs($order, $order->designer_id, '???? ?????? ?????????? #'.$order->identifier.' ???? ???????? ?????????????? ????????'.$request->input("rejection_note"));
            optional($order->service_provider)->notify(new OrderNotification('???? ?????? ?????????? #' . $order->identifier . ' ???????? ' . $request->input("rejection_note"), $order->designer_id));
            $order->designer_id = null;
            DesignerRejected::query()->create([
                                                  'order_id' => $order->id,
                                                  'designer_id' => auth()->user()->id,
                                                  'rejection_note' => $request->input("rejection_note"),
                                              ]);
            $order->save();
            $order->saveLog("rejected-designer");
        }

        return redirect()->route('design_office.orders')->with([ 'success' => '???? ?????? ?????????? ??????????' ]);
    }

    public function add_files(Order $order)
    {
        $specialties = Specialties::with('service')->get();
        $service = Service::all();

        //dd($service);
        return view('CP.designer.add_files', [ 'order' => $order, 'specialties' => $specialties, 'services' => $service ]);
    }

    public function save_file(Request $request)
    {
        if( $request->has('validate') ) {
            $file_validation = $this->validate_file($request);
            if( !$file_validation[ 'success' ] ) {
                $file_validation[ '_token' ] = csrf_token();

                return response()->json($file_validation);
            }

            $obligation_file_validation = $this->validate_obligation_file($request);
            if( !$obligation_file_validation[ 'success' ] ) {
                $obligation_file_validation[ '_token' ] = csrf_token();

                return response()->json($obligation_file_validation);
            }

            return response()->json([
                                        'success' => true,
                                        '_token' => csrf_token(),
                                    ]);
        }

        $order = Order::query()->find(request('order_id'));
        $specialties_names = Specialties::query()->get()->pluck('name_en')->toArray();
        $data = collect($request->except('_token', 'order_id'))->map(function($item, $key) use ($specialties_names) {
            if( in_array($key, $specialties_names) ) {
                return $item;
            }

            return null;
        })->filter();

        foreach( $data as $specialties => $services ) {
            foreach( $services as $service ) {

                OrderService::query()->create([
                                                  'service_id' => $service[ 'service_id' ],
                                                  'order_id' => $order->id,
                                                  'unit' => $service[ 'unit' ],
                                              ]);

            }
            $specialties_obj = Specialties::query()->where('name_en', $specialties)->first();
            if( $specialties_obj ) {
                if( request($specialties . '_pdf_file') ) {
                    $this->upload_files($order, $specialties_obj, request($specialties . '_pdf_file'), 1);
                }
                if( request($specialties . '_cad_file') ) {
                    $this->upload_files($order, $specialties_obj, request($specialties . '_cad_file',), 2);
                }
                if( request($specialties . '_docs_file') ) {
                    $this->upload_files($order, $specialties_obj, request($specialties . '_docs_file'), 3);
                }

            }
        }

        if( request('souls_safety_file') ) {
            $path = Storage::disk('public')->put("orders/$order->id", request('souls_safety_file'));
            $file_name = request('souls_safety_file')->getClientOriginalName();
            OrderSpecilatiesFiles::query()->create([
                                                       'path' => $path,
                                                       'real_name' => $file_name,
                                                       'specialties_id' => 1,
                                                       'order_id' => $order->id,
                                                       'type' => 5,
                                                   ]);
        }

        if( request('warning_file') ) {
            $path = Storage::disk('public')->put("orders/$order->id", request('warning_file'));
            $file_name = request('warning_file')->getClientOriginalName();
            OrderSpecilatiesFiles::query()->create([
                                                       'path' => $path,
                                                       'real_name' => $file_name,
                                                       'specialties_id' => 1,
                                                       'order_id' => $order->id,
                                                       'type' => 6,
                                                   ]);
        }

        if( request('fire_fighter_file') ) {
            $path = Storage::disk('public')->put("orders/$order->id", request('fire_fighter_file'));
            $file_name = request('fire_fighter_file')->getClientOriginalName();
            OrderSpecilatiesFiles::query()->create([
                                                       'path' => $path,
                                                       'real_name' => $file_name,
                                                       'specialties_id' => 1,
                                                       'order_id' => $order->id,
                                                       'type' => 7,
                                                   ]);
        }

        if( request('other_file') ) {
            $path = Storage::disk('public')->put("orders/$order->id", request('other_file'));
            $file_name = request('other_file')->getClientOriginalName();
            OrderSpecilatiesFiles::query()->create([
                                                       'path' => $path,
                                                       'real_name' => $file_name,
                                                       'specialties_id' => 1,
                                                       'order_id' => $order->id,
                                                       'type' => 8,
                                                   ]);
        }

        // Uploading Obligation Files
        if( $request->has('obligations') ) {
            foreach( $request[ "obligations" ] as $specialtyKey => $obligations ) {
                $specialty = Specialties::where("name_en", $specialtyKey)->first();
                foreach( $obligations as $type => $obligationFile ) {
                    $path = Storage::disk('public')->put("obligations/$order->id/", $obligationFile);
                    OrderSpecialtyObligation::query()->create([
                                                                  'path' => $path,
                                                                  'specialties_id' => $specialty->id,
                                                                  'order_id' => $order->id,
                                                                  'type' => $type,
                                                              ]);
                }
            }
        }

        if( !($request->has('uploading') || $request->has('validate')) ) {
            session()->put('success', '?????? ?????????? ???????????????? ??????????');

            $order->status = 3;
            $order->save();
        }

        return response()->json([
                                    'success' => true,
                                    'message' => '?????? ?????????? ???????????????? ??????????',
                                ]);

    }

    private function validate_file($request)
    {
        if( !(request('souls_safety_file')) ) {
            return [
                'success' => false,
                'message' => "???????????? ?????????? ?????? ?????????? ?????????????? ",
            ];
        }

        $specialties_names = Specialties::query()->get()->pluck('name_en')->toArray();
        $specialties = collect($request->except('_token', 'order_id'))->map(function($item, $key) use ($specialties_names) {
            if( in_array($key, $specialties_names) ) {
                return $item;
            }

            return null;
        })->filter()->keys();
        foreach( $specialties as $key => $_specialties ) {

            if( !(request($_specialties . '_pdf_file') && request($_specialties . '_cad_file')) ) {
                $name = Specialties::query()->where('name_en', $_specialties)->first()->name_ar;

                return [
                    'success' => false,
                    'message' => " ???????????? ?????????? ???????? ?????????? $name",
                ];
            }

        }

        return [
            'success' => true,
        ];
    }

    private function validate_obligation_file(Request $request)
    {
        $specialties = Specialties::pluck('name_en')->toArray();
        $rules = [
            'obligations' => [ 'required', 'array', 'max:' . count($specialties), 'min:1' ],
            'obligations.*' => [ Rule::in($specialties) ],
        ];

        foreach( $specialties as $specialty ) {
            $obligationFilesTypes = get_specialty_obligation_files_types($specialty);
            $rules[ "obligations.$specialty" ] = [ "sometimes", "array", "size:" . count($obligationFilesTypes) ];
            if( $request->has('validate') ) {
                $rules[ "obligations.$specialty.*" ] = [ "required", "numeric", "in:1" ];
                $rules[ "types.obligations.$specialty.*" ] = [ "required", "string", "in:application/pdf" ];
                $rules[ "sizes.obligations.$specialty.*" ] = [ "required", "string", "lte:3000" ];
            } else {
                $rules[ "obligations.$specialty.*" ] = [ "required", "file", "mimetypes:application/pdf", "max:3000" ];
            }
        }
        $validator = Validator::make($request->all(), $rules);

        if( $validator->fails() ) {
            return [
                'success' => false,
                'message' => "???????????? ?????? ???????? ?????????? ????????????????",
                'errors' => $validator->errors(),
                'data' => $request[ "obligations" ],
            ];
        }

        return [
            'success' => true,
        ];
    }

    public function upload_files($order, $specialties, $file, $type)
    {

        if( $file ) {

            $path = Storage::disk('public')->put("orders/$order->id", $file);
            $file_name = $file->getClientOriginalName();
            OrderSpecilatiesFiles::query()->create([
                                                       'path' => $path,
                                                       'real_name' => $file_name,
                                                       'specialties_id' => $specialties->id,
                                                       'order_id' => $order->id,
                                                       'type' => $type,
                                                   ]);
        }

    }

    public function get_service_by_id($id)
    {
        return response()->json(Service::query()->find($id));
    }

    public function edit_files(Order $order)
    {
        $specialties = Specialties::with('service')->get();
        //$service = Service::all();
        $order->with('service.specialties');

        $order_specialties = OrderService::query()->with('service.specialties.service')->whereHas('service')->where('order_id', $order->id)->get()->groupBy('service.specialties.name_en');
        $system_specialties_services = Specialties::query()->with('service')->get();
        $order_designer_files = OrderSpecilatiesFiles::query()->with('specialties')->where('order_id', $order->id)->get()->groupBy('specialties.name_en');
        $files = OrderSpecilatiesFiles::query()->with('specialties')->where('order_id', $order->id)->get();
        // type 5 => souls_safety_file
        // type 6 => warning_file
        // type 7 => fire_fighter_file
        // type 8 => other_file
        $order->delivery_notes = 0;
        $order->save();

        return view('CP.designer.edit_files', [
            'order' => $order,
            'specialties' => $specialties,
            'system_specialties_services' => $system_specialties_services,
            'order_specialties' => $order_specialties,
            'order_files' => $order_designer_files,
            'filess' => $files,
        ]);
    }

    public function view_file(Order $order)
    {
        $designerNote = $order->lastDesignerNote()->latest()->first();
        $order_specialties = OrderService::query()->with('service.specialties')->whereHas('service')->where('order_id', $order->id)->get()->groupBy('service.specialties.name_en');
        $files = OrderSpecilatiesFiles::query()->where('order_id', $order->id)->get();
        $last_note = $order->lastDesignerNote()->where('status', 0)->first();
        $tex = null;
        if( $last_note ) {
            $tex = array_filter(preg_split("/\r\n|\n|\r\s+/", $last_note->note));
        }

        $order_sharers = OrderSharer::query()->where('order_id', $order->id)->get();

        return view('CP.designer.view_file', [
            'order' => $order,
            'order_specialties' => $order_specialties,
            'filess' => $files,
            'last_note' => $tex,
            'order_sharers' => $order_sharers,
            'designerNote' => $designerNote,
        ]);

    }

    public function download($id)
    {
        $file = OrderSpecilatiesFiles::query()->where('id', $id)->first();

        $headers = [
            'Content-Type' => 'application/json',
            'Content-Disposition' => "attachment; filename=$file->real_name",
        ];

        return (new Response(Storage::disk('public')->get($file->path), 200, $headers));

    }

    public function delete_service(OrderService $service)
    {
        $service->delete();

        return redirect()->back();
    }

    public function delete_file(OrderSpecilatiesFiles $file)
    {
        $file->delete();

        return redirect()->back();
    }

    public function edit_file_action(Request $request)
    {
        /** @var Order $order */
        $order = Order::query()->where('id', $request->order_id)->first();
        $file_validation = $this->validate_update_file($request, $order);
        if( !$file_validation[ 'success' ] ) {
            return response()->json($file_validation);
        };
        $this->validate_update_file($request, $order);
        OrderService::query()->where('order_id', $order->id)->delete();

        foreach( (array) $request->service as $service ) {

            OrderService::query()->create([
                                              'service_id' => $service[ 'service_id' ],
                                              'unit' => $service[ 'unit' ],
                                              'order_id' => $order->id,
                                          ]);
        }
        $specialties_names = Specialties::query()->get()->pluck('name_en')->toArray();
        $data = collect($request->except('_token', 'order_id'))->map(function($item, $key) use ($specialties_names) {
            if( in_array($key, $specialties_names) ) {
                return $item;
            }

            return null;
        })->filter();

        foreach( $data as $specialties => $services ) {

            foreach( $services as $service ) {

                OrderService::query()->create([
                                                  'service_id' => $service[ 'service_id' ],
                                                  'order_id' => $order->id,
                                                  'unit' => $service[ 'unit' ],
                                              ]);

            }
            $specialties_obj = Specialties::query()->where('name_en', $specialties)->first();

        }

        foreach( Specialties::all() as $specialties ) {

            if( request($specialties->name_en . '_pdf_file') ) {
                $order_pdf_file = OrderSpecilatiesFiles::query()->whereHas('specialties', function($q) use ($specialties) {

                    $q->where('name_en', $specialties->name_en);
                })->where('order_id', $order->id)->first();
                if( $order_pdf_file ) {
                    $order_pdf_file->delete();
                }

                $this->upload_files($order, $specialties, request($specialties->name_en . '_pdf_file'), 1);
            }
            if( request($specialties->name_en . '_cad_file') ) {
                $order_pdf_file = OrderSpecilatiesFiles::query()->whereHas('specialties', function($q) use ($specialties) {
                    $q->where('name_en', $specialties);
                })->where('order_id', $order->id)->where('type', 2)->first();
                if( $order_pdf_file ) {
                    $order_pdf_file->delete();
                }

                $this->upload_files($order, $specialties, request($specialties->name_en . '_cad_file',), 2);
            }
            if( request($specialties->name_en . '_docs_file') ) {
                $order_pdf_file = OrderSpecilatiesFiles::query()->whereHas('specialties', function($q) use ($specialties) {
                    $q->where('name_en', $specialties);

                })->where('order_id', $order->id)->where('type', 3)->delete();
                if( $order_pdf_file ) {
                    $order_pdf_file->delete();
                }
                $this->upload_files($order, $specialties, request($specialties->name_en . '_docs_file'), 3);
            }
        }

        if( request('souls_safety_file') ) {
            $path = Storage::disk('public')->put("orders/$order->id", request('souls_safety_file'));
            $file_name = request('souls_safety_file')->getClientOriginalName();
            OrderSpecilatiesFiles::query()->create([
                                                       'path' => $path,
                                                       'real_name' => $file_name,
                                                       'specialties_id' => 1,
                                                       'order_id' => $order->id,
                                                       'type' => 5,
                                                   ]);
        }

        if( request('warning_file') ) {
            $path = Storage::disk('public')->put("orders/$order->id", request('warning_file'));
            $file_name = request('warning_file')->getClientOriginalName();
            OrderSpecilatiesFiles::query()->create([
                                                       'path' => $path,
                                                       'real_name' => $file_name,
                                                       'specialties_id' => 1,
                                                       'order_id' => $order->id,
                                                       'type' => 6,
                                                   ]);
        }

        if( request('fire_fighter_file') ) {
            $path = Storage::disk('public')->put("orders/$order->id", request('fire_fighter_file'));
            $file_name = request('fire_fighter_file')->getClientOriginalName();
            OrderSpecilatiesFiles::query()->create([
                                                       'path' => $path,
                                                       'real_name' => $file_name,
                                                       'specialties_id' => 1,
                                                       'order_id' => $order->id,
                                                       'type' => 7,
                                                   ]);
        }

        if( request('other_file') ) {
            $path = Storage::disk('public')->put("orders/$order->id", request('other_file'));
            $file_name = request('other_file')->getClientOriginalName();
            OrderSpecilatiesFiles::query()->create([
                                                       'path' => $path,
                                                       'real_name' => $file_name,
                                                       'specialties_id' => 1,
                                                       'order_id' => $order->id,
                                                       'type' => 8,
                                                   ]);
        }

        $order->lastDesignerNote()->update([
                                               'status' => 1,
                                           ]);
        // [A.F] 2022-06-19.
        // Disable this flow. don't update users status.
        //$order->orderSharer()->update([
        //                                  'status' => OrderSharer::PENDING,
        //                              ]);
        //$order->orderSharer()->update([
        //                                  'status' => OrderSharer::PENDING,
        //                              ]);

        $getTasleemUsers = \App\Models\User::where('type', 'Delivery')->get();
        foreach( $getTasleemUsers as $taslemUser ) {
            optional($taslemUser)->notify(new OrderNotification('???? ?????????? ?????????? #' . $order->identifier . ' ???? ???????? ?????????????? ??????????????', $order->designer_id));
        }

        return response()->json([
                                    'success' => true,
                                    'message' => '?????? ?????????? ??????????????  ??????????',
                                ]);
    }

    public function validate_update_file(Request $request, $order)
    {
        $specialties_names = Specialties::all()->pluck('name_ar', 'name_en')->toArray();

        $order_specialties = OrderSpecilatiesFiles::query()->with('specialties')
                                                  ->where('order_id', $order->id)
                                                  ->get()->pluck('specialties.name_en')->unique();
        // Todo: A.F. check this file
        //$general_file = OrderSpecilatiesFiles::query()->where('order_id', $order->id)->where('type', 5)->first();
        //if( !($general_file || request('general_file')) ) {
        //    return [
        //        'success' => false,
        //        'message' => "???????????? ?????????? ?????? ???????????? ?????????? ",
        //    ];
        //}

        foreach( $order_specialties as $order_special ) {
            $file_count = OrderSpecilatiesFiles::query()
                                               ->whereHas('specialties', function($q) use ($order_special) {
                                                   $q->where('name_en', $order_special);
                                               })
                                               ->where('order_id', $order->id)
                                               ->whereIn('type', [ 1, 2 ])->count();

            if( $file_count < 2 ) {

                if( !(request($order_special . '_pdf_file') || request($order_special . '_cad_file')) ) {
                    $name = $specialties_names[ $order_special ];

                    return [
                        'success' => false,
                        'message' => " ???????????? ?????????? ???????? ?????????? $name",
                    ];
                }

            }

        }

        return [
            'success' => true,
        ];
    }

    public function get_service_obligation_files()
    {
        $data = [];
        foreach( \request()->query as $key => $q ) {
            $data[] = get_specialty_obligation_files($key);
        }

        return \response()->json([
                                     "data" => $data,
                                     "success" => true,
                                     "message" => "",
                                 ]);
    }

    public function order_agreement_form(Request $request, Order $order)
    {
        return \response()->json([
                                     "page" => view('CP.designer.order_agreement_form', [
                                         'model' => $order,
                                     ])->render(),
                                     "success" => true,
                                     "message" => "",
                                 ]);
    }

    public function order_agreement(Request $request, Order $order)
    {
        $order->agree();
        $success = $order->agreed;
        if( $success ) {
            if( $request->expectsJson() ) {
                return response()->json([
                                            'success' => true,
                                            'message' => '?????? ?????????????? ??????????',
                                        ]);
            }

            return redirect()->route('consulting_office.reports_view_details', $order)->with('success', '?????? ?????????????? ??????????');
        }

        if( $request->expectsJson() ) {
            return response()->json([
                                        'success' => false,
                                        'message' => '?????? ???? ?????????? ??????????????',
                                    ]);
        }

        return redirect()->route('consulting_office.reports_view_details', $order)->with('error', '?????? ???? ?????????? ??????????????');
    }
}




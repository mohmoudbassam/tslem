@extends('CP.master')
@section('title')
    الطلبات
@endsection
@section('style')
    <style>
        .close {
            color: #fff !important;
            visibility: hidden !important;
        }

        .file-caption-main {
            color: #fff !important;
            visibility: hidden !important;
        }

        .krajee-default.file-preview-frame {
            margin: 8px;
            border: 1px solid rgba(0, 0, 0, .2);
            box-shadow: 0 0 10px 0 rgb(0 0 0 / 20%);
            padding: 6px;
            float: left;
            width: 50%;
            text-align: center;
        }

        file-drop-zone clearfix {
        }

        .details_p {
            font-size: 20px;
        }

        .bold {
            font-weight: bold;
        }

        .nav-link {
            padding: 0.6rem 1rem 0.8rem;
        }
    </style>
@endsection
@section('content')

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">


                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">الطلبات</a></li>
                        <li class="breadcrumb-item active">الرئيسية</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <ul
                class="nav nav-pills justify-content-start"
                role="tablist"
            >
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" data-hash="#details" href="#details" role="tab">
                        <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                        <span class="d-none d-sm-block">تفاصيل الطلب</span>
                    </a>
                </li>
                {{--@if($order->is_accepted(auth()->user()))
                    <li class="nav-item">
                        <a
                            class="nav-link"
                            data-bs-toggle="tab"
                            data-hash="#reports"
                            href="#reports"
                            role="tab"
                        >
                            <span class="d-block d-sm-none">
                                <i class="fas fa-home"></i>
                            </span>
                            <span class="d-none d-sm-block">@lang('attributes.reports')</span>
                        </a>
                    </li>
                @endif--}}
            </ul>

            <!-- Tab panes -->
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <!-- Nav tabs -->

            @if(intval($order->status) >= intval($order::PENDING_OPERATION))
                <div class="col-md-12 my-3 text-end">
                    <a id="license-type-2-button" class="btn btn-primary license-type-1-button mx-1" target="_blank" href="{{route('licenses.view_pdf', ['order' => $order->id])}}">
                        <i class="fa fa-arrow-down pe-2"></i>
                        {{\App\Models\License::trans('download_for_service_provider')}}
                    </a>
                    @if(intval($order->status) >= intval($order::FINAL_LICENSE_GENERATED))
                        <a id="license-type-2-button" class="btn btn-primary license-type-2-button mx-1" target="_blank" href="{{route('licenses.view_pdf_execution_license', ['order'=>$order->id])}}">
                            <i class="fa fa-arrow-down pe-2"></i>
                            {{\App\Models\License::trans('download_execution_license_for_service_provider')}}
                        </a>
                    @endif

                    @if($order->isPendingOperation() && !$order->agreed)
                        <a id="agreement-button" class="btn btn-outline-info agreement-button" href="#">
                            <i class="fa fa-plus pe-2"></i>
                            {{\App\Models\Order::trans('agreement_name')}}
                        </a>
                    @endif
                </div>
            @endif


            <div class="tab-content p-3 text-muted">
                <div
                    class="tab-pane active"
                    id="details"
                    role="tabpanel"
                >
                    <table class="table table-bordered">
                        <body>
                        <tr>
                            <td width="50%"><span class="bold"> رقم الطلب : </span>{{$order->identifier}}</td>
                            <td width="50%"><span class="bold"> التاريخ :  </span>{{$order->created_at->format("Y-m-d")}}</td>
                        </tr>
                        <tr>
                            @if($order->service_provider->raft_company_name)
                                <td width="50%"><span
                                        class="bold"
                                    >مركز الخدمة :
                                    </span> {{ $order->service_provider->raft_company_name }}</td>
                            @endif
                            <td width="50%"><span
                                    class="bold"
                                >رقم هاتف مركز الخدمة :
                                </span> {{$order->service_provider->phone}}</td>
                        </tr>
                        <tr>
                            <td width="50%"><span class="bold">  <span
                                        class="bold"
                                    >البريد الإلكتروني لمركز الخدمة :
                                </span> {{$order->service_provider->email}}</td>
                            <td width="50%"><span
                                    class="bold"
                                > اسم المشرف :
                                </span>{{$order->designer->company_name}}</td>
                        </tr>

                        </body>
                    </table>

                   {{-- @if(!$order->isContractorFinalReportApproved() && $order->userCanAttachFinalReport())
                    <div class="row">
                            <div class="bold border col-md-12 my-3 p-2 rounded-start text-start {{($contractor_note = $order->getContractorFinalReportNote()) ? "bg-soft-danger border-danger text-danger " : " "}}">
                                {{$contractor_note ?: '-'}}
                                <span class="float-end">
                                @include('CP.order.final_report_button', ['order' => $order, 'has_file' => $order->hasContractorFinalReportPath()])
                                        </span>
                            </div>
                    </div>
                    @endif--}}

                    <div class="row">

                        @foreach($order_specialties as $_specialties)

                            <div class="card">
                                <div class="card-header">

                                    <h4 class="card-title">{{$_specialties[0]->service->specialties->name_ar}}
                                    </h4>

                                </div>

                                <div class="card-body">
                                    @foreach($_specialties as $service)

                                        <div class="row">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="service_id">توصيف
                                                            الخدمة</label>
                                                        <input type="text" disabled name="" id=""
                                                               class="form-control req "
                                                               value="{{$service->service->name}}" placeholder="">

                                                    </div>
                                                </div>

                                                <div class="col-lg-6 ">
                                                    <div class="mb-3 unit_hide">
                                                        <label
                                                            class="form-label">{{$service->service->unit}}</label>
                                                        <input type="text" disabled name="" id=""
                                                               class="form-control req " value="{{$service->unit}}"
                                                               placeholder="">
                                                        <div class="col-12 text-danger" id="service_id_error"></div>
                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                                        @if(!$loop->last)
                                            <hr>
                                        @endif
                                    @endforeach
                                    <div class="row mt-5">
                                        @foreach($filess->where('specialties.name_en',$_specialties[0]->service->specialties->name_en)
                                        as $files)

                                            @if($files->type ==1)
                                                <div class="col-xxl-2 col-lg-3 col-md-6">
                                                    <div class="panel panel-default bootcards-file">

                                                        <div class="list-group">
                                                            <div class="list-group-item text-center">
                                                                <div class="py-4">
                                                                    <i class="fa fa-file-pdf fa-4x"></i>
                                                                </div>
                                                                <h5 class="list-group-item-heading">
                                                                    {{$files->real_name}}
                                                                </h5>

                                                            </div>
                                                            <div class="list-group-item">
                                                                <a
                                                                    class="btn btn-success w-100"
                                                                    href="{{route('design_office.download',['id'=>$files->id])}}">
                                                                    <i class="fa fa-arrow-down"></i>
                                                                    تنزيل
                                                                </a>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            @endif
                                            @if($files->type ==2)
                                                <div class="col-xxl-2 col-lg-3 col-md-6">
                                                    <div class="panel panel-default bootcards-file">

                                                        <div class="list-group">
                                                            <div class="list-group-item text-center">
                                                                <div class="py-4">
                                                                    <i class="fa fa-file-pdf fa-4x"></i>
                                                                </div>
                                                                <h5 class="list-group-item-heading">
                                                                    {{$files->real_name}}
                                                                </h5>

                                                            </div>
                                                            <div class="list-group-item">
                                                                <a
                                                                    class="btn btn-success w-100"
                                                                    href="{{route('design_office.download',['id'=>$files->id])}}">
                                                                    <i class="fa fa-arrow-down"></i>
                                                                    تنزيل
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            @if($files->type ==3)
                                                <div class="col-xxl-2 col-lg-3 col-md-6">
                                                    <div class="panel panel-default bootcards-file">

                                                        <div class="list-group">
                                                            <div class="list-group-item text-center">
                                                                <div class="py-4">
                                                                    <i class="fa fa-file-pdf fa-4x"></i>
                                                                </div>
                                                                <h5 class="list-group-item-heading">
                                                                    {{$files->real_name}}
                                                                </h5>

                                                            </div>
                                                            <div class="list-group-item">
                                                                <a
                                                                    class="btn btn-success w-100"
                                                                    href="{{route('design_office.download',['id'=>$files->id])}}">
                                                                    <i class="fa fa-arrow-down"></i>
                                                                    تنزيل
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
{{--
                @if($order->is_accepted(auth()->user()))
                    <div
                        class="tab-pane"
                        id="reports"
                        role="tabpanel"
                    >
                        @include('CP.consulting_office.partials.reports',['order' => $order,'title' => __('attributes.reports')])
                    </div>
                @endif--}}
            </div>
        </div>


    </div>

    <div class="modal fade" id="agreement-modal" tabindex="-1" role="dialog" aria-labelledby="agreement-modal-title" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="agreement-modal-title">@lang('models/order.agreement_name')</h5>
                </div>
                <div class="modal-body">
                    <div class="row my-4" id="agreement-modal-row"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="close-agreement-modal" class="btn btn-secondary" data-dismiss="modal">إخفاء</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')
    <script>
        /**
         * Show agreement modal
         * @see \App\Http\Controllers\CP\Designer\DesignerOrderController::order_agreement_form
         */
        @if($order->isPendingOperation() && !$order->agreed)
        $(() => {
            $('.agreement-button').click(function (e) {
                e.preventDefault()

                showModal('{{route('design_office.order_agreement_form', ['order'=>$order->id])}}', function (data) {
                    let modal = $('#agreement-modal');
                    if (data.success) {
                        modal.html(data.page)
                        modal.modal({backdrop: 'static', keyboard: false})
                        modal.modal('show')
                    } else {
                        showAlertMessage('error', '@lang('constants.unknown_error')')
                    }
                    KTApp.unblockPage()
                }, '#agreement-modal')

                return false;
            })
        })
        @endif

        $(function () {
            /*$(document).on("hide.bs.modal", function (e) {
                console.log('-------------------- hide modal')
                if (document.querySelector('#agreed_checkbox').checked) {
                    e.preventDefault();
                    return false;
                }
            });*/

            $.fn.dataTable.ext.errMode = 'none'
            $('#items_table').DataTable({
                'dom': 'tpi',
                'searching': false,
                'processing': true,
                'stateSave': true,
                'serverSide': true,
                ajax: {
                    url: "{{route('consulting_office.contractor_list', ['order' => $order->id])}}",
                    type: 'GET',
                    'data': function (d) {
                        d.name = $('#name').val()
                        d.type = $('#type').val()

                    }
                },
                language: {
                    'url': "{{url('/')}}/assets/datatables/Arabic.json"
                },
                columns: [{
                    className: 'text-center',
                    data: 'title',
                    name: 'title'
                },
                    {
                        className: 'text-center',
                        data: 'description',
                        name: 'description'
                    },
                    {
                        className: 'text-center space-nowrap',
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        className: 'text-center',
                        data: 'actions',
                        name: 'actions'
                    }
                ]

            })
        })
        $('.search_btn').click(function (ev) {
            $('#items_table').DataTable().ajax.reload(null, false)
        })
    </script>

@endpush

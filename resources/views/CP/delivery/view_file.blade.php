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

        .file-view-wrapper:hover {
            box-shadow: var(--bs-box-shadow) !important;
        }

        .file-view-icon {
            height: 180px;
            background-size: 50%;
            background-position: center;
            background-repeat: no-repeat;
        }

        .file-view-wrapper {
            position: relative;
        }

        .file-view-download {
            position: absolute;
            top: 9px;
            left: 11px;
            font-size: 18px;
            color: #0b2473;
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

        .modal-backdrop.show {
            display: initial !important;
        }

        .modal-backdrop.fade {
            display: initial !important;
        }

        .fs-7 {
            font-size: 1rem;
        }

        .nav-link {
            padding: 0.6rem 1rem 0.8rem;
        }

        .card-custom {
            border-radius: 5px;
            box-shadow: 0px 30px 40px -20px #a3a5ae;
            background-color: #FFF;
            margin-bottom: 25px;
        }

        .card-custom .card-custom-content {
            padding: 40px 30px;
            border-top: 3px solid
        }

        .card-custom .card-custom-content.card-secondary {
            border-color: rgb(116, 120, 141);
        }

        .card-custom .card-custom-content.card-success {
            border-color: rgb(42, 181, 125);
        }

        .card-custom .card-custom-content.card-danger {
            border-color: rgb(253, 98, 94);
        }

        .card-custom .card-custom-content.card-secondary .card-custom-title {
            color: rgb(116, 120, 141);
        }

        .card-custom .card-custom-content .card-custom-text {
            font-weight: bold;
            font-size: 16px;
        }

        .card-custom .card-custom-content.card-success .card-custom-title,
        .card-custom .card-custom-content.card-success .card-custom-text {
            color: rgb(42, 181, 125) !important;

        }

        .card-custom .card-custom-content.card-danger .card-custom-title,
        .card-custom .card-custom-content.card-danger .card-custom-text {
            color: rgb(253, 98, 94) !important;
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

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-pills justify-content-center" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link px-3 active" data-bs-toggle="tab"
                               href="#details"
                               role="tab">تفاصيل الطلب</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link px-3" data-bs-toggle="tab"
                               href="#obligations"
                               role="tab">ملفات التعهدات</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link px-3" data-bs-toggle="tab"
                               href="#fire_protections_files"
                               role="tab">ملفات الوقاية والحماية من الحريق</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link px-3" data-bs-toggle="tab"
                               href="#notes"
                               role="tab">ملاحظات الجهات المشاركة</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link"
                               data-bs-toggle="tab"
                               href="#final_reports"
                               onclick="location.hash=this.getAttribute('href')"
                               role="tab"
                            >
                                <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                <span class="d-none d-sm-block">التقارير النهائية</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="tab-content">
                <div class="tab-pane active" id="details" role="tabpanel">

                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-0">التفاضيل</h4>
                        </div>

                        <div class="card-body">

                            <div class="row  mb-4 gx-0">
                                @if($designerNote && $order->isDesignReviewStatus())
                                    <div class="col-12">
                                        <p class="text-danger mb-0 space-nowrap p-3 border-bottom border-end fs-7"><span class="bold">سبب الرفض:</span> {!! nl2br($designerNote->note) !!}</p>
                                    </div>
                                @endif
                                <div class="col-md-6">
                                    <p class="mb-0 space-nowrap p-3 border-bottom border-end fs-7"><span class="bold">  تاريخ الإنشاء :</span> {{$order->created_at->format("Y-m-d")}}</p>
                                </div>

                                <div class="col-md-6">
                                    <p class="mb-0  p-3  border-bottom fs-7"><span class="bold">  رقم الطلب : </span>{{$order->identifier}}</p>
                                </div>

                                <div class="col-md-6">
                                    <p class="mb-0  p-3  border-bottom border-end fs-7"><span
                                            class="bold">مركز الخدمة :</span> {{ (isset($order->service_provider)) ? $order->service_provider->company_name : ''}}</p>
                                </div>

                                <div class="col-md-6">
                                    <p class="mb-0  p-3  border-bottom fs-7"><span
                                            class="bold"> اسم مكتب التصميم :  </span>{{ (isset($order->designer)) ? $order->designer->company_name : ''}}</p>
                                </div>

                                <div class="col-md-6 border-bottom border-end">
                                    <p class="mb-0  p-3 fs-7"><span
                                            class="bold"> مقاول النفايات :  </span>{{ $order->waste_contractor }}</p>
                                </div>
                                <div class="col-md-6 border-bottom">

                                </div>
                            </div>
                            <div class="row pt-3">
                                <div class="col-12">
                                    <h6 class="mb-3">
                                        <span>
                                            تخصصات المكتب الهندسي:
                                        </span>
                                    </h6>
                                    <ul class="m-0 list-unstyled list-group">
                                        @foreach($order->designer->designer_types as $designType)
                                            <li style="font-size: 18px;" class="list-group-item">
                                                - {{ get_designer_type_name($designType->type) }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                        </div>

                        @if(auth()->user()->type == \App\Models\User::DELIVERY_TYPE && $order->status == \App\Models\Order::DESIGN_REVIEW && $order->delivery_notes == 0)
                            <div class="row mt-4">
                                <div class="col-12 text-end">
                                    @if($order->allow_deliver == 1)
                                        {{-- TODO Check The Condition To Allow Accept Order --}}
                                    @endif
                                    @if($order->lastDesignerNote()->where('status',0)->count()==0)
                                        <button class="btn btn-primary" id="accept_order">اعتماد الطلب</button>
                                        <button
                                            onclick="showModal('{{ route('delivery.reject_form', ['id' => $order->id]) }}', {{ $order->id }})"
                                            class="btn btn-danger" id="reject_order">
                                            ارجاع ملاحظات
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endif

                    </div>
                </div>


                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">مكونات الاضافة</h4>
                    </div>
                    <div class="card-body">
                        @foreach($order_specialties as $_specialties)
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title mb-0">{{$_specialties[0]->service->specialties->name_ar??null}}</h4>
                                        </div>

                                        <div class="card-body">
                                            @foreach($_specialties as $service)
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="service_id">توصيف
                                                                الخدمة</label>
                                                            <input type="text" disabled name="" id="service_id"
                                                                   class="form-control req "
                                                                   value="{{$service->service->name??null}}"
                                                                   placeholder="">

                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3 unit_hide">
                                                            <label
                                                                class="form-label" for="service_id">{{$service->service->unit??null}}</label>
                                                            <input type="text" disabled name="" id="service_id"
                                                                   class="form-control req "
                                                                   value="{{$service->unit}}"
                                                                   placeholder="">
                                                            <div class="col-12 text-danger"
                                                                 id="service_id_error"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @if(!$loop->last)
                                                    <hr>
                                                @endif
                                            @endforeach
                                            <hr>
                                            <div class="row mt-5">
                                                @foreach($filess->where('specialties.name_en',$_specialties[0]->service->specialties->name_en??'none') as $files)

                                                    @if($files->type ==1)
                                                        <div class="col-md-6 col-lg-3">
                                                            <div class="panel panel-default bootcards-file">

                                                                <div class="list-group">
                                                                    <div class="list-group-item text-center">
                                                                        <div class="py-3 d-block">
                                                                            <img src="{{ asset("assets/images/pdf.png") }}" class="img-fluid" style="height:70px" alt="">
                                                                        </div>
                                                                        <h5 class="list-group-item-heading">
                                                                                {{$files->real_name}}
                                                                            </h5>

                                                                    </div>
                                                                    <div class="list-group-item">
                                                                        <a class="btn btn-success w-100"
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
                                                        <div class="col-md-offset-3 col-md-2">
                                                            <div class="panel panel-default bootcards-file">

                                                                <div class="list-group">
                                                                    <div class="list-group-item">
                                                                        <div class="py-3 d-block">
                                                                            <img src="{{ asset("assets/images/autocad.png") }}" class="img-fluid" style="height:70px" alt="">
                                                                        </div>
                                                                            <h5 class="list-group-item-heading ">
                                                                                {{$files->real_name}}
                                                                            </h5>

                                                                    </div>
                                                                        <div class="list-group-item">
                                                                            <a class="btn btn-success"
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
                                                                <div class="col-md-6 col-lg-3">
                                                                    <div class="panel panel-default bootcards-file">

                                                                        <div class="list-group">
                                                                            <div class="list-group-item text-center">
                                                                                <div class="py-3 d-block">
                                                                                    <img src="{{ asset("assets/images/docx.png") }}" class="img-fluid" style="height:70px" alt="">
                                                                                </div>
                                                                                <h5 class="list-group-item-heading">
                                                                                        {{$files->real_name}}
                                                                                    </h5>

                                                                            </div>
                                                                            <div class="list-group-item">
                                                                                <a class="btn btn-success w-100"
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
                                    </div>
                                </div>
                                @endforeach
                            </div>
                    </div>

                </div>
                <div class="tab-pane" id="obligations" role="tabpanel">

                        @foreach($order->obligations->groupBy("specialties_id") as $obligation)
                            <div class="card">
                                <div class="card-header">
                                    <h1 class="card-title">{{ $obligation->first()->specialty->name_ar }}</h1>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        @foreach($obligation as $obligationFile)
                                            <div class="col-lg-3 col-md-4 col-sm-6 col-12 my-2 file-view" style="cursor:pointer; height: 180px; width: 180px;">
                                                <a href="{{ route('obligation.download',['id'=>$obligationFile->id]) }}">
                                                    <div class="h-100 w-100 rounded border overflow-hidden file-view-wrapper d-block">
                                                        <div class="file-view-icon" style="background-image: url('{{ asset("assets/images/pdf-file.png") }}'); height: 140px;"></div>
                                                        <div class="file-view-download"><i class="fas fa-download"></i></div>
                                                        <div class="justify-content-center d-flex flex-column text-center border-top" style="height: 40px; background-color: #eeeeee;">
                                                            <small class="text-muted" style="font-size: 12px;">{{ get_obligation_name_by_type($obligationFile->type) }}</small>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        @endforeach
                                </div>
                            </div>
                </div>
                @endforeach
            </div>
            <div class="tab-pane" id="fire_protections_files" role="tabpanel">
                <div class="row">
                    @foreach($order->specialties_file->whereIn("type", [5,6,7,8]) as $file)
                        <div class="col-lg-3 col-md-4 col-sm-6 col-12 my-2 file-view" style="cursor:pointer;">
                            <a class="d-block bg-white" href="{{ route('order_speciality_file.download',['id'=>$file->id]) }}">
                                <div class="h-100 w-100 rounded border overflow-hidden file-view-wrapper d-block">
                                    <div class="file-view-icon" style="background-image: url('{{ asset("assets/images/pdf-file.png") }}'); height: 190px;"></div>
                                    <div class="file-view-download"><i class="fas fa-download"></i></div>
                                    <div class="justify-content-center d-flex flex-column text-center border-top" style="height: 40px; background-color: #eeeeee;">
                                        <small class="text-muted" style="font-size: 12px;">
                                            @if($file->type == 5)
                                                سلامة ارواح
                                            @elseif($file->type == 6)
                                                انذار
                                            @elseif($file->type == 7)
                                                اطفاء
                                            @else
                                                اخرى
                                            @endif
                                        </small>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="tab-pane" id="notes" role="tabpanel">
                <div class="row justify-content-center">
                    @foreach($order_sharers as $order_sharer)
                        <div class="col-md-4">
                            <div class="card-custom">
                                <div class="card-custom-content text-center
                                            @if($order_sharer->status == 1)
                                        card-success
                                            @elseif($order_sharer->status == 2)
                                        card-danger
                                            @elseif($order_sharer->status ==0)
                                        card-secondary
                                            @endif
                                                ">
                                    <p class="mb-3 p-0 card-custom-title" style="font-size: 20px; font-weight: bolder;">{{ $order_sharer->user->company_name }}</p>
                                    <p class="text-muted card-custom-text">( {{$order_sharer->order_sharer_status}} )</p>
                                </div>
                            @if($order_sharer->status == 2)
                                <div class="card-custom-body p-3 border-top">
                                    <p class="card-custom-desc mb-0">{{ $order_sharer->lastnote->note }}</p>
                                </div>
                            @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
    </div>
    </div>
    </div>

    <div class="modal fade bd-example-modal-lg" id="page_modal" data-backdrop="static" data-keyboard="false"
         role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    </div>

    <div class="modal fade" id="view-user-files-modal" tabindex="-1" role="dialog" aria-labelledby="view-user-files-modal-title" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="view-user-files-modal-title">مرفقات المستخدم</h5>
                </div>
                <div class="modal-body">
                    <div class="row my-4" id="file-view-row"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="close-view-files-modal" class="btn btn-secondary" data-dismiss="modal">إخفاء</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        $(() => {
            if (location.hash) {
                let activeTab = document.querySelector("[href='" + location.hash + "']")
                if (activeTab && activeTab.classList.contains('nav-link')) {
                    document.querySelectorAll('.nav-link.active, .tab-pane.active')
                        .forEach(x => x.classList.remove('active'))
                    activeTab.classList.add('active')
                    if ((activeTab = document.querySelector(location.hash))) {
                        activeTab.classList.add('active')
                    }
                }
            }
        })

        /**
         * Show create license modal
         * @see \App\Http\Controllers\CP\Licenses\LicenseController::order_license_form
         */
        @if($order->licenseNeededForDelivery())
        $(() => {
            showModal('{{route('licenses.order_license_form', ['order'=>$order->id])}}', null, '#view-user-files-modal')
        })
        @endif

        function reject() {
            showModal('{{ route('delivery.reject_form') }}', null, {{ $order->id }});
        }

        $("#accept_order").on('click', function () {

            let url = "{{ route('delivery.accept') }}";
            let data = {
                "_token": "{{ csrf_token() }}",
                "id": "{{$order->id}}"
            };

            $.ajax({
                url: url,
                data: data,
                type: "POST",
                dataType: 'json',
                success: function (data) {
                    if (data.success) {
                        showAlertMessage('success', data.message);
                        setTimeout(function () {
                            window.location.reload();
                        }, 500)
                    } else {
                        showAlertMessage('error', data.message);
                    }

                },
                error: function (data) {
                    showAlertMessage('error', 'حدث خطأ في اعتماد الطلب');
                },
            });


        });
        {{--$("#reject_order").on('click', function(){--}}

        {{--    let url = "{{ route('delivery.reject') }}";--}}
        {{--    let data = {--}}
        {{--        "_token" : "{{ csrf_token() }}",--}}
        {{--        "id" : "{{$order->id}}",--}}
        {{--        "note": "",--}}
        {{--    };--}}

        {{--    $.ajax({--}}
        {{--        url: url,--}}
        {{--        data: data,--}}
        {{--        type: "POST",--}}
        {{--        dataType: 'json',--}}
        {{--        success: function (data) {--}}
        {{--            if(data.success){--}}
        {{--                showAlertMessage('success', data.message);--}}
        {{--            }else{--}}
        {{--                showAlertMessage('error', data.message);--}}
        {{--            }--}}

        {{--        },--}}
        {{--        error: function (data) {--}}
        {{--           showAlertMessage('error', 'حدث خطأ في اعتماد الطلب');--}}
        {{--        },--}}
        {{--    });--}}


        {{--});--}}

        function copyNote(note) {
            $.ajax({
                url: '{{ route('delivery.copy_note') }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    order_id: {{ $order->id }},
                    note
                },
                type: "POST",
                dataType: 'json',
                success: function (data) {
                    if (data.success) {
                        showAlertMessage('success', data.message);
                        setTimeout(function () {
                            window.location.reload()
                        }, 500);
                    } else {
                        showAlertMessage('error', data.message);
                    }

                },
                error: function (data) {
                    showAlertMessage('error', 'حدث خطأ في اعتماد الطلب');
                },
            });
        }
    </script>

@endsection


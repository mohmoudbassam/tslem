@extends('CP.sharer_layout')
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

        .file-view-wrapper{
            position: relative;
        }
        .file-view-download{
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
    </style>
@endsection
@section('content')

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">


                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ url('Sharer/orders') }}">الطلبات</a></li>
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
                    <ul class="nav nav-tabs-custom  border-bottom" id="pills-tab" role="tablist">
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
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="details" role="tabpanel">
                            <div class="row">
                                <div class="col-md-6 my-3">
                                    <p class="details_p"><span class="bold">  التاريخ :</span> {{$order->created_at->format("Y-m-d")}}</p>
                                </div>

                                <div class="col-md-6 my-3">
                                    <p class="details_p"><span class="bold">  رقم الطلب : </span>{{$order->identifier}}</p>
                                </div>

                                <div class="col-md-6 my-3">
                                    <p class="details_p"><span
                                            class="bold">مركز الخدمة :</span> {{isset($order->service_provider) ? $order->service_provider->company_name: ''}}</p>
                                </div>

                                <div class="col-md-6 my-3">
                                    <p class="details_p"><span
                                            class="bold"> اسم مكتب التصميم :  </span>{{isset($order->designer) ? $order->designer->company_name: ''}}</p>
                                </div>

                                <div class="col-12">
                                    <p class="details_p">
                                        <span>
                                            تخصصات المكتب الهندسي:
                                        </span>
                                    </p>
                                    <ul class="m-0">
                                        @if (isset($order->designer))
                                            @foreach($order->designer->designer_types as $designType)
                                                <li style="font-size: 20px;">
                                                    {{ $designType->type }}
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                            </div>

                            @if(auth()->user()->type == \App\Models\User::SHARER_TYPE )
                                <div class="offset-md-9 col-md-3 mb-3">
                                    @if( isset($order_sharer->status) )
                                        @if($order_sharer->status ==0)
                                            <button class="btn btn-primary" id="accept_order">اعتماد الطلب</button>
                                        @endif
                                        @if($order_sharer->status ==0)
                                            <button
                                                onclick="showModal('{{ route('Sharer.reject_form', ['id' => $order->id]) }}', {{ $order->id }})"
                                                class="btn btn-danger" id="reject_order">ارجاع ملاحظات
                                            </button>
                                        @endif
                                    @endif
                                </div>
                            @endif

                            @if(auth()->user()->type == \App\Models\User::DELIVERY_TYPE && $order->status == \App\Models\Order::DESIGN_REVIEW && $order->delivery_notes == 0)
                                <div class="row mt-5">
                                    <div class="col-12">
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
                            @foreach($order_specialties as $_specialties)
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title">{{$_specialties[0]->service->specialties->name_ar}}</h4>
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
                                                                       value="{{$service->service->name}}"
                                                                       placeholder="">

                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3 unit_hide">
                                                                <label
                                                                    class="form-label" for="service_id">{{$service->service->unit}}</label>
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
                                                <div class="row mt-5">
                                                    @foreach($filess->where('specialties.name_en',$_specialties[0]->service->specialties->name_en) as $files)

                                                        @if($files->type ==1)
                                                            <div class="col-md-offset-3 col-md-2">
                                                                <div class="panel panel-default bootcards-file">

                                                                    <div class="list-group">
                                                                        <div class="list-group-item">
                                                                            <a href="#">
                                                                                <i class="fa fa-file-pdf fa-4x"></i>
                                                                            </a>
                                                                            <h5 class="list-group-item-heading">
                                                                                <a href="{{route('design_office.download',['id'=>$files->id])}}">
                                                                                    {{$files->real_name}}
                                                                                </a>
                                                                            </h5>

                                                                        </div>
                                                                        <div class="list-group-item">
                                                                        </div>
                                                                    </div>
                                                                    <div class="panel-footer">
                                                                        <div class="btn-group btn-group-justified">
                                                                            <div class="btn-group">
                                                                                <a class="btn btn-success"
                                                                                   href="{{route('design_office.download',['id'=>$files->id])}}">
                                                                                    <i class="fa fa-arrow-down"></i>
                                                                                    تنزيل
                                                                                </a>
                                                                            </div>


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
                                                                            <a href="{{route('design_office.download',['id'=>$files->id])}}">
                                                                                <i class="fa fa-file-pdf fa-4x"></i>
                                                                            </a>
                                                                            <h5 class="list-group-item-heading">
                                                                                <a href="#">
                                                                                    {{$files->real_name}}
                                                                                </a>
                                                                            </h5>

                                                                        </div>
                                                                        <div class="list-group-item">
                                                                        </div>
                                                                    </div>
                                                                    <div class="panel-footer">
                                                                        <div class="btn-group btn-group-justified">
                                                                            <div class="btn-group">
                                                                                <a class="btn btn-success"
                                                                                   href="{{route('design_office.download',['id'=>$files->id])}}">
                                                                                    <i class="fa fa-arrow-down"></i>
                                                                                    تنزيل
                                                                                </a>
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                        @if($files->type ==3)
                                                            <div class="col-md-offset-3 col-md-2">
                                                                <div class="panel panel-default bootcards-file">

                                                                    <div class="list-group">
                                                                        <div class="list-group-item">
                                                                            <a href="#">
                                                                                <i class="fa fa-file-pdf fa-4x"></i>
                                                                            </a>
                                                                            <h5 class="list-group-item-heading">
                                                                                <a href="#">
                                                                                    {{$files->real_name}}
                                                                                </a>
                                                                            </h5>

                                                                        </div>
                                                                        <div class="list-group-item">
                                                                        </div>
                                                                    </div>
                                                                    <div class="panel-footer">
                                                                        <div class="btn-group btn-group-justified">
                                                                            <div class="btn-group">
                                                                                <a class="btn btn-success"
                                                                                   href="{{route('design_office.download',['id'=>$files->id])}}">
                                                                                    <i class="fa fa-arrow-down"></i>
                                                                                    تنزيل
                                                                                </a>
                                                                            </div>


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
                        <div class="tab-pane" id="obligations" role="tabpanel">

                            @foreach($order->obligations->groupBy("specialties_id") as $obligation)
                                <div class="row">
                                    <div class="card">
                                        <div class="card-header">
                                            <h1 class="card-title">{{ $obligation->first()->specialty->name_ar }}</h1>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                @foreach($obligation as $obligationFile)
                                                    <div class="col-lg-3 col-md-4 col-sm-6 col-12 my-2 file-view" style="cursor:pointer; height: 180px; width: 180px;">
                                                        <a href="{{ asset("storage/".$obligationFile->path) }}">
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
                                </div>
                            @endforeach
                        </div>
                        <div class="tab-pane" id="fire_protections_files" role="tabpanel">
                            <div class="row">
                                @foreach($order->specialties_file->whereIn("type", [5,6,7,8]) as $file)
                                    <div class="col-lg-3 col-md-4 col-sm-6 col-12 my-2 file-view" style="cursor:pointer; height: 180px; width: 180px;">
                                        <a href="{{ asset("storage/".$file->path) }}" download="">
                                            <div class="h-100 w-100 rounded border overflow-hidden file-view-wrapper d-block">
                                                <div class="file-view-icon" style="background-image: url('{{ asset("assets/images/pdf-file.png") }}'); height: 140px;"></div>
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
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade  bd-example-modal-lg" id="page_modal" data-backdrop="static" data-keyboard="false"
         role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    </div>

@endsection

@section('scripts')
    <script>

        function reject() {
            showModal('{{ route('Sharer.reject_form') }}', null, {{ $order->id }});
        }

        $("#accept_order").on('click', function () {

            let url = "{{ route('Sharer.accept') }}";
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
                        setTimeout(function(){
                            window.location.reload()
                        },500);
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


    </script>

@endsection


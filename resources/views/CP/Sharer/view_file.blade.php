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
                        <li class="breadcrumb-item"><a href="javascript: void(0);">الطلبات</a></li>
                        <li class="breadcrumb-item active">الرئيسية</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="row">

                <div class="col-md-4 mb-3 mt-4">
                    <h2>تفاصيل الطلب</h2>
                </div>
                <div class="col-md-4 mb-3 mt-4">
                    <p class="details_p"><span class="bold">  التاريخ :</span> {{$order->created_at}}</p>
                </div>

            <!-- <h2> مقدم الخدمة :{{$order->service_provider->name}}</h2> -->
            </div>

            <div class="row">

                <div class="col-md-6 mb-3">
                    <p class="details_p"><span class="bold">  رقم الطلب : </span>{{$order->identifier}}</p>
                </div>


                <div class="col-md-6 mb-3">
                    <p class="details_p"><span class="bold">  العنوان : </span>{{$order->title}}</p>
                </div>


                <div class="col-md-6 mb-3">
                    <p class="details_p"><span class="bold">مراكز الخدمة :</span> {{$order->service_provider->name}}
                    </p>
                </div>

                <div class="col-md-6 mb-3">
                    <p class="details_p"><span class="bold">   التفاصيل : </span>{{$order->description}}</p>
                </div>

                <div class="col-md-6 mb-3">
                    <p class="details_p"><span class="bold"> اسم المكتب الهندسي :  </span>{{$order->designer->name}}</p>
                </div>

                @if(auth()->user()->type == \App\Models\User::SHARER_TYPE )
                    <div class="offset-md-9 col-md-3 mb-3">
                        @if($order_sharer->status ==0)
                            <button class="btn btn-primary" id="accept_order">اعتماد الطلب</button>
                        @endif
                        @if($order_sharer->status ==0)
                            <button
                                onclick="showModal('{{ route('Sharer.reject_form', ['id' => $order->id]) }}', {{ $order->id }})"
                                class="btn btn-danger" id="reject_order">ارجاع ملاحظات
                            </button>
                        @endif
                    </div>
                @endif
            </div>

        </div>
        <div class="card-body">

            <div class="row">

                @foreach($order_specialties as $_specialties)

                    <div class="card">
                        <div class="card-header">

                            <h4 class="card-title">{{$_specialties[0]->service->specialties->name_ar}}</h4>

                        </div>

                        <div class="card-body">
                            @foreach($_specialties as $service)

                                <div class="row">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label" for="service_id">توصيف
                                                    الخدمة</label>
                                                <input type="text" disabled name="" id="" class="form-control req "
                                                       value="{{$service->service->name}}"
                                                       placeholder="">

                                            </div>
                                        </div>


                                        <div class="col-md-3 ">
                                            <div class="mb-3 unit_hide">
                                                <label
                                                    class="form-label">{{$service->service->unit}}</label>
                                                <input type="text" disabled name="" id="" class="form-control req "
                                                       value="{{$service->unit}}"
                                                       placeholder="">
                                                <div class="col-12 text-danger"
                                                     id="service_id_error"></div>
                                            </div>
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
                @endforeach
            </div>
        </div>

    </div>
    <div class="modal  bd-example-modal-lg" id="page_modal" data-backdrop="static" data-keyboard="false"
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


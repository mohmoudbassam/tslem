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
    </style>
@endsection
@section('content')

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">


                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">الرئيسية</li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">الطلبات</a></li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-pills justify-content-start" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link px-3 active" data-bs-toggle="tab" href="#details" role="tab">تفاصيل الطلب</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">التفاضيل</h4>
                </div>

                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="details"
                             role="tabpanel">
                            <table class="table table-bordered">
                                <tbody>
                                @if($designerNote && $order->isDesignReviewStatus())
                                    <tr>
                                        <td width="50%"><span class="bold">  سبب الرفض :</span> {!! nl2br($designerNote->note) !!}</td>
                                    </tr>
                                @endif
                                <tr>
                                    <td width="50%"><span class="bold">  التاريخ :</span> {{$order->created_at->format("Y-m-d")}}</td>
                                    <td width="50%"><span class="bold">  رقم الطلب : </span>{{$order->identifier}}</td>
                                </tr>
                                <tr>
                                    @if($order->service_provider->raft_company_name)
                                        <td width="50%"><span class="bold">مركز الخدمة :</span> {{ $order->service_provider->raft_company_name }}</td>
                                    @endif
                                    <td width="50%"><span class="bold">رقم هاتف مركز الخدمة :</span> {{$order->service_provider->phone}}</td>
                                </tr>
                                <tr>
                                    <td width="50%"><span class="bold">البريد الإلكتروني بمركز الخدمة :</span> {{$order->service_provider->email}}</td>
                                    <td width="50%"><span class="bold"> اسم مكتب التصميم :  </span>{{$order->designer->company_name}}</td>
                                </tr>
                                </tbody>
                            </table>
                            <div class="row mt-5">
                                @if($order->status == \App\Models\Order::PENDING)
                                    <div class="col-12 text-end">

                                        <a class="btn btn-primary"
                                           href="{{route('design_office.accept',['order'=>$order->id])}}">قبول
                                            الطلب</a>
                                        <a class="btn btn-danger" id="reject-order-btn" data-order="{{ $order->id }}" href="#">
                                            رفض الطلب
                                        </a>
                                    </div>
                                @endif
                                <div class="col-12 text-end">
                                    @if(intval($order->status) >= intval(\App\Models\Order::PENDING_OPERATION))
                                        <a id="license-type-1-button" class="btn btn-primary license-type-1-button mx-1" target="_blank" href="{{route('licenses.view_pdf', ['order'=>$order->id])}}">
                                            <i class="fa fa-arrow-down pe-2"></i>
                                            {{\App\Models\License::trans('download_for_service_provider')}}
                                        </a>
                                    @endif
                                    @if(intval($order->status) >= intval(\App\Models\Order::FINAL_LICENSE_GENERATED))
                                        <a id="license-type-2-button" class="btn btn-primary license-type-2-button mx-1" target="_blank" href="{{route('licenses.view_pdf_execution_license', ['order'=>$order->id])}}">
                                            <i class="fa fa-arrow-down pe-2"></i>
                                            {{\App\Models\License::trans('download_execution_license_for_service_provider')}}
                                        </a>
                                    @endif
                                </div>
                            </div>

                            <div class="row">
                                @if($order_specialties)
                                    @foreach($order_specialties as $_specialties)
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h4 class="card-title">{{$_specialties[0]->service->specialties->name_ar}}</h4>
                                                    </div>
                                                    <div class="card-body">
                                                        @foreach($_specialties as $service)

                                                            <div class="row">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="mb-3">
                                                                            <label class="form-label" for="service_id">توصيف
                                                                                الخدمة</label>
                                                                            <input type="text" disabled name="" id=""
                                                                                   class="form-control req "
                                                                                   value="{{$service->service->name}}"
                                                                                   placeholder="">

                                                                        </div>
                                                                    </div>


                                                                    <div class="col-md-6 ">
                                                                        <div class="mb-3 unit_hide">
                                                                            <label
                                                                                class="form-label">{{$service->service->unit}}</label>
                                                                            <input type="text" disabled name="" id=""
                                                                                   class="form-control req "
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
                                                                    <div class="col-md-6 col-lg-3">
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
                                                                    <div class="col-md-6 col-lg-3">
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
                                                                @if($files->type ==3)
                                                                    <div class="col-md-6 col-lg-3">
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
                                @endif
                                {{--                @if($files->where('type',5)->exists())--}}
                                {{--                    <div class="card">--}}
                                {{--                        <div class="card-header">--}}
                                {{--                            <h4 class="bold">ملف الموقع العام</h4>--}}
                                {{--                        </div>--}}
                                {{--                        <div class="card-body">--}}
                                {{--                            <div class="col-md-offset-3 col-md-2">--}}
                                {{--                                <div class="panel panel-default bootcards-file">--}}

                                {{--                                    <div class="list-group">--}}
                                {{--                                        <div class="list-group-item">--}}
                                {{--                                            <a href="{{route('design_office.download',['id'=>$files->where('type',5)->first()->id])}}">--}}
                                {{--                                                <i class="fa fa-file-pdf fa-4x"></i>--}}
                                {{--                                            </a>--}}
                                {{--                                            <h5 class="list-group-item-heading">--}}
                                {{--                                                <a href="#">--}}
                                {{--                                                    {{$files->where('type',5)->first()->real_name}}--}}
                                {{--                                                </a>--}}
                                {{--                                            </h5>--}}

                                {{--                                        </div>--}}
                                {{--                                        <div class="list-group-item">--}}
                                {{--                                        </div>--}}
                                {{--                                    </div>--}}
                                {{--                                    <div class="panel-footer">--}}
                                {{--                                        <div class="btn-group btn-group-justified">--}}
                                {{--                                            <div class="btn-group">--}}
                                {{--                                                <a class="btn btn-success"--}}
                                {{--                                                   href="{{route('design_office.download',['id'=>$files->where('type',5)->first()->id])}}">--}}
                                {{--                                                    <i class="fa fa-arrow-down"></i>--}}
                                {{--                                                    تنزيل--}}
                                {{--                                                </a>--}}
                                {{--                                            </div>--}}

                                {{--                                        </div>--}}
                                {{--                                    </div>--}}
                                {{--                                </div>--}}
                                {{--                            </div>--}}
                                {{--                        </div>--}}
                                {{--                    </div>--}}
                                {{--                @endif--}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($order->status == \App\Models\Order::PENDING)
        <div class="modal fade" id="rejection-note-modal" tabindex="-1" role="dialog" aria-labelledby="rejection-note" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="rejection-note-modal-title">ملاحظات رفض الطلب</h5>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route("design_office.reject", [$order->id]) }}" id="rejection-order-form">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="col-form-label required-field" for="rejection-note">ملاحظات رفض الطلب</label>
                                        <textarea class="form-control mb-1" id="rejection-note" name="rejection_note" placeholder="ملاحظات رفض الطلب" rows="10" style="resize: none;" required></textarea>
                                        <span class="text-danger" id="rejection-note-error"></span>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="submit" id="submit-rejection-note" class="btn btn-danger" form="rejection-order-form" data-dismiss="modal">رفض</button>
                        <button type="button" id="close-rejection-note-modal" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

@endsection



@push("js")
    <script>
        $(function () {
            const rejectOrderButton = $("#reject-order-btn");
            rejectOrderButton.on("click", function (event) {
                event.preventDefault();
                $("#rejection-note-modal").modal("show");
            });

            $("#close-rejection-note-modal").on("click", function () {
                $("#rejection-note-modal").modal("hide");
            });

            $('#rejection-note-modal').on('hidden.bs.modal', function (e) {
                $("#rejection-note").val("");
            });

            $('#rejection-order-form').validate({
                lang: 'ar',
                rules: {
                    "rejection-note": {
                        required: true,
                        alphanumeric: true
                    }
                },
                errorElement: 'span',
                errorClass: 'help-block help-block-error',
                focusInvalid: true,
                errorPlacement: function (error, element) {
                    $(element).addClass("is-invalid");
                    error.appendTo('#' + $(element).attr('id') + '-error');
                },
                success: function (label, element) {
                    $(element).removeClass("is-invalid");
                }
            });

            $("#submit-rejection-note").on("click", function (event) {
                event.preventDefault();
                if (!$("#rejection-order-form").valid()) {
                    showAlertMessage('error', "من فضلك ادخل ملاحظات رفض الطلب");
                    return false;
                }


                $("#rejection-order-form").submit();
            });
        });
    </script>
@endpush

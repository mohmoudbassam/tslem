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

file-drop-zone clearfix {}

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
            <div class="col-xl-12">
                <div class="card">


                    <div class="card-body">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#details" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                    <span class="d-none d-sm-block">تفاصيل الطلب</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#reports" role="tab">
                                    <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                    <span class="d-none d-sm-block">تقارير الإنجاز الدورية</span>
                                </a>
                            </li>

                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content p-3 text-muted">
                            <div class="tab-pane active" id="details" role="tabpanel">





                                <div class="row">

                                    <div class="col-md-6 mb-3">
                                        <p class="details_p"> <span class="bold"> رقم الطلب : </span>{{$order->id}}</p>
                                    </div>


                                    <div class="col-md-6 mb-3">
                                        <p class="details_p"> <span class="bold"> التاريخ: </span>{{$order->created_at}}
                                        </p>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <p class="details_p"> <span class="bold"> العنوان : </span>{{$order->title}}</p>
                                    </div>



                                    <div class="col-md-6 mb-3">
                                        <p class="details_p"><span class="bold">اسم مقدم الخدمة :</span>
                                            {{$order->service_provider->name}}</p>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <p class="details_p"> <span class="bold"> التفاصيل :
                                            </span>{{$order->description}}</p>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <p class="details_p"> <span class="bold"> اسم مكتب التصميم :
                                            </span>{{$order->designer->name}}</p>
                                    </div>

{{--                                    <div class="offset-md-9 col-md-3 mb-3">--}}
{{--                                        <button class="btn btn-success" id="complete_order">اتمام الطلب</button>--}}
{{--                                    </div>--}}

                                </div>

                                @if(!$order->isConsultingOfficeFinalReportApproved() && $order->userCanAttachFinalReport())
                                    <div class="row">
                                        <div class="col-md-12 my-3 text-end">
                                            <div class="bold border col-md-12 my-3 p-2 rounded-start {{($consulting_office_note = $order->getConsultingOfficeFinalReportNote()) ? "bg-soft-danger border-danger text-danger " : ""}}">
                                        <span class="float-start">
                                            {{$consulting_office_note ?: '-'}}
                                        </span>
                                                @include('CP.order.final_report_button', ['order' => $order, 'has_file' => $order->hasConsultingOfficeFinalReportPath()])
                                            </div>
                                        </div>
                                    </div>
                                @endif

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
                                                    <div class="col-md-3">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="service_id">توصيف
                                                                الخدمة</label>
                                                            <input type="text" disabled name="" id=""
                                                                class="form-control req "
                                                                value="{{$service->service->name}}" placeholder="">

                                                        </div>
                                                    </div>


                                                    <div class="col-md-3 ">
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
                                                <div class="col-md-offset-3 col-md-2">
                                                    <div class="panel panel-default bootcards-file">

                                                        <div class="list-group">
                                                            <div class="list-group-item">
                                                                <a href="#">
                                                                    <i class="fa fa-file-pdf fa-4x"></i>
                                                                </a>
                                                                <h5 class="list-group-item-heading">
                                                                    <a
                                                                        href="{{route('design_office.download',['id'=>$files->id])}}">
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
                                                                <a
                                                                    href="{{route('design_office.download',['id'=>$files->id])}}">
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
                            <div class="tab-pane" id="reports" role="tabpanel">
                                <!-- start page title -->
                                <div class="card">
                                    <div class="card-header">
                                        <div class="row mt-4">
                                            <div class="col-lg-12">

                                                <form class="row gx-3 gy-2 align-items-center mb-4 mb-lg-0">
                                                    <div class="col-lg-4">
                                                        <label class="visually-hidden" for="specificSizeInputName">الاسم
                                                            او البريد</label>
                                                        <input type="text" class="form-control" id="name"
                                                            placeholder="الاسم او البريد">
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <label class="visually-hidden" for="type"></label>
                                                        <select class="form-control" id="type" name="type">
                                                            <option value="">اختر...</option>
                                                            <option value="admin">مدير نظام</option>
                                                            <option value="service_provider">مقدم خدمة</option>
                                                            <option value="design_office">مكتب تصميم</option>
                                                            <option value="Sharer">جهة مشاركة</option>
                                                            <option value="consulting_office">مكتب استشاري</option>
                                                            <option value="contractor">مقاول</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-sm-auto">
                                                        <button type="button"
                                                            class="btn btn-primary search_btn">بحث</button>
                                                    </div>
                                                </form>
                                            </div>


                                        </div>
                                    </div>
                                    <div class="card-body">

                                        <div class="row">

                                            <div class="col-sm-12">
                                                <table
                                                    class="table align-middle datatable dt-responsive table-check nowrap dataTable no-footer"
                                                    id="items_table"
                                                    style="border-collapse: collapse; border-spacing: 0px 8px; width: 100%;"
                                                    role="grid" aria-describedby="DataTables_Table_0_info">
                                                    <thead>
                                                        <th>
                                                            عنوان الطلب
                                                        </th>
                                                        <th>
                                                            مقدم الخدمة
                                                        </th>
                                                        <th>
                                                            مكتب التصميم
                                                        </th>
                                                        <th>
                                                            التاريخ
                                                        </th>
                                                        <th>
                                                            حالة الطلب
                                                        </th>
                                                        <th>
                                                            تاريخ الإنشاء
                                                        </th>
                                                        <th>
                                                            الخيارات
                                                        </th>


                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>


                                        </div>
                                    </div>

                                </div>

                                <div class="modal  bd-example-modal-lg" id="page_modal" data-backdrop="static"
                                    data-keyboard="false" role="dialog" aria-labelledby="exampleModalCenterTitle"
                                    aria-hidden="true">
                                </div>


                            </div>


                        </div>
                    </div><!-- end card-body -->
                </div><!-- end card -->
            </div><!-- end col -->
        </div><!-- end row -->




    </div>


</div>


@endsection

@section('scripts')
<script>
    $("#complete_order").on('click', function() {

        let url = "{{ route('consulting_office.complete') }}";
        let data = {
            "_token": "{{ csrf_token() }}",
            "id": "{{$order->id}}"
        };

        $.ajax({
            url: url,
            data: data,
            type: "POST",
            dataType: 'json',
            success: function(data) {
                if (data.success) {
                    showAlertMessage('success', data.message);
                } else {
                    showAlertMessage('error', data.message);
                }

            },
            error: function(data) {
                showAlertMessage('error', 'حدث خطأ في اتمام الطلب');
            },
        });


    });


    $.fn.dataTable.ext.errMode = 'none';
    $(function() {
        $('#items_table').DataTable({
            "dom": 'tpi',
            "searching": false,
            "processing": true,
            'stateSave': true,
            "serverSide": true,
            ajax: {
                url: "{{route('consulting_office.contractor_list', ['order' => $order->id])}}",
                type: 'GET',
                "data": function(d) {
                    d.name = $('#name').val();
                    d.type = $('#type').val();

                }
            },
            language: {
                "url": "{{url('/')}}/assets/datatables/Arabic.json"
            },
            columns: [{
                    className: 'text-center',
                    data: 'title',
                    name: 'title'
                },
                {
                    className: 'text-center',
                    data: 'service_provider.company_name',
                    name: 'company_name'
                },
                {
                    className: 'text-center',
                    data: 'designer.company_name',
                    name: 'company_name'
                },
                {
                    className: 'text-center  space-nowrap',
                    data: 'date',
                    name: 'date'
                },
                {
                    className: 'text-center',
                    data: 'order_status',
                    name: 'order_status'
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
                },
            ],


        });

    });
    $('.search_btn').click(function(ev) {
        $('#items_table').DataTable().ajax.reload(null, false);
    });
</script>

@endsection

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
    </style>
@endsection
@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="{{route('contractor.orders')}}">@lang('attributes.orders')</a>
                        </li>
                        <li class="breadcrumb-item active">
                            @lang('attributes.view_order')
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <!-- Nav tabs -->
            <ul
                class="nav nav-tabs"
                role="tablist"
            >
                <li class="nav-item">
                    <a
                        class="nav-link active"
                        data-bs-toggle="tab"
                        href="#details"
                        role="tab"
                    >
                        <span class="d-block d-sm-none">
                            <i class="fas fa-home"></i>
                        </span>
                        <span class="d-none d-sm-block">تفاصيل الطلب</span>
                    </a>
                </li>
                @if($order->is_accepted(auth()->user()))
                    <li class="nav-item">
                        <a
                            class="nav-link"
                            data-bs-toggle="tab"
                            href="#reports"
                            role="tab"
                        >
                            <span class="d-block d-sm-none">
                                <i class="fas fa-home"></i>
                            </span>
                            <span class="d-none d-sm-block">التقارير</span>
                        </a>
                    </li>
                @endif
            </ul>
            <!-- Tab panes -->
            <div class="tab-content p-3 text-muted">
                <div
                    class="tab-pane active"
                    id="details"
                    role="tabpanel"
                >
                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <p class="details_p">
                                <span class="bold"> رقم الطلب :</span>{{$order->identifier}}</p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <p class="details_p">
                                <span class="bold"> التاريخ:</span>{{$order->created_at->format("Y-m-d")}}
                            </p>
                        </div>

                        @if($order->service_provider->raft_company_name)
                            <div class="col-md-6 my-3">
                                <p class="details_p">
                                    <span
                                        class="bold"
                                    >مركز الخدمة :
                                    </span> {{ $order->service_provider->raft_company_name }}</p>
                            </div>
                        @endif
                        <div class="col-md-6 my-3">
                            <p class="details_p">
                                <span
                                    class="bold"
                                >رقم هاتف مركز الخدمة :
                                </span> {{$order->service_provider->phone}}</p>
                        </div>

                        <div class="col-md-6 my-3">
                            <p class="details_p">
                                <span
                                    class="bold"
                                >البريد الإلكتروني لمركز الخدمة :
                                </span> {{$order->service_provider->email}}</p>
                        </div>

                        <div class="col-md-6 my-3">
                            <p class="details_p">
                                <span
                                    class="bold"
                                > اسم المشرف :
                                </span>{{$order->designer->company_name}}</p>
                        </div>

                    </div>

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
                                                        <label
                                                            class="form-label"
                                                            for="service_id"
                                                        >توصيف
                                                            الخدمة
                                                        </label>
                                                        <input
                                                            type="text"
                                                            disabled
                                                            name=""
                                                            id=""
                                                            class="form-control req "
                                                            value="{{$service->service->name}}"
                                                            placeholder=""
                                                        >

                                                    </div>
                                                </div>

                                                <div class="col-md-3 ">
                                                    <div class="mb-3 unit_hide">
                                                        <label
                                                            class="form-label"
                                                        >{{$service->service->unit}}</label>
                                                        <input
                                                            type="text"
                                                            disabled
                                                            name=""
                                                            id=""
                                                            class="form-control req "
                                                            value="{{$service->unit}}"
                                                            placeholder=""
                                                        >
                                                        <div
                                                            class="col-12 text-danger"
                                                            id="service_id_error"
                                                        ></div>
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
                                                                        href="{{route('design_office.download',['id'=>$files->id])}}"
                                                                    >
                                                                        {{$files->real_name}}
                                                                    </a>
                                                                </h5>

                                                            </div>
                                                            <div class="list-group-item"></div>
                                                        </div>
                                                        <div class="panel-footer">
                                                            <div class="btn-group btn-group-justified">
                                                                <div class="btn-group">
                                                                    <a
                                                                        class="btn btn-success"
                                                                        href="{{route('design_office.download',['id'=>$files->id])}}"
                                                                    >
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
                                                                    href="{{route('design_office.download',['id'=>$files->id])}}"
                                                                >
                                                                    <i class="fa fa-file-pdf fa-4x"></i>
                                                                </a>
                                                                <h5 class="list-group-item-heading">
                                                                    <a href="#">
                                                                        {{$files->real_name}}
                                                                    </a>
                                                                </h5>

                                                            </div>
                                                            <div class="list-group-item"></div>
                                                        </div>
                                                        <div class="panel-footer">
                                                            <div class="btn-group btn-group-justified">
                                                                <div class="btn-group">
                                                                    <a
                                                                        class="btn btn-success"
                                                                        href="{{route('design_office.download',['id'=>$files->id])}}"
                                                                    >
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
                                                            <div class="list-group-item"></div>
                                                        </div>
                                                        <div class="panel-footer">
                                                            <div class="btn-group btn-group-justified">
                                                                <div class="btn-group">
                                                                    <a
                                                                        class="btn btn-success"
                                                                        href="{{route('design_office.download',['id'=>$files->id])}}"
                                                                    >
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

                    @if($order->is_accepted(auth()->user()))
                    <div
                        class="tab-pane"
                        id="reports"
                        role="tabpanel"
                    >
                        @include('CP.contractors.reports_list', [
                        'reports' => $order->contractor_report,
                        'order'   => $order,
                        'title'   => __("attributes.order_reports"),
                        ])
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>

        $.fn.dataTable.ext.errMode = 'none'
        $(function () {
            $('#items_table').DataTable({
                'dom': 'tpi',
                'searching': false,
                'processing': true,
                'stateSave': true,
                'serverSide': true,
                ajax: {
                    url: "{{route('contractor.list_orders', ['order' => $order->id])}}",
                    type: 'GET',
                    'data': function (d) {
                        d.name = $('#name').val()
                        d.type = $('#type').val()

                    }
                },
                language: {
                    'url': "{{url('/')}}/assets/datatables/Arabic.json"
                },
                columns: [
                    {
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

@endsection
